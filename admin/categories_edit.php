<?php
require_once '../database/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: categories_list.php");
    exit;
}

// 取得原本資料
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$category) {
    echo "找不到該分類";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if ($name) {
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
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

		<h2>修改分類</h2>
		<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
		<form method="post">
			名稱：<input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
			<button type="submit">更新</button>
		</form>
		<a href="categories_list.php">回列表</a>

	</main>
	<footer>
	</footer>
	
	<script src="../assets/script.js"></script>
</body>