<?php
session_start();

// 檢查是否登入
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit;
}

// 取得 POST 的 JSON 資料
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart_data'])) {
        $cartData = json_decode($_POST['cart_data'], true);
        if (!is_array($cartData)) {
            echo "格式錯誤";
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        foreach ($cartData as $categoryId => $partId) {
            $_SESSION['cart'][(int)$categoryId] = (int)$partId;
        }

        header("Location: cart.php");
        exit;
    } else {
        echo "缺少 cart_data";
    }
}


// 初始化購物車陣列
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 加入/覆蓋商品
foreach ($cartData as $categoryId => $partId) {
    $_SESSION['cart'][$categoryId] = $partId;
}

// 導向購物車頁
header("Location: cart.php");
exit;
