<?php
session_start();
require_once '../database/db.php'; // 資料庫連線

// 檢查是否已登入
if (!isset($_SESSION["user_id"])) {
    header("Location: users/login.php");
    exit;
}

// 如果還沒選任何商品
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cartEmpty = true;
} else {
    $cartEmpty = false;
    $cart = $_SESSION['cart']; // 格式：['category_id' => part_id, ...]
}

// 取得所有分類名稱
$categoryNames = [];
$categoryStmt = $pdo->query("SELECT id, name FROM categories");
while ($row = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryNames[$row['id']] = $row['name'];
}

// 取得所有選擇的商品資料
$selectedParts = [];
$totalPrice = 0;

if (!$cartEmpty) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM parts WHERE id IN ($placeholders)");
    $stmt->execute(array_values($cart));

    while ($part = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selectedParts[] = $part;
        $totalPrice += $part['price'];
    }
}

// 移除單一商品
if (isset($_GET['remove'])) {
    $removeCatId = (int)$_GET['remove'];
    unset($_SESSION['cart'][$removeCatId]);
    header("Location: cart.php");
    exit;
}

// 清空整個購物車
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>購物車</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <h2>🛒 購物車內容</h2>
  <p><a href="../index.php">← 返回商品瀏覽</a></p>
  <hr>

  <?php if ($cartEmpty): ?>
    <p>目前購物車是空的。</p>
  <?php else: ?>
    <table border="1" cellpadding="10">
      <thead>
        <tr>
          <th>分類</th>
          <th>商品名稱</th>
          <th>價格</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($selectedParts as $part): ?>
          <tr>
            <td><?php echo htmlspecialchars($categoryNames[$part['category_id']] ?? '未知分類'); ?></td>
            <td><?php echo htmlspecialchars($part['name']); ?></td>
            <td>NT$<?php echo number_format($part['price']); ?></td>
            <td>
              <a href="cart.php?remove=<?php echo $part['category_id']; ?>">取消此項</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="2" align="right"><strong>總金額</strong></td>
          <td colspan="2"><strong>NT$<?php echo number_format($totalPrice); ?></strong></td>
        </tr>
      </tbody>
    </table>

    <p>
      <a href="cart.php?clear=1" onclick="return confirm('確定要清空購物車嗎？');">🗑️ 清空購物車</a>
    </p>

  <?php endif; ?>
  <script src="../assets/script.js"></script>
</body>
</html>
