<?php
// Kết nối tới cơ sở dữ liệu
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng ykien
$sql = "SELECT ma_ykien, noi_dung FROM ykien ORDER BY created_at DESC";
$result = $conn->query($sql);

// Kiểm tra có dữ liệu không
if ($result->num_rows > 0) {
    // Mở file TXT để ghi
    $fileName = 'ykien_' . date('Ymd_His') . '.txt';
    $filePath = 'exports/' . $fileName;

    // Kiểm tra nếu thư mục không tồn tại thì tạo mới
    if (!is_dir('exports')) {
        mkdir('exports', 0777, true); // Tạo thư mục với quyền ghi
    }

    $file = fopen($filePath, 'w'); // Mở file trong chế độ ghi

    // Duyệt qua dữ liệu và ghi vào file TXT
    while ($row = $result->fetch_assoc()) {
        // In ra mã ý kiến và nội dung theo định dạng yêu cầu
        $content = $row['ma_ykien'] . ' ' . $row['noi_dung'] . "\n";
        fwrite($file, $content); // Ghi dữ liệu vào file
    }

    fclose($file); // Đóng file sau khi ghi xong

    // Cung cấp file TXT để người dùng tải về
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    readfile($filePath); // Đọc và tải file về

    // Xóa file sau khi tải về (tuỳ chọn, bạn có thể bỏ qua phần này)
    unlink($filePath); // Xóa file sau khi tải về

} else {
    echo "Không có dữ liệu.";
}

$conn->close();
?>
