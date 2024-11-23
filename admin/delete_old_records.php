<?php
// Kết nối tới database
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xóa các bản ghi cũ hơn 5 ngày
$sql = "DELETE FROM ykien WHERE created_at < NOW() - INTERVAL 5 DAY";

if ($conn->query($sql) === TRUE) {
    echo "Xóa thành công các bản ghi cũ.";
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>
