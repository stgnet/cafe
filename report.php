<?php

require 'config.php';
require 'admin.php';
require 'head.php';

$trans = $db_trans->records();
//$users = $db_users->records();

// calculate balance for each user
$balance=array();
foreach ($trans as $tran) {
	$email=$tran['email'];
	$amount=$tran['amount'];
	if (!array_key_exists($email,$balance)) {
		$balance[$email]=0.00;
	}
	$balance[$email]+=$amount;
}

// go back through and make sure user records are correct
foreach ($balance as $email => $bal) {
	// look up the user record
	$user=$db_users->record(array('email'=>$email));
	$ubal=number_format($user['balance'],2);
	$cbal=number_format($bal,2);
	if (!$user)	{
		// oops, how did that happen?
		echo '<p class="bg-warning">Created missing '.$email.' balance '.$bal.'</p>';
		$db_users->insert(array('email'=>$email, 'balance'=>$bal));
	}
	else if ($ubal != $cbal) {
		echo '<p class="bg-warning">Corrected '.$email.' balance: was '.$ubal.' now '.$cbal.'</p>';
		$db_users->update(array('email'=>$email), array('balance'=>$bal));
	}
}
	
?>
<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th>Email</th>
				<th>Balance</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach ($balance as $email => $actual_balance) {
		$form='<form action="report.php" method="post"><input type="hidden" name="action" value="pay" />';
		$form.='<input type="hidden" name="email" value="'.$email.'" />';
		$form.='<button type="submit" class="btn btn-default btn-xs ">Pay (not working yet)</button></form>';
		echo '<tr><td><a role="button" class="btn btn-default btn-xs" href="account.php?email='.$email.'">'.$email.'</a></td><td>$ '.number_format($actual_balance,2).'</td><td>'.$form.'</td></tr>'."\n";
	}
	

?>
		</tbody>
	</table>
</div>

<?php
	require 'foot.php';
