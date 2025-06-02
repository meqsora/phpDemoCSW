<?php
require_once '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
        header("Location: categories_list.php");
        exit;
    } else {
        $error = "請輸入分類名稱";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>後台管理頁面</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
	<header>
		<h1>後台管理頁面</h1>
    </header>
	<main>

		<h2>新增分類</h2>
		<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
		<form method="post" >
			名稱：<input type="text" name="name" required>
			<button type="submit">新增</button>
		</form>
		<a href="categories_list.php">回列表</a>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>