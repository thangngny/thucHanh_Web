<?php
// Đường dẫn đến tệp CSV
$filename = 'KTPM2.csv';

// Kiểm tra xem tệp có tồn tại không
if (file_exists($filename)) {
    // Mở tệp CSV
    $file = fopen($filename, 'r');
    
    // Đọc tiêu đề (dòng đầu tiên)
    $header = fgetcsv($file);
    
    echo "<h2>Dữ liệu từ file CSV:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>" . implode("</th><th>", $header) . "</th></tr>";
    
    // Đọc dữ liệu từng dòng
    while (($row = fgetcsv($file)) !== false) {
        echo "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";
    }
    
    echo "</table>";
    
    // Đóng tệp sau khi xử lý xong
    fclose($file);
} else {
    echo "Tệp không tồn tại.";
}
?>
