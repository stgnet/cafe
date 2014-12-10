<?php

$refresh='30;http://cafe.stg.net/menu.php';

require 'config.php';
require 'head.php';
global $message;

global $db_users;

if (empty($_POST['email']) || empty($_POST['action'])) {
	echo '<h3 class="bg-danger">Error: Invalid input received</h3>';
	require 'foot.php';
	return;
}
	
$email = $_POST['email'];
// validate the email here

$message='Receipt for '.$_SERVER['HTTP_ORIGIN'].' purchase:'."\n\n";

// look up the user record, add if not found
$records = $db_users->records(array('email'=>$email));
if (!$records)	{
	// Add new user if not found
	$db_users->insert(array('email'=>$email, 'balance'=>0));
}
$records = $db_users->records(array('email'=>$email));
if (!$records || !$records[0]) throw new Exception('Unexpected condition: unable to find user record after added');

$user = $records[0];
$email = $user['email'];
$balance = $user['balance'];
$datetime=date('Y-m-d H:i:s');

function table_row($item,$cost) {
	global $message;
	$formatted_cost = number_format($cost,2);
	echo '<tr><td>'.$item.'</td><td>$ '.$formatted_cost.'</td></tr>'."\n";
	$message.=$item.' = $ '.$formatted_cost."\n";
}
	
?>
<div class="container">
	<h3>Receipt</h3>
	<h6>Email to: <?php echo $email; ?></h6>
	<table class="table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Cost</th>
			</tr>
		</thead>
		<tbody>
<?php
	
$total=0;
$items=$_POST['items'];
foreach ($items as $index => $item) {
	$cost = $_POST['costs'][$index];
	if (empty($item) && empty($cost)) continue;
	if (empty($item)) $item="--unknown--";

	table_row($item, $cost);
	if ($_POST['action']!='payment') {
		$cost=0.0-$cost;
	}
	
	$total+=$cost;

	$db_trans->insert(array(
		'email'=>$email,
		'datetime'=>$datetime,
		'item'=>$item,
		'amount'=>$cost));
}
$was=$balance;

$message.='--------------------'."\n";

if ($_POST['action']!='payment') {
	if (!empty($config['tax']['rate'])) {
		table_row('Sub-total', 0.0-$total);
		$tax=round((0.0-$total) * $config['tax']['rate'] / 100,2);
		
		$item='TAX @ '.$config['tax']['rate'].'%';
		table_row($item, $tax);
		$tax=0.0-$tax;

		$db_trans->insert(array(
			'email'=>$email,
			'datetime'=>$datetime,
			'item'=>$item,
			'amount'=>$tax));

		$total+=$tax;
	}
	table_row('TOTAL',0.0-$total);
}

$balance+=$total;
table_row('BALANCE: ('.number_format($was,2).' - '.number_format(0.0-$total,2).') ',$balance);

$db_users->update(array('email'=>$email), array('balance'=>$balance));

$message.="\nFor a list of all transactions visit: http://cafe.stg.net/account.php?email=$email\n";

$to      = $email;
$subject = 'Digium Cafe Purchase';
$headers = 'From: cafe@stg.net' . "\r\n" .
	'Reply-To: cafe@stg.net' . "\r\n" .
	"MIME-version: 1.0\r\n".
	"Content-type: text/plain; charset= iso-8859-1\r\n";

mail($to, $subject, $message, $headers);

?>
		</tbody>
	</table>
</div>

<?php
/*echo '<pre>';
echo $headers;
echo 'To: '.$to."\n\n";
echo $message;
echo '</pre>';
*/
	require 'foot.php';
