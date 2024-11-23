<?php
session_start();
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    // Sử dụng Prepared Statement để bảo mật
    $sql = "SELECT id, role, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu (nếu đã mã hóa mật khẩu, dùng password_verify)
        if (password_verify($password, $user['password'])) {
            // Kiểm tra vai trò hợp lệ
            $valid_roles = ['admin', 'kzi', 'hoangoanh'];
            if (in_array($user['role'], $valid_roles)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập trang quản trị.'];
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Tên đăng nhập hoặc mật khẩu không chính xác.'];
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Tên đăng nhập không tồn tại.'];
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-form { width: 300px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .login-form h2 { margin-bottom: 20px; font-size: 1.5rem; text-align: center; }
        .login-form input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .login-form button { width: 100%; padding: 10px; background-color: #2196f3; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .login-form button:hover { background-color: #1976d2; }
        .error { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Đăng nhập</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="error"><?php echo $_SESSION['message']['text']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
