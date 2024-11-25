<?php
session_start();

// Kiểm tra quyền Admin
$isAdmin = $_SESSION['isAdmin'] ?? false;
if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

// Lấy chỉ mục hoa cần sửa
$index = $_GET['index'] ?? null;
if ($index === null || !isset($_SESSION['flowers'][$index])) {
    header("Location: index.php");
    exit();
}

// Lấy thông tin hoa cần sửa
$flower = $_SESSION['flowers'][$index];

// Xử lý cập nhật thông tin hoa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';

    if ($name && $description && $image) {
        // Cập nhật thông tin hoa trong session
        $_SESSION['flowers'][$index] = [
            'name' => $name,
            'description' => $description,
            'image' => $image,
        ];
        header("Location: index.php");
        exit();
    } else {
        $error = "Tất cả các trường phải được điền đầy đủ.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Sửa Hoa</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Tên Hoa</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($flower['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($flower['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">URL Hình Ảnh</label>
            <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($flower['image']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật Hoa</button>
        <a href="index.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
