<?php

require 'config.php';
require 'head.php';

$items = $db_items->records();

function table_row($item,$cost) {
	global $message;
	$formatted_cost = number_format($cost,2);
	echo '<tr><td>'.$item.'</td><td>$ '.$formatted_cost.'</td></tr>'."\n";
	$message.=$item.' = $ '.$formatted_cost."\n";
}
	
?>
<div class="container">
	<h3>Menu</h3>
	<table class="table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Cost</th>
			</tr>
		</thead>
		<tbody>
<?php
	
usort($items, function($a, $b) {
	if ($a['name'] > $b['name']) {
		return 1;
	}
	return -1;
});
	  
	foreach ($items as $item) {
		table_row($item['name'], $item['cost']);
	}
?>
		</tbody>
	</table>
</div>

<?php
	require 'foot.php';
