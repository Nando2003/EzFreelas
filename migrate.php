<?php

require __DIR__ . '/vendor/autoload.php';

$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

$pdo = new PDO('sqlite:' . __DIR__ . '/data/db.sqlite3');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        username TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        created_at TEXT NOT NULL
    );
");


$pdo->exec("
    CREATE TABLE IF NOT EXISTS freelances (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        price_in_cents INTEGER NOT NULL,
        created_at TEXT NOT NULL,
        user_id INTEGER NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS proposals (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        message TEXT NOT NULL,
        price_in_cents INTEGER NOT NULL,
        created_at TEXT NOT NULL,
        user_id INTEGER NOT NULL,
        freelance_id INTEGER NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (freelance_id) REFERENCES freelances(id)
    );
");

echo "Tabelas criadas com sucesso.\n";
