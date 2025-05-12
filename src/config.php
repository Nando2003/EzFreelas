<?php
declare(strict_types=1);

date_default_timezone_set('America/Sao_Paulo');
$databasePath = __DIR__ . '/../data/db.sqlite3';

try {
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}