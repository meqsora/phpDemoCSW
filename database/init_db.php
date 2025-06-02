<?php
require_once(__DIR__ . '/db.php');

// 建立 categories 資料表 商品類別資料表
$sql_categories = "
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);
";

// 建立 users 資料表 用戶資料表
$sql_users = "
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
	accountnumber TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
	role TEXT DEFAULT 'user'
);
";

// 建立 parts 資料表 商品資料表
$sql_parts = "
CREATE TABLE IF NOT EXISTS parts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    price REAL NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
";

// 啟用外鍵約束
$pdo->exec("PRAGMA foreign_keys = ON;");

// 執行 SQL
try {
    // ⚠️ 要先執行 categories（因為 parts 依賴它）
    $pdo->exec($sql_categories);
    $pdo->exec($sql_users);
    $pdo->exec($sql_parts);
    echo "所有資料表建立成功！";
} catch (PDOException $e) {
    echo "建立資料表失敗：" . $e->getMessage();
}
