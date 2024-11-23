<?php
$directory = __DIR__ . '/exports/';
$logFile = $directory . 'cleanup_log.txt';

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (file_exists($line)) {
            $fileTime = filemtime($line); // Thời gian tạo file
            if (time() - $fileTime >= 86400) { // 86400 giây = 24 giờ
                unlink($line); // Xóa file
                echo "Đã xóa: $line\n";
            }
        }
    }
    // Xóa log rỗng
    file_put_contents($logFile, implode("\n", array_filter($lines, 'file_exists')));
}
?>
