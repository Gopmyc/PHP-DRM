<?php
	class Setup {
		private $dbFile;

		public function __construct($dbFile)
		{
		    $this->dbFile = $dbFile;
		}

		public function generateKeys()
		{
		    shell_exec("lua lua/keygen.lua");
		}

		public function createDatabase()
		{
		    $db = new SQLite3($this->dbFile);
		    $db->exec("CREATE TABLE IF NOT EXISTS clients (
		        id INTEGER PRIMARY KEY,
		        signature TEXT NOT NULL,
		        key TEXT UNIQUE NOT NULL
		    )");
		}

		public function run()
		{
		    $this->generateKeys();
		    $this->createDatabase();
		}
	}
?>
