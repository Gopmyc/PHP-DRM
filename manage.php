<?php

require_once 'config.php';

// Vérifie si la clé API est correcte
if (!isset($_POST['api_key']) || $_POST['api_key'] !== API_KEY) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// Vérifie que tous les paramètres sont présents
if (!isset($_POST['action']) && !isset($_POST['key']) && !isset($_POST['signature'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$action = $_POST['action'];
$key = $_POST['key'];
$signature = $_POST['signature'];

echo 1;
if ($action === "add") {
    $stmt = $db->prepare("INSERT OR IGNORE INTO clients (key, signature) VALUES (?, ?)");
    $stmt->bindValue(1, $key, SQLITE3_TEXT);
    $stmt->bindValue(2, $signature, SQLITE3_TEXT);
    $stmt->execute();
    echo json_encode(["success" => "Key added"]);
} elseif ($action === "remove") {
    $stmt = $db->prepare("DELETE FROM clients WHERE key = ?");
    $stmt->bindValue(1, $key, SQLITE3_TEXT);
    $stmt->execute();
    echo json_encode(["success" => "Key removed"]);
} else {
    echo json_encode(["error" => "Invalid action"]);
}
?>