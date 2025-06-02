<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: users/login.php");
    exit;
}

// 檢查角色
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: admin/categories_list.php");
    exit;
}

require_once "database/db.php"; // 引入資料庫連線

// 取得所有分類
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 取得所有商品，依分類分組
$stmt = $pdo->query("
SELECT parts.*, categories.name AS category_name
FROM parts
JOIN categories ON parts.category_id = categories.id
ORDER BY category_id, price DESC
");
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 分類商品（依 category_id 分組）
$groupedParts = [];
foreach ($parts as $part) {
    $groupedParts[$part["category_id"]][] = $part;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>電腦零件選購</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
	  <header>
		<h1>電腦零件選購平台</h1>
		<p>歡迎，<?php echo htmlspecialchars($_SESSION["username"]); ?>！</p>
		<a href="cart/cart.php">查看🛒 購物車</a>
		<a href="users/logout.php">登出</a>
	  </header>

	  <main>
		<form id="selectionForm" action="cart/add_to_cart.php" method="POST" onsubmit="return confirm('確定加入購物車？');">

		  <?php foreach ($categories as $category): ?>
			<div class="category-block" data-category-id="<?php echo $category['id']; ?>">
			  <div class="category-header" onclick="toggleParts(<?php echo $category['id']; ?>)">
				<?php echo htmlspecialchars($category['name']); ?>
				<span id="selected-<?php echo $category['id']; ?>" class="selected-item">（尚未選擇）</span>
			  </div>
			  <button type="button" onclick="cancelSelection(<?php echo $category['id']; ?>)">取消選擇</button>

			  <div id="parts-<?php echo $category['id']; ?>" class="parts-list">
				<?php if (isset($groupedParts[$category['id']])): ?>
				  <?php foreach ($groupedParts[$category['id']] as $part): ?>
					<div class="part-option">
					  <span><?php echo htmlspecialchars($part['name']); ?> - NT$<?php echo number_format($part['price']); ?>（庫存：<?php echo $part['stock']; ?>）</span>
					  <button type="button" onclick="selectPart(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($part['name'], ENT_QUOTES); ?>', <?php echo $part['id']; ?>)">選擇</button>
					</div>
				  <?php endforeach; ?>
				<?php else: ?>
				  <p>此分類暫無商品。</p>
				<?php endif; ?>
			  </div>
			  
			  <div id="parts-<?php echo $category['id']; ?>" class="parts-list">
				<?php if (isset($groupedParts[$category['id']])): ?>
				  <?php foreach ($groupedParts[$category['id']] as $part): ?>
					<div class="part-option">
					  <span><?php echo htmlspecialchars($part['name']); ?> - NT$<?php echo number_format($part['price']); ?>（庫存：<?php echo $part['stock']; ?>）</span>
					  <button type="button" onclick="selectPart(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($part['name'], ENT_QUOTES); ?>', <?php echo $part['id']; ?>)">選擇</button>
					</div>
				  <?php endforeach; ?>
				<?php else: ?>
				  <p>此分類暫無商品。</p>
				<?php endif; ?>
			  </div>
			</div>
		  <?php endforeach; ?>
		  <input type="hidden" name="cart_data" id="cartData">
		  
		  <button type="submit">🛒 加入購物車</button>
		</form>


	  </main>

  <footer>

  </footer>

  <script src="assets/script.js"></script>
</body>
</html>
