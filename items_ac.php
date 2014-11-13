<?php

/*
require 'get_spreadsheet.php';

$suggestions = array();
$items = get_spreadsheet('1_UtAK4yLLzHaBTzpIVKx3ZEVulpGFB4gv4q_Z1CAf5Y');
*/

require 'config.php';

$items = $db_items->records();

$query = '';
if (!empty($_GET['query']))
{
	$query = $_GET['query'];
}

$used=array();

foreach ($items as $item)
{
	$cost=$item['cost'];
	$desc=$item['name'].' '.$cost;
	$data=$item['name'].'|'.$cost;
	if (!$query || stripos($desc, $query) === 0)
	{
		$suggestions[] = array('value' => $desc, 'data' => $data);
		$used[] = $desc;
	}
}
foreach ($items as $item)
{
	$cost=$item['cost'];
	$desc=$item['name'].' '.$cost;
	$data=$item['name'].'|'.$cost;
	if (!in_array($desc, $used) && stripos($desc, $query))
	{
		$suggestions[] = array('value' => $desc, 'data' => $data);
	}
}

$result = array('suggestions' => $suggestions);

echo json_encode($result);
