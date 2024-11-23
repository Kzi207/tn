<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .dashboard { text-align: center; }
        .dashboard h1 { font-size: 2rem; color: #333; }
        .dashboard a { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; }
        .dashboard a:hover { background-color: #d32f2f; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Chào mừng đến trang quản trị</h1>
        <a href="logout.php">Đăng xuất</a>
    </div>
</body>
</html>
