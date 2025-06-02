<?php
session_start();
require_once(__DIR__ . '/../database/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $accountnumber = trim($_POST["accountnumber"]);
    $password_raw = $_POST["password"];

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

    // 密碼加密
    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    // 寫入資料（role 預設 'user'，這裡不寫也行）
    $stmt = $pdo->prepare("INSERT INTO users (username, accountnumber, password, role) VALUES (?, ?, ?, 'user')");
	$stmt->execute([$username, $accountnumber, $password_hashed]);

    echo "註冊成功，<a href='login.php'>點此登入</a>";
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>註冊頁面</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
	<header>
		<h1>註冊</h1>
    </header>
	<main>

		<form method="post" class="login-form">
			使用者名稱<input type="text" name="username" required><br>
			帳號<input type="text" pattern="[A-Za-z0-9!@#$%^&*()_+\-=]+" name="accountnumber" 
			title="請輸入英文、數字或 !@#$%^&*()_+-=" required><br>
			密碼<input type="password" name="password" required><br>
			<button type="submit">註冊</button>
		</form>
		<p><a href="login.php">已有帳號前往登入</a></p>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>