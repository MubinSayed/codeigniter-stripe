<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StripeController extends CI_Controller
{
    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->model('transaction');
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index()
    {
        $this->load->view('stripe-form');
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function stripePost()
    {
        //include Stripe PHP library
        require_once APPPATH . "third_party/stripe-php/init.php";

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        $message = null;
        $success = false;
        $charge = null;
        $data = array();

        try {

            //Creates timestamp that is needed to make up orderid
            $timestamp = strftime("%Y%m%d%H%M%S");
            //You can use any alphanumeric combination for the orderid. Although each transaction must have a unique orderid.
            $orderid = $timestamp . "-" . mt_rand(1, 999);

            //charge a credit or a debit card
            $charge = \Stripe\Charge::create([
                "amount" => $this->input->post('totalDonationAmount') * 100,
                "currency" => "gbp",
                "source" => $this->input->post('stripeToken'),
                "description" => "TEST PAYMENT",
                'metadata' => array(
                    'order_id' => $orderid,
                ),
            ]);
            
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err = $body['error'];

            /* print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");

            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n"); */

            $message = $err['message'];

        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }
        
        if ($charge) {
            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();

            //check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {

                // insert response into db
                $this->transaction->response = $chargeJson;
                $this->transaction->insert();

                $data = [
                    'balance_transaction' => $chargeJson['balance_transaction'],
                    'receipt_url' => $chargeJson['receipt_url'],
                    'order_id' => $orderid,
                ];

                $success = true;
                $message = 'Payment made successfully.';

            } else {

                $success = true;
                $message = 'Something went wrong.';
            }
        }

        if ($success) {
            echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
        } else {
            $message = 'Something went wrong.';
            echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
        }
    }
}
