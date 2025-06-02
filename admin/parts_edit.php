<?php
require_once '../database/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: parts_list.php");
    exit;
}

// 取得商品資料
$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$id]);
$part = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$part) {
    echo "找不到該商品";
    exit;
}

// 取得所有分類
$stmt2 = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE parts SET category_id = ?, name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
    $stmt->execute([
        $_POST['category_id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['stock'],
        $id
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

		<h2>修改商品</h2>
		<form method="post">
			名稱：<input type="text" name="name" value="<?= htmlspecialchars($part['name']) ?>" required><br>
			分類：
			<select name="category_id" required>
				<?php foreach ($categories as $cat): ?>
					<option value="<?= $cat['id'] ?>" <?= $cat['id'] == $part['category_id'] ? 'selected' : '' ?>>
						<?= htmlspecialchars($cat['name']) ?>
					</option>
				<?php endforeach; ?>
			</select><br>
			描述：<textarea name="description"><?= htmlspecialchars($part['description']) ?></textarea><br>
			價格：<input type="number" step="0.01" name="price" value="<?= $part['price'] ?>" required><br>
			庫存：<input type="number" name="stock" value="<?= $part['stock'] ?>" required><br>
			<button type="submit">更新</button>
		</form>
		<a href="parts_list.php">回列表</a>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>