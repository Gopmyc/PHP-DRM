<?php
	class Config
	{
    	const ADMIN_PASSWORD	=	'Hello_World';
    	const KEY_DIR			=	__DIR__ . '/key';
    	const DATA_DIR			=	__DIR__ . '/data';
    	const DB_FILE			=	self::DATA_DIR . '/client.db';
    	const KEY_FILE			=	self::KEY_DIR . '/private.json';
		const LUA_PATH			=	"lua"; // --> Modify this constant to run version 5.1 of lua

		public function __construct()
		{
        	$this->ensureDirectoriesExist();
        	$this->ensureKeyFileExists();
			$this->ensureSQLite3IsActivate();
			$this->ensureLuaIsReachable();
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

		private function ensureSQLite3IsActivate()
		{
			class_exists('SQLite3') ? null : die("SERVER ERROR : SQLite3 is not reachable or not installed");
		}

		private function ensureLuaIsReachable()
		{
			strpos(shell_exec(self::LUA_PATH . ' -v 2>&1'), 'Lua') !== false ? null : die("SERVER ERROR : Lua is not reachable or not installed");
		}
	}
?>
