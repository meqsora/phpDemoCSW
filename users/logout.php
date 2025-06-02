<?php
session_start();

// 清除所有 session 變數
session_unset();

// 銷毀 session
session_destroy();

// 清除 session cookie（可選）
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header("Location: ../index.php");
exit;

