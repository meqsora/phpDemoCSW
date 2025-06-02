<?php
require_once '../database/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // 刪除分類前，先確認是否有商品綁定這個分類（建議先避免刪除有商品的分類）
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM parts WHERE category_id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        echo "此分類尚有商品，無法刪除。請先移除或變更商品分類。";
        echo "<br><a href='categories_list.php'>回分類列表</a>";
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: categories_list.php");
exit;
