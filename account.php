<?php

$refresh='30;http://cafe.stg.net/menu.php';

require 'config.php';
require 'head.php';

if (!empty($_POST['email'])) {
	$user = $db_users->record(array('email'=>$_POST['email']));
	if (!$user) {
		echo '<h3 class="bg-warning">No account found for '.$_POST['email'].'</h3>';
		require 'foot.php';
		return;
	}
	
	$purchased=$db_trans->records(array('email'=>$user['email']));
	
	?>
	<div class="container">
		<form role="form" action="account.php" method="post">
			<div class="form-group">
				<label for="email-ro">Email address</label>
				<input type="email" class="form-control" name="email" id="email-ro" readonly value="<?php echo $user['email']; ?>" />
			</div>
			<div class="form-group">
				<label for="name">Full Name</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter full name" value="<?php echo $user['name']; ?>" />
			</div>
			<div class="form-group">
				<label for="pin">Optional pin code (password)</label>
				<input type="password" class="form-control" name="pin" id="pin" placeholder="not set" value="<?php echo $user['pin']; ?>" />
			</div>
			<div class="form-group">
				<label for="balance">Current Balance</label>
				<input type="text" class="form-control" name="balance" id="balance" readonly value="<?php echo number_format($user['balance'],2); ?>" />
			</div>
			<input type="hidden" name="action" value="save" />
			<button type="submit" class="btn btn-default">Save (doesn't work yet)</button>
		</form>
	</div>

	<div class="container">
		<h3>Purchased:</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
					<th>Item</th>
					<th>Cost</th>
				</tr>
			</thead>
			<tbody>
	
<?php
	foreach ($purchased as $item) {
		/*		$form='<form action="items.php" method="post"><input type="hidden" name="action" value="del" />';
		$form.='<input type="hidden" name="name" value="'.$item['name'].'" />';
		$form.='<button type="submit" class="btn btn-default btn-xs">Delete</button></form>';
		*/
		echo '<tr><td>'.$item['datetime'].'</td><td>'.$item['item'].'</td><td>$ '.$item['amount'].'</td></tr>'."\n";
	}
?>
			</tbody>
		</table>
	</div>


<?php
	require 'foot.php';
	return;
}
	
?>
<div class="container">
	<form role="form" action="account.php" method="post">
		<div class="form-group">
			<label for="email-ac">Email address</label>
			<input type="email" class="form-control" name="email" id="email-ac" placeholder="Enter email">
		</div>
		<button type="submit" class="btn btn-default">Edit</button>
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