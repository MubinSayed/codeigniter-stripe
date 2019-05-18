<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Payment Page</title>
    <link rel="shortcut icon" href="favicon.ico">

    <!-- build:css -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- endbuild -->

    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-info fixed-top">
        <div class="container">
            <a class="navbar-brand" href=".">Stripe Payment Gateway Integration In Codeigniter (Ajax Request)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="newpage.html">Another Page</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">

		<div class="container py-3">
			<div class="row">
				<div class="col-12 col-sm-8 col-md-6 mx-auto">
                    <noscript>
                        <div class="bs-callout bs-callout-danger">
                            <h4>JavaScript is not enabled!</h4>
                            <p>This payment form requires your browser to have JavaScript enabled. Please activate JavaScript and reload this page. Check <a href="http://enable-javascript.com" target="_blank">enable-javascript.com</a> for more informations.</p>
                        </div>
                    </noscript>
                    <div class="alert alert-danger alert-dismissible display-hide">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span id="errorMsg"></span>
                    </div>
                    <div class="alert alert-success alert-dismissible display-hide">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span id="successMsg"></span>
                    </div>

					<div id="pay-invoice" class="card">
						<div class="card-body">
							<div class="card-title">
								<h2 class="text-center">Pay Invoice</h2>
							</div>
							<hr>
							<form action="" class="needs-validation" method="post" novalidate="novalidate" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>">
								<div class="form-group text-center">
									<ul class="list-inline">
										<li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
										<li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
										<li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
										<li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
									</ul>
								</div>
								<div class="form-group">
									<label>Payment amount</label>
									<h2>$100.00</h2>
								</div>
								<div class="form-row">
									<div class="col-md-12">
										<label for="cc-name" class="control-label">Name on card</label>
										<input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" required>
										<div class="invalid-feedback">Please enter the name on card</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12">
										<label for="cc-number" class="control-label">Card number</label>
										<input id="cc-number" name="cc-number" type="tel" class="form-control cc-number identified visa number" maxlength="19" value="" required>
										<div class="invalid-feedback">Please enter the card number</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-4">
										<label for="cc-month" class="control-label">Month</label>
										<input id="cc-month" name="cc-month" type="tel" class="form-control cc-month number" value="" placeholder="MM" maxlength="2" required>
										<div class="invalid-feedback">Please enter the exp. month</div>
									</div>
									<div class="col-4">
										<label for="cc-year" class="control-label">Year</label>
										<input id="cc-year" name="cc-year" type="tel" class="form-control cc-year number" value="" placeholder="YYYY" maxlength="4" required>
										<div class="invalid-feedback">Please enter the exp. year</div>
									</div>
									<div class="col-4">
										<label for="x_card_code" class="control-label">CVV/CVV2</label>
										<div class="input-group">
											<input id="x_card_code" name="x_card_code" type="tel" class="form-control cc-cvc number" value="" maxlength="4" required>
											<div class="input-group-append">
												<span class="input-group-text"><span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="Security Code"
												data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"
												data-trigger="hover"></span></span>
											</div>
											<div class="invalid-feedback">Please enter the security code</div>
										</div>
									</div>
								</div>
								<br>
								<div >
									<button id="payment-button" type="submit" class="btn btn-lg btn-success btn-block">
										<i class="fa fa-lock fa-lg"></i>&nbsp;
										<span id="payment-button-amount">Pay $100.00</span>
										<span id="payment-button-sending" style="display:none;">Sending…</span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- build:js -->
    <script src="assets/js/main.js"></script>
    <!-- endbuild -->

    <script src="assets/js/theme.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script>

		(function() {
			'use strict';

			$('[data-toggle="popover"]').popover()

			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');

				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
				});

                $.blockUI({ css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: .5, 
                    color: '#fff' 
                } });

                // createToken returns immediately - the supplied callback submits the form if there are no errors
                Stripe.card.createToken({
                        number: $('.cc-number').val(),
                        cvc: $('.cc-cvc').val(),
                        exp_month: $('.cc-month').val(),
                        exp_year: $('.cc-year').val(),
                        name: $('.cc-name').val(),
                }, stripeResponseHandler);
                return false; // submit from callback

			}, false);
		})();

	</script>

    <script>
        stripeForm = document.getElementsByClassName('needs-validation');

        // this identifies your website in the createToken call below
        Stripe.setPublishableKey(stripeForm.data('stripe-publishable-key'));

        function stripeResponseHandler(status, response) {

            var stripeError = document.getElementsByClassName('alert-danger');
            var stripeSuccess = document.getElementsByClassName('alert-success');

            if (response.error) {

                stripeError.show();
                $('#errorMsg').text(response.error.message);

            } else {

                var token = response['id'];
                stripeForm.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                var dataPost = $('#stripe-form').serializeArray();

                $.post(appFilePath + "StripeController/stripePost", dataPost, function(response) {
                    
                    $.unblockUI();
                    console.log(response);
                    if(response.success){

                        document.getElementsByClassName("needs-validation").reset();
                        console.log('complete');
                        stripeSuccess.show();
                        $('#successMsg').text(response.message);

                    }else{
                        
                        stripeError.show();
                        $('#errorMsg').text(response.error.message);
                    }
                }, "json");
            }
        }

        // only numbers are allowed
        $(".number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+v, Command+V
                (e.keyCode == 118 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                           // Allow: Ctrl+V, Command+V
                (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||

                // Allow: Ctrl+A, Command+V
                ((e.keyCode == 65 || e.keyCode == 97 || e.keyCode == 103 || e.keyCode == 99 || e.keyCode == 88 || e.keyCode == 120 )&& ( e.ctrlKey === true || e.metaKey === true ) ) ||


                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    </script>
  	</body>

</html>
