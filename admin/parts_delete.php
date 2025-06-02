<?php
require_once '../database/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM parts WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: parts_list.php");
exit;
