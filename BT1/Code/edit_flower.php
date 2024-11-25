<?php
session_start();

// Kiểm tra nếu là Admin mới cho phép sửa hoa
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Nếu không phải Admin, chuyển hướng về trang chính
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $flower = $_SESSION['flowers'][$id]; // Lấy thông tin hoa cần sửa
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cập nhật thông tin hoa
    $_SESSION['flowers'][$id] = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'image' => $_POST['image']
    ];
    header('Location: index.php'); // Chuyển hướng về trang danh sách hoa
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Hoa</title>
</head>
<body>

    <h1>Sửa Hoa</h1>
    <form action="edit_flower.php?id=<?php echo $id; ?>" method="POST">
        <label for="name">Tên Hoa:</label><br>
        <input type="text" name="name" id="name" value="<?php echo $flower['name']; ?>" required><br><br>

        <label for="description">Mô Tả:</label><br>
        <textarea name="description" id="description" rows="4" required><?php echo $flower['description']; ?></textarea><br><br>

        <label for="image">Link ảnh:</label><br>
        <input type="text" name="image" id="image" value="<?php echo $flower['image']; ?>" required><br><br>

        <button type="submit">Lưu Thay Đổi</button>
    </form>

</body>
</html>
