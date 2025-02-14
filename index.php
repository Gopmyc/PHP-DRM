<?php
	require_once 'config.php';
	require_once 'setup.php';
	require_once 'KeyValidator.php';

	header('Content-Type: application/json');
	header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
	header('Pragma: no-cache');

	// TODO : Secure access to the file/folder by clients and clean requests
	$config			=	new Config();
	$setup			=	new Setup(DB_FILE);
	$key			=	$_GET['key'] ?? null;
	$keyValidator	=	new KeyValidator(DB_FILE, KEY_FILE);

	$setup->run();
	$keyValidator->processRequest($key);
?>