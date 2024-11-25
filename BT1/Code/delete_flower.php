<?php
session_start();

// Kiểm tra nếu là Admin mới cho phép xóa hoa
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Nếu không phải Admin, chuyển hướng về trang chính
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_SESSION['flowers'][$id]); // Xóa hoa khỏi session
    $_SESSION['flowers'] = array_values($_SESSION['flowers']); // Đảm bảo danh sách không bị bỏ trống
    header('Location: index.php'); // Quay lại trang danh sách hoa
    exit;
}
?>
