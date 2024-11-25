<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = $_POST['id'];

    $sql = "UPDATE products SET name = '$name', price = '$price' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
    <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
    <button type="submit">Cập nhật</button>
</form>
