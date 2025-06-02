<?php
require_once '../database/db.php';

session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../users/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
		<h2>管理員，<?php echo htmlspecialchars($_SESSION["username"]); ?> 您好！</h2>
		<p><a href="../users/logout.php">登出</a></p>
    </header>
	
	<main>

		

		<h2>分類列表</h2>
		<a href="categories_add.php">新增分類</a> | <a href="parts_list.php">商品管理</a>
		<table border="1" cellpadding="5" cellspacing="0">
			<tr><th>ID</th><th>名稱</th><th>操作</th></tr>
			<?php foreach($categories as $cat): ?>
			<tr>
				<td><?= $cat['id'] ?></td>
				<td><?= htmlspecialchars($cat['name']) ?></td>
				<td>
					<a href="categories_edit.php?id=<?= $cat['id'] ?>">修改</a> | 
					<a href="categories_delete.php?id=<?= $cat['id'] ?>" onclick="return confirm('確定刪除？')">刪除</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>