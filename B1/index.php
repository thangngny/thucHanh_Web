<?php
session_start();

// Khởi tạo danh sách hoa nếu chưa có trong session
if (!isset($_SESSION['flowers'])) {
    $_SESSION['flowers'] = [
        [
            'name' => 'Hoa Dạ Yến Thảo',
            'description' => 'Dạ yến thảo có thể nở rực quanh năm, thích hợp trồng ở ban công hay cửa sổ, với sắc màu đa dạng và mềm mại.',
            'image' => '/ThucHanh/BTTH01/BTTH/B1/imagess/HoaDaYenThao.webp'
        ],  
        [
            'name' => 'Hoa Giấy',
            'description' => 'Hoa giấy mỏng manh nhưng lâu tàn, với nhiều màu sắc khác nhau, dễ trồng và mang lại vẻ đẹp bừng sáng cho không gian.',
            'image' => 'imagess/HoaGiay.webp'
        ],
        [
            'name' => 'Hoa Thanh Tú',
            'description' => 'Hoa thanh tú mang dáng hình tao nhã, sắc xanh dịu dàng, dễ trồng và nở nhiều hoa trong điều kiện có ánh nắng.',
            'image' => 'imagess/HoaThanhTu.webp'
        ],
        [
            'name' => 'Hoa Đèn Lồng',
            'description' => 'Hoa có hình dáng giống chiếc đèn lồng đỏ, trồng trong chậu treo hoặc bồn, tạo vẻ đẹp độc đáo và thu hút.',
            'image' => 'imagess/HoaDenLong.webp'
        ],
        [
            'name' => 'Hoa Cẩm Chướng',
            'description' => 'Hoa cẩm chướng có màu sắc đa dạng, mang vẻ đẹp nhẹ nhàng và thích hợp trưng bày trên bàn để làm đẹp không gian.',
            'image' => 'imagess/HoaCamChuong.webp'
        ],
        [
            'name' => 'Hoa Huỳnh Anh',
            'description' => 'Hoa huỳnh anh vàng rực rỡ, dễ trồng, thích hợp để tô điểm ban công hoặc hàng rào với vẻ đẹp đầy sức sống.',
            'image' => 'imagess/HoaHuynhAnh.webp'
        ],
        [
            'name' => 'Hoa Păng-xê',
            'description' => 'Păng-xê còn gọi là hoa bướm, với cánh hoa mềm mại, màu sắc tinh tế, thường được trồng trong chậu nhỏ, tạo vẻ đẹp dịu dàng.',
            'image' => 'imagess/HoaPangXe.webp'
        ],
        [
            'name' => 'Hoa Sen',
            'description' => 'Hoa sen biểu tượng cho vẻ đẹp thanh tao, có thể trồng trong ao vườn hoặc chậu, mang lại không gian yên bình.',
            'image' => 'imagess/HoaSen.webp'
        ],
    ];
}

$flowers = $_SESSION['flowers']; // Lấy danh sách hoa từ session

// Xác định trạng thái Admin/User
$isAdmin = $_SESSION['isAdmin'] ?? false;

// Chuyển đổi quyền giữa Admin và User
if (isset($_GET['toggle_role'])) {
    $isAdmin = !$isAdmin; // Đảo ngược quyền admin
    $_SESSION['isAdmin'] = $isAdmin; // Cập nhật lại quyền vào session
    header("Location: index.php"); // Điều hướng lại trang để cập nhật trạng thái quyền
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Các Loài Hoa</title>
    <style>
        .flower-card {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .flower-card img {
            width: 150px;
            height: 150px;
            margin-right: 15px;
        }
        .admin-controls {
            margin-bottom: 20px;
        }
        .admin-controls button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }
        .admin-actions {
            margin-top: 10px;
        }
        .admin-actions a {
            margin-right: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<h1>Danh sách các loài hoa</h1>

<!-- Nút chuyển đổi giữa Admin và User -->
<div class="admin-controls">
    <form method="GET" action="">
        <button type="submit" name="toggle_role">
            Chuyển sang chế độ <?php echo $isAdmin ? 'Người dùng' : 'Quản trị'; ?>
        </button>
    </form>
</div>

<!-- Hiển thị danh sách hoa -->
<?php if ($isAdmin): ?>
    <h2>Chế độ Quản trị</h2>
    <p>Bạn có thể chỉnh sửa thông tin hoa tại đây.</p>
    <a href="add_flower.php">Thêm hoa mới</a> <!-- Thêm hoa mới -->
    <?php foreach ($flowers as $index => $flower): ?>
        <div class="flower-card">
            <img src="<?php echo $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>">
            <div>
                <h2><?php echo htmlspecialchars($flower['name']); ?></h2>
                <p><?php echo htmlspecialchars($flower['description']); ?></p>
                <div class="admin-actions">
                    <a href="edit_flower.php?index=<?php echo $index; ?>">Chỉnh sửa</a> <!-- Sửa hoa -->
                    <a href="delete_flower.php?index=<?php echo $index; ?>">Xóa</a> <!-- Xóa hoa -->
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h2>Chế độ Người dùng</h2>
    <?php foreach ($flowers as $flower): ?>
        <div class="flower-card">
            <img src="<?php echo $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>">
            <div>
                <h2><?php echo htmlspecialchars($flower['name']); ?></h2>
                <p><?php echo htmlspecialchars($flower['description']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
