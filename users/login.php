<?php
session_start();
require_once(__DIR__ . '/../database/db.php'); // 共用資料庫連線

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accountnumber = trim($_POST["accountnumber"]);
    $password = $_POST["password"];

    if (empty($accountnumber) || empty($password)) {
        echo "請輸入帳號與密碼";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE accountnumber = ?");
    $stmt->execute([$accountnumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        // 儲存使用者資訊到 session
        $_SESSION["user_id"] = $user["id"];
		$_SESSION["username"] = $user["username"];
        $_SESSION["accountnumber"] = $user["accountnumber"];
        $_SESSION["role"] = $user["role"];  // ✅ 也存入角色

        // 根據角色導向不同頁面
        if ($user["role"] === "admin") {
            header("Location: ../admin/categories_list.php");  // 管理員後台頁面
        } else {
            header("Location: ../index.php"); // 一般使用者首頁
        }
        exit;
    } else {
        echo "登入失敗，帳號或密碼錯誤";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>登入頁面</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
	<header>
		<h1>登入</h1>
    </header>
	<main>

		<form method="post" class="login-form">
			帳號<input type="text" name="accountnumber" required placeholder="請輸入帳號"><br>
			密碼<input type="password" name="password" required placeholder="請輸入密碼"><br>
			<button type="submit">登入</button>
			
			<a href="register.php">註冊</a>
			
		</form>

		

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>