<?php

require 'config.php';
require 'admin.php';
require 'head.php';

if (!empty($_POST)) {
	if ($_POST['action']=='add') {
		$cost=ltrim($_POST['cost'],' $0-');
		$db_items->insert(array('name'=>$_POST['name'],'cost'=>$cost));
	} else if ($_POST['action']=='del') {
		$db_items->delete(array('name'=>$_POST['name']));
	} else {
		echo '<pre>POST = ';
		print_r($_POST);
		echo '</pre>';
	}
}

$items = $db_items->records();

	
?>
<div class="container">
	<h3>Menu</h3>
	<table class="table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Cost</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

<?php
	foreach ($items as $item) {
		$form='<form action="items.php" method="post"><input type="hidden" name="action" value="del" />';
		$form.='<input type="hidden" name="name" value="'.$item['name'].'" />';
		$form.='<button type="submit" class="btn btn-default btn-xs">Delete</button></form>';
		echo '<tr><td>'.$item['name'].'</td><td>$ '.$item['cost'].'</td><td>'.$form.'</td></tr>'."\n";
	}
?>
			<tr>
				<form role="form" action="items.php" method="post">
					<td><input type="text" class="form-control" name="name" placeholder="Item name" /></td>
					<td>
						<div class="form-inline">
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input type="text" class="form-control" name="cost" placeholder="Cost" />
							</div>
						</div>
					</td>
					<td>
						<input type="hidden" name="action" value="add" />
						<button type="submit" class="btn btn-default">Add</button>
					</td>
				</form>
			</tr>
				
		</tbody>
	</table>
</div>

<?php
	require 'foot.php';
