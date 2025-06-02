<?php
require_once '../database/db.php';

// 取得所有分類，做下拉選單用
$stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO parts (category_id, name, description, price, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['category_id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['stock']
    ]);
    header("Location: parts_list.php");
    exit;
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

		<h2>新增商品</h2>
		<form method="post" >
			名稱：<input type="text" name="name" required><br>
			分類：
			<select name="category_id" required>
				<?php foreach ($categories as $cat): ?>
					<option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
				<?php endforeach; ?>
			</select><br>
			描述：<textarea name="description"></textarea><br>
			價格：<input type="number" step="0.01" name="price" required><br>
			庫存：<input type="number" name="stock" required><br>
			<button type="submit">新增</button>
		</form>
		<a href="parts_list.php">回列表</a>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>