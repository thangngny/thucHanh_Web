<?php
$host = 'localhost:3308';
$username = 'root';
$password = '';
$database = 'music_garden';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo "<div style='color: red;'>Kết nối thất bại: " . $conn->connect_error . "</div>";
} else {
    echo "<div style='color: green;'>Kết nối cơ sở dữ liệu thành công!</div>";
}
?>
