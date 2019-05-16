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
					<div id="pay-invoice" class="card">
						<div class="card-body">
							<div class="card-title">
								<h2 class="text-center">Pay Invoice</h2>
							</div>
							<hr>
							<form action="" class="needs-validation" method="post" novalidate="novalidate">
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
										<input id="cc-number" name="cc-number" type="tel" class="form-control cc-number identified visa" value="" required>
										<div class="invalid-feedback">Please enter the card number</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-4">
										<label for="cc-exp" class="control-label">Month</label>
										<input id="cc-exp" name="cc-exp" type="tel" class="form-control cc-exp" value="" placeholder="MM" maxlength="2" required>
										<div class="invalid-feedback">Please enter the exp. month</div>
									</div>
									<div class="col-4">
										<label for="cc-exp" class="control-label">Year</label>
										<input id="cc-exp" name="cc-exp" type="tel" class="form-control cc-exp" value="" placeholder="YYYY" maxlength="4" required>
										<div class="invalid-feedback">Please enter the exp. year</div>
									</div>
									<div class="col-4">
										<label for="x_card_code" class="control-label">Security code</label>
										<div class="input-group">
											<input id="x_card_code" name="x_card_code" type="tel" class="form-control cc-cvc" value="" maxlength="3" required>
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
			}, false);
		})();
	</script>
  	</body>

</html>
