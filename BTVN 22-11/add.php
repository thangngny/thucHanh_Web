<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Tên sản phẩm" required>
    <input type="text" name="price" placeholder="Giá sản phẩm" required>
    <button type="submit">Thêm</button>
</form>
