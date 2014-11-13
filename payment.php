<?php
require 'config.php';
require 'admin.php';
require 'head.php';
?>
<div class="container">
	<form role="form" action="bought.php" method="post">
		<div class="form-group">
			<label for="email-ac">Email address</label>
			<input type="email" class="form-control" name="email" id="email-ac" placeholder="Enter email">
		</div>
		<div class="form-group">
			<div class="form-inline">
				<label for="item">Paid</label>
				<div class="input-group">
					<input type="text" class="form-control items" name="items[]" id="item" value="PAYMENT" />
					<div class="input-group-addon">$</div><input type="text" class="form-control" name="costs[]" id="amount" />
				</div>
				<p>Hint: you can change the PAYMENT description to indicate how the customer paid.</p>
			</div>
		</div>
		<input type="hidden" name="action" value="payment" />
		<button type="submit" class="btn btn-default">Record Payment</button>
	</form>
</div>
<?php
	$postscript='
	jQuery(function(){
		var a = $("#email-ac").autocomplete({
			serviceUrl:"email_ac.php"
		});
	});
	';
	require 'foot.php';
