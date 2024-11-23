<?php
// Kết nối đến database
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Xử lý đăng nhập và đăng ký
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // Xác định hành động: đăng nhập hoặc đăng ký

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($action === 'register') { // Xử lý đăng ký
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);

        if (mysqli_stmt_execute($stmt)) {
            echo "Đăng ký thành công! Bạn có thể đăng nhập.";
        } else {
            echo "Lỗi: Tài khoản đã tồn tại hoặc lỗi hệ thống!";
        }
    } elseif ($action === 'login') { // Xử lý đăng nhập
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: tn.php"); // Chuyển hướng đến tn.php
                exit();
            } else {
                echo "Sai mật khẩu!";
            }
        } else {
            echo "Tài khoản không tồn tại!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập và Đăng ký</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            width: 400px;
            backdrop-filter: blur(10px);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .form-section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .form-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

<?php
// Kết nối đến database
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Xử lý đăng nhập và đăng ký
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // Xác định hành động: đăng nhập hoặc đăng ký

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($action === 'register') { // Xử lý đăng ký
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);

        if (mysqli_stmt_execute($stmt)) {
            echo "Đăng ký thành công! Bạn có thể đăng nhập.";
        } else {
            echo "Lỗi: Tài khoản đã tồn tại hoặc lỗi hệ thống!";
        }
    } elseif ($action === 'login') { // Xử lý đăng nhập
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: tn.php"); // Chuyển hướng đến tn.php
                exit();
            } else {
                echo "Sai mật khẩu!";
            }
        } else {
            echo "Tài khoản không tồn tại!";
        }
    }
}
?>
        h2 {
            color: #2d3748;
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
            background: rgba(255, 255, 255, 0.9);
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        button {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .switch-link {
            margin-top: 20px;
            display: block;
            color: #667eea;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .switch-link:hover {
            color: #764ba2;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            text-align: left;
        }

        @media (max-width: 480px) {
            .container {
                width: 100%;
                padding: 30px 20px;
            }

            h2 {
                font-size: 24px;
            }
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Error message styling */
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
            animation: fadeIn 0.3s ease;
        }

        /* Success message styling */
        .success-message {
            color: #38a169;
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 id="form-title">Đăng nhập</h2>

        <!-- Đăng nhập -->
        <div id="login-section" class="form-section active">
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <label>Tài khoản</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Đăng nhập</button>
            </form>
            <a class="switch-link" onclick="toggleForm('register')">Chưa có tài khoản? Đăng ký ngay</a>
        </div>

        <!-- Đăng ký -->
        <div id="register-section" class="form-section">
            <form method="POST">
                <input type="hidden" name="action" value="register">
                <div class="input-group">
                    <label>Tài khoản</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Đăng ký</button>
            </form>
            <a class="switch-link" onclick="toggleForm('login')">Đã có tài khoản? Đăng nhập</a>
        </div>
    </div>

    <script>
        function toggleForm(action) {
            const registerSection = document.getElementById('register-section');
            const loginSection = document.getElementById('login-section');
            const formTitle = document.getElementById('form-title');

            if (action === 'register') {
                registerSection.classList.add('active');
                loginSection.classList.remove('active');
                formTitle.innerText = 'Đăng ký';
            } else {
                loginSection.classList.add('active');
                registerSection.classList.remove('active');
                formTitle.innerText = 'Đăng nhập';
            }
        }
    </script>
</body>
</html>