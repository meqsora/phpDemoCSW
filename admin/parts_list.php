<?php
require_once '../database/db.php';

session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../users/login.php");
    exit;
}


// 用 INNER JOIN 把分類名稱抓出來
$sql = "SELECT parts.*, categories.name AS category_name 
        FROM parts 
        INNER JOIN categories ON parts.category_id = categories.id
        ORDER BY parts.id ASC";
$stmt = $pdo->query($sql);
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

		<h2>商品列表</h2>
		<a href="parts_add.php">新增商品</a> | <a href="categories_list.php">分類管理</a>
		<table border="1" cellpadding="5" cellspacing="0">
			<tr>
				<th>ID</th><th>名稱</th><th>分類</th><th>價格</th><th>庫存</th><th>操作</th>
			</tr>
			<?php foreach($parts as $part): ?>
			<tr>
				<td><?= $part['id'] ?></td>
				<td><?= htmlspecialchars($part['name']) ?></td>
				<td><?= htmlspecialchars($part['category_name']) ?></td>
				<td><?= $part['price'] ?></td>
				<td><?= $part['stock'] ?></td>
				<td>
					<a href="parts_edit.php?id=<?= $part['id'] ?>">修改</a> | 
					<a href="parts_delete.php?id=<?= $part['id'] ?>" onclick="return confirm('確定刪除？')">刪除</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>