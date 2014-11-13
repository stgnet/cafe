<?php
			   
if ($_SERVER['REMOTE_ADDR'] == '216.207.245.1')
{
	$url='http://'.$_SERVER['HTTP_HOST'].'/menu.php';
	header('Location: '.$url);
	echo '<a href="'.$url.'">Click Here</a>';
	return;
}

unset($_SERVER['PHP_AUTH_PW']);
mail('scott@griepentrog.com','CAFE ACCESS DENIED '.$_SERVER['REMOTE_ADDR'],print_r($_SERVER,true));

die('<h3>Access Denied</h3>');
