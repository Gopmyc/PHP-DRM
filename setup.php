<?php

// 🔐 Chiffre la clé avec RSA
if (!defined('KEY_DIR'))
    define('KEY_DIR', __DIR__ . '/key');
if (!defined('DATA_DIR'))
    define('DATA_DIR', __DIR__ . '/data');
if (!defined('DB_FILE'))
    define('DB_FILE', DATA_DIR . '/client.db');

// 🔹 1. Création des dossiers si inexistants
if (!is_dir(KEY_DIR))
    mkdir(KEY_DIR, 0777, true);
if (!is_dir(DATA_DIR))
    mkdir(DATA_DIR, 0777, true);

shell_exec("lua keygen.lua");

// 🔹 3. Création de la base de données SQLite si inexistante
$db = new SQLite3(DB_FILE);
$db->exec("CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY,
    signature TEXT NOT NULL,
    key TEXT UNIQUE NOT NULL
)");

?>
