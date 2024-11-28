    <?php
    // Đường dẫn tới file CSV
    $file = 'KTPM2.csv';

    // Kiểm tra file có tồn tại không
    if (!file_exists($file) || !is_readable($file)) {
        die("Không thể đọc file CSV.");
    }

    // Mở file để đọc
    if (($handle = fopen($file, "r")) !== false) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>";
        // Đọc dòng đầu tiên (header)
        if (($header = fgetcsv($handle, 1000, ",")) !== false) {
            foreach ($header as $column) {
                echo "<th>" . htmlspecialchars($column) . "</th>";
            }
            echo "</tr>";
        }
        // Đọc các dòng còn lại (data)
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            echo "<tr>";
            foreach ($row as $data) {
                echo "<td>" . htmlspecialchars($data) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($handle);
    } else {
        die("Không thể mở file CSV.");
    }
    ?>
