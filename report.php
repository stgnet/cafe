<?php

require 'config.php';
require 'admin.php';
require 'head.php';

$trans = $db_trans->records();

$month=array();
foreach ($trans as $tran) {
	$year_month=substr($tran['datetime'],0,7);
	
	if (empty($month[$year_month])) {
		$month[$year_month]=array();
	}

	$item=$tran['item'];
	
	if (empty($month[$year_month][$item])) {
		$month[$year_month][$item]=array('count'=>0, 'total'=>0.0);
	}
	
	$month[$year_month][$item]['count']+=1;
	$month[$year_month][$item]['total']+=$tran['amount'];
}
	
foreach ($month as $date => $items) {

	echo '<div class="container">';
	echo '<h3>Transactions for '.$date.'</h3>';
	echo '
	<table class="table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Count</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
';

	ksort($items);

	foreach ($items as $item => $info) {
		echo '<tr><td>'.htmlentities($item).'</td><td>'.$info['count'].'</td><td>'.number_format($info['total'],2).'</td></tr>'."\n";
	}
	echo '
		</tbody>
	</table>
</div>
';
	
}

	require 'foot.php';
