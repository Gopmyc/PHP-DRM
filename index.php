<?php
require_once 'setup.php'; // Exécute le setup si nécessaire
require_once 'config.php'; // Connexion à la base de données

header('Content-Type: application/json');

// 🔑 Charger la clé privée depuis `key/private.json`
if (!file_exists('key/private.json')) {
    echo json_encode(["error" => "Private key file not found"]);
    exit;
}

$jsonKeys = file_get_contents('key/private.json');
$keys = json_decode($jsonKeys, true);

if (!$keys || !isset($keys['private'])) {
    echo json_encode(["error" => "Private key not found"]);
    exit;
}

// 🔎 Vérifier si la clé "key" est fournie dans la requête
if (!isset($_GET['key'])) {
    echo json_encode(["error" => "Missing key parameter"]);
    exit;
}

$command = "lua rsa.lua decrypt " . escapeshellcmd($_GET['key']) . " 2>&1";
$decryptionValue = shell_exec($command);

if (!$decryptionValue ) {
    echo json_encode(["error" => "Decryption failed"]);
    exit;
}

$decryptionValue = trim($decryptionValue);
// 🔍 Vérifier si la clé déchiffrée est dans la base de données
$stmt = $db->prepare("SELECT signature FROM clients WHERE key = ?");
$stmt->bindValue(1, $decryptionValue, SQLITE3_TEXT);
$result = $stmt->execute();
$data = $result->fetchArray(SQLITE3_ASSOC);

if (!$data) {
    echo json_encode(["error" => "Invalid key"]);
    exit;
}

$command = "lua rsa.lua encrypt " . escapeshellcmd($data['signature']) . " 2>&1";
$encryptionValue = shell_exec($command);

echo $encryptionValue;

?>