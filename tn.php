<?php
// Kết nối database và khởi tạo session
session_start();
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra đăng nhập
$isLoggedIn = isset($_SESSION['user_id']);

// Mảng từ khóa bị cấm
$forbiddenWords = ['thầy', 'cô', 'dm', 'vcl'];

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $noiDung = $conn->real_escape_string(trim($_POST['noi_dung']));
    
    // Kiểm tra từ cấm
    $isForbidden = false;
    foreach ($forbiddenWords as $word) {
        if (strpos(strtolower($noiDung), strtolower($word)) !== false) {
            $isForbidden = true;
            break;
        }
    }

    if ($isForbidden) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Nội dung chứa từ bị cấm! Vui lòng kiểm tra lại.'];
    } else if (empty($noiDung)) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Vui lòng nhập nội dung!'];
    } else {
        // Lấy ID tiếp theo
        $result = $conn->query("SELECT MAX(id) AS max_id FROM ykien");
        $row = $result->fetch_assoc();
        $nextId = isset($row['max_id']) ? $row['max_id'] + 1 : 1;

        // Tạo mã tin nhắn
        $maYkien = "#tl" . $nextId;
        $noiDungDayDu = $maYkien . " " . $noiDung;

        // Lưu vào database
        $sql = "INSERT INTO ykien (ma_ykien, noi_dung) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $maYkien, $noiDungDayDu);

        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Tin nhắn đã được gửi thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Có lỗi xảy ra: ' . $conn->error];
        }
        $stmt->close();
    }
    
    // Redirect để tránh gửi lại form khi refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn ẩn danh THPT Tân Lược</title>
    <style>
        :root {
            --primary-color: #2196f3;
            --success-color: #4caf50;
            --error-color: #f44336;
            --text-color: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.2);
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e88e5, #4caf50);
            padding: 20px;
            position: relative;
        }

        .container {
            width: 100%;
            max-width: 600px;
            animation: fadeIn 0.5s ease;
        }

        .message-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h1 {
            color: var(--text-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            text-shadow: 2px 2px 4px var(--shadow-color);
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: var(--text-color);
            margin-bottom: 10px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-color);
            font-size: 1rem;
            transition: all var(--transition-speed) ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--text-color);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        button {
            width: 100%;
            padding: 15px;
            background: var(--text-color);
            color: var(--primary-color);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--shadow-color);
        }

        button:active {
            transform: translateY(0);
        }

        .account-box {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        .avatar {
            width: 50px;
            height: 50px;
            background: var(--text-color);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        .account-menu {
            position: absolute;
            top: 60px;
            right: 0;
            background: var(--text-color);
            border-radius: 12px;
            padding: 10px;
            width: 200px;
            display: none;
            box-shadow: 0 4px 15px var(--shadow-color);
            animation: fadeIn 0.3s ease;
        }

        .account-menu a {
            display: block;
            padding: 12px 15px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            transition: background var(--transition-speed) ease;
        }

        .account-menu a:hover {
            background: rgba(33, 150, 243, 0.1);
        }

        .account-menu .logout-btn {
            color: var(--error-color);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 5px;
        }

        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 12px;
            color: var(--text-color);
            font-weight: 500;
            box-shadow: 0 4px 12px var(--shadow-color);
            z-index: 1000;
            animation: slideDown 0.5s ease forwards;
        }

        .toast.success {
            background: var(--success-color);
        }

        .toast.error {
            background: var(--error-color);
        }

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

        @keyframes slideDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .message-form {
                padding: 20px;
            }

            input[type="text"],
            button {
                padding: 12px;
            }

            .avatar {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="account-box">
        <?php if ($isLoggedIn): ?>
            <div class="avatar" onclick="toggleMenu()">T</div>
            <div class="account-menu" id="accountMenu">
                <a href="../admin/login.php">Trang quản trị</a>
                <a href="index.php" class="logout-btn">Đăng xuất</a>
            </div>
        <?php else: ?>
            <a href="../admin/login.php" class="avatar">?</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="message-form">
            <h1>Tin nhắn ẩn danh</h1>
            <form method="POST" onsubmit="return validateForm()">
                <div class="input-group">
                    <label for="noi_dung">Nhập nội dung tin nhắn:</label>
                    <input type="text" 
                           id="noi_dung" 
                           name="noi_dung" 
                           placeholder="Nhập tin nhắn của bạn..." 
                           required 
                           maxlength="500"
                           autocomplete="off">
                </div>
                <button type="submit">Gửi tin nhắn</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle menu account
        function toggleMenu() {
            const menu = document.getElementById('accountMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('accountMenu');
            const avatar = document.querySelector('.avatar');
            if (!avatar.contains(event.target) && !menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });

        // Show toast notification
        function showToast(message, type = 'success') {
            // Remove existing toast if any
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }

            // Create new toast
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Form validation
        function validateForm() {
            const content = document.getElementById('noi_dung').value.trim();
            if (!content) {
                showToast('Vui lòng nhập nội dung tin nhắn!', 'error');
                return false;
            }
            return true;
        }

        // Show PHP session message if exists
        <?php if (isset($_SESSION['message'])): ?>
            showToast(
                '<?php echo $_SESSION['message']['text']; ?>', 
                '<?php echo $_SESSION['message']['type']; ?>'
            );
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>