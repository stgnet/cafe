<?php

require 'config.php';
require 'get_spreadsheet.php';

$suggestions = array();
$items = get_spreadsheet('1_UtAK4yLLzHaBTzpIVKx3ZEVulpGFB4gv4q_Z1CAf5Y');

foreach ($items as $item)
{
	$name=$item['name'];
	$cost=ltrim($item['cost'],'$ 0');

	$db_items->insert(array('name' => $name, 'cost' => $cost));
}
