<?php
session_start();
require_once(__DIR__ . '/../database/db.php');

// ✅ .env 檔案與此檔案同層
function getEnvValue($key) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || !str_contains($line, '=')) continue;
        [$envKey, $envVal] = explode('=', $line, 2);
        if (trim($envKey) === $key) {
            return trim($envVal);
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
	$accountnumber = trim($_POST["accountnumber"]);
    $password_raw = $_POST["password"];
    $admin_key = $_POST["admin_key"];

    // ✅ 從本地 .env 檔案取得密鑰
    $expected_key = getEnvValue("ADMIN_SECRET_KEY");
    if ($admin_key !== $expected_key) {
        echo "密鑰錯誤，無法註冊為管理員。";
        exit;
    }

    if (strlen($accountnumber) < 3 || strlen($password_raw) < 6 || strlen($username) < 2) {
        echo "帳號至少 3 字、密碼至少 6 字，使用者名稱至少2個字";
        exit;
    }

    // 檢查是否帳號已存在
    $stmt = $pdo->prepare("SELECT id FROM users WHERE accountnumber = ?");
    $stmt->execute([$accountnumber]);
    if ($stmt->fetch()) {
        echo "註冊失敗：此帳號已經被使用。";
        exit;
    }

    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    // ✅ 寫入角色欄位為 'admin'
    $stmt = $pdo->prepare("INSERT INTO users (username, accountnumber, password, role) VALUES (?, ?, ?, 'admin')");
	$stmt->execute([$username, $accountnumber, $password_hashed]);

    echo "管理員註冊成功，<a href='../users/login.php'>點此登入</a>";
}
?>

<form method="post">
	管理員名稱：<input type="text" name="username" required><br>
    帳號：<input type="text" pattern="[A-Za-z0-9!@#$%^&*()_+\-=]+" name="accountnumber" 
    title="請輸入英文、數字或 !@#$%^&*()_+-=" required><br>
    密碼：<input type="password" name="password" required><br>
    管理員密鑰：<input type="text" name="admin_key" required><br>
    <button type="submit">註冊為管理員</button>
</form>
