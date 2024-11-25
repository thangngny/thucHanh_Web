<?php
session_start();

// Kiểm tra và thêm hoa vào session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['role'])) {
    $_SESSION['role'] = $_POST['role']; // Cập nhật session
    header('Location: index.php');
    exit;
}

// Kiểm tra và khởi tạo session nếu chưa có
if (!isset($_SESSION['flowers'])) {
    $_SESSION['flowers'] = [
        [
            'name' => 'Dạ yến thảo',
            'description' => 'Dạ yến thảo là lựa chọn thích hợp cho những ai yêu thích trồng hoa...',
            'image' => '/ThucHanh/BTTH01/BT1/anhhoa/dayenthao.webp'
        ],
        [
            'name' => 'Hoa Đồng Tiền',
            'description' => 'Hoa đồng tiền thích hợp để trồng trong mùa xuân và đầu mùa hè...',
            'image' => '/ThucHanh/BTTH01/BT1/anhhoa/hoadongtien.webp'
        ],
        [
            'name' => 'Hoa Giấy',
            'description' => 'Hoa giấy có mặt ở hầu khắp mọi nơi trên đất nước ta...',
            'image' => '/ThucHanh/BTTH01/BT1/anhhoa/hoagiay.webp'
        ],
        [
            'name' => 'Hoa Thanh Tú',
            'description' => 'Mang dáng hình tao nhã, màu sắc thiên thanh dịu dàng...',
            'image' => '/ThucHanh/BTTH01/BT1/anhhoa/hoathanhtu.webp'
        ],
    ];
}

$flowers = $_SESSION['flowers'];

// Kiểm tra nếu người dùng đã đăng nhập và lưu trạng thái (admin hoặc user)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'user'; // Mặc định là người dùng bình thường
}

// Thay đổi giao diện khi là Admin
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Hoa</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .flower-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 250px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .flower-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .flower-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .flower-card p {
            font-size: 14px;
            color: #555;
        }
        .admin-button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .admin-button:hover {
            background-color: #0056b3;
        }
        .admin-only {
            display: <?php echo $isAdmin ? 'inline-block' : 'none'; ?>;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Danh Sách Hoa</h1>

    <!-- Hiển thị giao diện tùy thuộc vào quyền hạn -->
    <?php if ($isAdmin): ?>
        <a href="add_flower.php">
            <button class="admin-button">Thêm Hoa Mới</button>
        </a>
        <h3>Chế độ Admin - Quản lý Hoa</h3>
    <?php else: ?>
        <h3>Chế độ Người Dùng</h3>
    <?php endif; ?>

    <!-- Liệt kê các hoa -->
    <div class="container">
        <?php foreach ($flowers as $key => $flower): ?>
            <div class="flower-card">
                <img src="<?php echo $flower['image']; ?>" alt="<?php echo $flower['name']; ?>">
                <h3><?php echo $flower['name']; ?></h3>
                <p><?php echo $flower['description']; ?></p>
                <?php if ($isAdmin): ?>
                    <a href="edit_flower.php?id=<?php echo $key; ?>">Sửa</a> |
                    <a href="delete_flower.php?id=<?php echo $key; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Chuyển giữa chế độ Admin và Người dùng -->
    <form action="" method="POST">
        <?php if ($isAdmin): ?>
            <button type="submit" name="role" value="user">Chuyển sang Người Dùng</button>
        <?php else: ?>
            <button type="submit" name="role" value="admin">Chuyển sang Admin</button>
        <?php endif; ?>
    </form>

</body>
</html>
