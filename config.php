<?php

if (!defined('ADMIN_PASSWORD'))
    define('ADMIN_PASSWORD', 'Hello_World');
if (!defined('DB_FILE'))
    define('DB_FILE', __DIR__ . '/data/client.db');
if (!defined('KEY_FILE'))
    define('KEY_FILE', __DIR__ . '/key/private.json');

// 🔹 Chargement des clés RSA
if (!file_exists(KEY_FILE)) {
    die("❌ RSA keys not found. Run `setup.php` first.");
}

$KEYS = json_decode(file_get_contents(KEY_FILE), true);

// 🔹 Connexion SQLite
$db = new SQLite3(DB_FILE);
?>