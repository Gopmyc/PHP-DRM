<?php

require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_GET['key'])) {
    echo json_encode(["error" => "Missing 'key' parameter"]);
    exit;
}

$encryptedKey = base64_decode($_GET['key']); // Clé reçue (base64 -> binaire)
$privateKey = base64_decode($KEYS['private']); // Clé privée du serveur

// 🔹 Déchiffrement de la clé envoyée
openssl_private_decrypt($encryptedKey, $decryptedKey, $privateKey);

if (!$decryptedKey) {
    echo json_encode(["error" => "Decryption failed"]);
    exit;
}

// 🔹 Vérification dans la base de données
$stmt = $db->prepare("SELECT signature FROM clients WHERE key = ?");
$stmt->bindValue(1, $decryptedKey, SQLITE3_TEXT);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$result) {
    echo json_encode(["error" => "Invalid key"]);
    exit;
}

// 🔹 Chiffrement et envoi de la signature
$signatureHash = hash("sha256", $result['signature']);
openssl_public_encrypt($signatureHash, $encryptedSignature, base64_decode($KEYS['public']));

echo json_encode(["signature" => base64_encode($encryptedSignature)]);
?>