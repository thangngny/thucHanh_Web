<?php
session_start();

// Kiểm tra xem người dùng có quyền Admin không
$isAdmin = $_SESSION['isAdmin'] ?? false;
if (!$isAdmin) {
    header('Location: index.php'); // Chuyển hướng về trang chủ hoặc trang login nếu không phải admin
    exit();
}

// Tạo thư mục 'uploads' nếu chưa tồn tại
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Lấy danh sách hoa từ session
$flowers = $_SESSION['flowers'] ?? [];

// Xử lý yêu cầu GET: Xóa hoặc sửa
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Xử lý xóa hoa
if ($action === 'delete' && isset($id) && isset($flowers[$id])) {
    $imagePath = $flowers[$id]['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath); // Xóa ảnh khỏi thư mục
    }
    unset($flowers[$id]); // Xóa hoa khỏi danh sách
    $_SESSION['flowers'] = array_values($flowers); // Đặt lại chỉ mục
    header('Location: admin.php');
    exit();
}

// Lấy thông tin hoa để sửa
$editFlower = null;
if ($action === 'edit' && isset($id) && isset($flowers[$id])) {
    $editFlower = $flowers[$id];
}

// Xử lý form khi thêm/sửa hoa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $editId = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : null;
    $imagePath = '';

    // Xử lý tệp ảnh (nếu có tải lên)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $imagePath = 'uploads/' . $newFileName;
            move_uploaded_file($fileTmpPath, $imagePath);
        }
    }

    // Xử lý sửa hoa
    if ($editId !== null && isset($flowers[$editId])) {
        $flowers[$editId]['name'] = $name;
        $flowers[$editId]['description'] = $description;
        if (!empty($imagePath)) {
            // Xóa ảnh cũ nếu có ảnh mới
            if (file_exists($flowers[$editId]['image'])) {
                unlink($flowers[$editId]['image']);
            }
            $flowers[$editId]['image'] = $imagePath;
        }
    } else {
        // Thêm hoa mới
        if (!empty($name) && !empty($description)) {
            $flowers[] = [
                'name' => $name,
                'description' => $description,
                'image' => $imagePath
            ];
        }
    }

    // Lưu lại danh sách hoa vào session
    $_SESSION['flowers'] = $flowers;
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .flower-card {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .flower-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .flower-card div {
            padding: 10px 20px;
            flex: 1;
        }
        .flower-card h3 {
            margin: 0;
            font-size: 1.5rem;
        }
        .flower-card p {
            margin: 10px 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Quản trị - Thêm/Sửa loài hoa</h1>

        <!-- Form thêm/sửa hoa -->
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <?php if ($editFlower !== null): ?>
                <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Tên Hoa:</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="<?php echo $editFlower['name'] ?? ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô Tả:</label>
                <textarea id="description" name="description" rows="4" class="form-control" required><?php echo $editFlower['description'] ?? ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Chọn hình ảnh:</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                <?php if ($editFlower !== null && !empty($editFlower['image'])): ?>
                    <p class="mt-2">Hình ảnh hiện tại:</p>
                    <img src="<?php echo $editFlower['image']; ?>" alt="Current Image" width="150">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-<?php echo $editFlower ? 'warning' : 'primary'; ?>">
                <?php echo $editFlower ? 'Cập Nhật Hoa' : 'Thêm Hoa'; ?>
            </button>
        </form>

        <!-- Danh sách hoa -->
        <h2 class="mb-4">Danh sách các loài hoa</h2>
        <?php if (!empty($flowers)): ?>
            <?php foreach ($flowers as $index => $flower): ?>
                <div class="flower-card">
                    <img src="<?php echo $flower['image']; ?>" alt="<?php echo $flower['name']; ?>">
                    <div>
                        <h3><?php echo $flower['name']; ?></h3>
                        <p><?php echo $flower['description']; ?></p>
                    </div>
                    <a href="admin.php?action=edit&id=<?php echo $index; ?>" class="btn btn-warning m-2">Sửa</a>
                    <a href="admin.php?action=delete&id=<?php echo $index; ?>" class="btn btn-danger m-2">Xóa</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có loài hoa nào được thêm!</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
