<?php
	require_once 'config.php';
	require_once 'setup.php';
	require_once 'keyValidator.php';

	header('Content-Type: application/json');
	header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
	header('Pragma: no-cache');

	$config			=	new Config();
	$setup			=	new Setup(Config::DB_FILE);
	$key			=	$_GET['key'] ?? null;
	$keyValidator	=	new KeyValidator(Config::DB_FILE, Config::KEY_FILE);

	$setup->run();
	$keyValidator->processRequest($key);
?>