<?php
$dsn = 'sqlite:' . __DIR__ . '/db.sqlite';

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 連線失敗: " . $e->getMessage());
}
?>
