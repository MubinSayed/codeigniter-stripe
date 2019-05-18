<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Model
{
    public $response;
    public $created_at;

    public function get_last_ten_transactions()
    {
        $query = $this->db->get('transactions', 10);
        return $query->result();
    }

    public function insert_transaction()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->db->insert('transactions', $this);
    }

}
