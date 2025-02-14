<?php
	require_once 'utils.php';

	class KeyValidator
	{
    	private $db;
    	private $keys;

    	public function __construct($dbFile, $keyFile)
		{
        	$this->db = new SQLite3($dbFile);
        	$this->keys = file_exists($keyFile) ? json_decode(file_get_contents($keyFile), true) : null;
        	!$this->keys || !isset($this->keys['private']) ? Utils::throwError("The private key cannot be loaded") : null;
    	}

    	public function processRequest($key)
		{
        	!$key ? Utils::throwError("Missing key parameter") : null;
        	$decryptionValue = shell_exec("lua lua/rsa.lua decrypt " . escapeshellarg($key) . " 2>&1");
        	!$decryptionValue ? Utils::throwError("Decryption failed") : null;
        	$decryptionValue = trim($decryptionValue);

        	$stmt = $this->db->prepare("SELECT signature FROM clients WHERE key = ?");
        	$stmt->bindValue(1, $decryptionValue, SQLITE3_TEXT);
        	$result = $stmt->execute();
        	$data = $result->fetchArray(SQLITE3_ASSOC);
        	!$data ? Utils::throwError("Invalid key") : null;

        	$encryptionValue = shell_exec("lua lua/rsa.lua encrypt " . escapeshellarg($data['signature']) . " 2>&1");
        	echo json_encode(["encrypted_signature" => $encryptionValue]);
    	}
	}
?>