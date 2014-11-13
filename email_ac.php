<?php

require 'config.php';

file_put_contents("debug.out", print_r($_GET,true));

$suggestions = array();
$users = file('email-uniq');
$query = '';
if (!empty($_GET['query']))
{
	$query = $_GET['query'];
}

$dbusers = $db_users->records();

$used=array();

foreach ($dbusers as $user)
{
	$email=$user['email'];
	if (!$query || stripos($email, $query) === 0)
	{
		$suggestions[] = array('value' => $email, 'data' => $email);
		$used[] = $email;
	}
}

foreach ($users as $email)
{
	$email=trim($email);
	if (!in_array($email, $used) && stripos($email, $query) === 0)
	{
		$suggestions[] = array('value' => $email, 'data' => $email);
		$used[] = $email;
	}
}
foreach ($users as $email)
{
	$email=trim($email);
	if (!in_array($email, $used) && stripos($email, $query))
	{
		$suggestions[] = array('value' => $email, 'data' => $email);
	}
}

$result = array('suggestions' => $suggestions);

echo json_encode($result);
