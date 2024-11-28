<?php
session_start();

// Kiểm tra quyền Admin
$isAdmin = $_SESSION['isAdmin'] ?? false;
if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

// Lấy chỉ mục hoa cần xóa
$index = $_GET['index'] ?? null;
if ($index === null || !isset($_SESSION['flowers'][$index])) {
    header("Location: index.php");
    exit();
}

// Xóa hoa khỏi session
unset($_SESSION['flowers'][$index]);

// Chuyển hướng về trang chính
header("Location: index.php");
exit();
