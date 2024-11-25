<?php
session_start();

// Kiểm tra nếu là Admin mới cho phép thêm hoa
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Nếu không phải Admin, chuyển hướng về trang chính
    exit;
}

// Xử lý thêm hoa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm hoa vào session
    $new_flower = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'image' => $_POST['image']
    ];
    $_SESSION['flowers'][] = $new_flower; // Thêm vào session

    // Chuyển hướng về trang danh sách hoa sau khi thêm
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hoa Mới</title>
</head>
<body>

    <h1>Thêm Hoa Mới</h1>
    <form action="add_flower.php" method="POST">
        <label for="name">Tên Hoa:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="description">Mô Tả:</label><br>
        <textarea name="description" id="description" rows="4" required></textarea><br><br>

        <label for="image">Link ảnh:</label><br>
        <input type="text" name="image" id="image" required><br><br>

        <button type="submit">Thêm Hoa</button>
    </form>

</body>
</html>
