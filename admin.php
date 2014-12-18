<?php
    $realm = 'Cafe'; // '.date('Y/m/d');

    // if authoriztion not provided, force it
    if (empty($_SERVER['PHP_AUTH_USER']) || 
        empty($_SERVER['PHP_AUTH_PW']) ||
		empty($config['admin'][$_SERVER['PHP_AUTH_USER']]) ||
		$config['admin'][$_SERVER['PHP_AUTH_USER']]!=md5($_SERVER['PHP_AUTH_PW']))
    {
        header('HTTP/1.1 401 Unauthorized');
        header("WWW-Authenticate: Basic realm=\"$realm\"");
/*
		echo '<pre>';
		print_r($_SERVER);
		print_r($config);
*/
        exit('Unauthorized');
    }
