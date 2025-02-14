<?php
	class Config
	{
    	const ADMIN_PASSWORD	=	'Hello_World';
    	const KEY_DIR			=	__DIR__ . '/key';
    	const DATA_DIR			=	__DIR__ . '/data';
    	const DB_FILE			=	self::DATA_DIR . '/client.db';
    	const KEY_FILE			=	self::KEY_DIR . '/private.json';

		public function __construct()
		{
        	$this->ensureDirectoriesExist();
        	$this->ensureKeyFileExists();
    	}

		private function ensureDirectoriesExist()
		{
			!is_dir(self::KEY_DIR) && mkdir(self::KEY_DIR, 0777, true);
			!is_dir(self::DATA_DIR) && mkdir(self::DATA_DIR, 0777, true);			
		}

		private function ensureKeyFileExists()
		{
			file_exists(self::KEY_FILE) ?: die("SERVER ERROR : RSA keys not found");
		}		
	}
?>
