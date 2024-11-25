<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BaiTapVeNha</title>
    <!-- Liên kết file CSS -->
    <link rel="stylesheet" href="stylee.css">
</head> 
<header class="lopDau">
    <div class="container">
        <!-- Menu -->
        <div class="Menu">
            <a href="#" class="admin-link">Administration</a>
            <a href="#">Trang chủ</a>
            <a href="#">Trang ngoài</a>
            <a href="#" class="theLoai-link">Thể loại</a>
            <a href="#">Tác giả</a>
            <a href="#">Bài viết</a>
        </div>
        <hr>
        <!-- Nút thêm mới -->
        <button class="btn-add" onclick="window.location.href='add.php'">Thêm mới</button>
    </div>
</header>
<body class="lopThan">
    <!-- Bảng danh sách sản phẩm -->
    <table class="table-margin">
        <thead>
            <tr>
                <th class="tr-TieuDe">Sản phẩm</th>
                <th>Giá Thành</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Kết nối đến cơ sở dữ liệu
            $host = 'localhost:3308';
            $username = 'root';
            $password = '';
            $database = 'music_garden';

            $conn = new mysqli($host, $username, $password, $database);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Truy vấn dữ liệu từ bảng `products`
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            // Kiểm tra kết quả truy vấn và hiển thị dữ liệu
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">
                                <span class="icon edit">&#9998;</span>
                            </a>
                        </td>
                        <td>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                <span class="icon delete">&#128465;</span>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='4'>Không có sản phẩm nào</td></tr>";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </tbody>
    </table>
</body> 
<footer>
    <hr>
    <h1 class="footer">TLU'S MUSIC GARDEN</h1>
</footer>
</html>
