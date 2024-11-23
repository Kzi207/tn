<?php
// Kết nối database
$conn = new mysqli("localhost", "dkhanhduy_tn", "dkhanhduy_tn", "dkhanhduy_tn");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm, sửa, xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $id = intval($_POST['id']);
        $noiDung = trim($_POST['noi_dung']);
        if (empty($noiDung)) {
            echo "Nội dung không được để trống!";
        } else {
            $stmt = $conn->prepare("UPDATE ykien SET noi_dung = ? WHERE id = ?");
            $stmt->bind_param("si", $noiDung, $id);
            if ($stmt->execute()) {
                echo "Cập nhật thành công.";
            } else {
                echo "Lỗi: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM ykien WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Xóa thành công.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
        $stmt->close();
    }
}

// Truy vấn danh sách ý kiến
$selectedDate = $_GET['date'] ?? date("Y-m-d");
$result = $conn->query("SELECT ykien.id, ma_ykien, noi_dung, created_at, username 
                        FROM ykien 
                        LEFT JOIN users ON ykien.id = users.id 
                        WHERE DATE(created_at) = '$selectedDate' 
                        ORDER BY created_at ASC");

if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Ý Kiến</title>
    <style>
        /* Reset và style cơ bản */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    background-color: #f5f7fa;
    color: #333;
    padding: 2rem;
}

/* Header styles */
h1 {
    color: #2c3e50;
    margin-bottom: 2rem;
    font-size: 2.2rem;
    text-align: center;
    font-weight: 600;
}

/* Form styles */
form {
    margin-bottom: 2rem;
}

.date-filter {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

label {
    font-weight: 500;
    margin-right: 1rem;
}

input[type="date"] {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-right: 1rem;
}

button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}

/* Table styles */
table {
    width: 100%;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

th {
    background-color: #34495e;
    color: white;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.9rem;
    padding: 1rem;
}

td {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background-color: #f8f9fa;
}

/* Input styles */
input[type="text"] {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus {
    border-color: #3498db;
    outline: none;
}

/* Button styles in table */
td button {
    margin: 0 0.25rem;
    padding: 0.4rem 0.8rem;
    font-size: 0.9rem;
}

button[name="update"] {
    background-color: #2ecc71;
}

button[name="update"]:hover {
    background-color: #27ae60;
}

button[name="delete"] {
    background-color: #e74c3c;
}

button[name="delete"]:hover {
    background-color: #c0392b;
}

/* Export link style */
a {
    display: inline-block;
    background-color: #9b59b6;
    color: white;
    padding: 0.8rem 1.5rem;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    font-weight: 500;
}

a:hover {
    background-color: #8e44ad;
}

/* Responsive styles */
@media (max-width: 768px) {
    body {
        padding: 1rem;
    }
    
    table {
        display: block;
        overflow-x: auto;
    }
    
    td button {
        margin: 0.25rem 0;
        display: block;
        width: 100%;
    }
}
    </style>
</head>
<body>
    <h1>Quản Lý Ý Kiến</h1>
    <form method="GET">
        <label for="date">Chọn ngày:</label>
        <input type="date" name="date" id="date" value="<?php echo $selectedDate; ?>">
        <button type="submit">Lọc</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Mã Ý Kiến</th>
                <th>Nội Dung</th>
                <th>Người Dùng</th>
                <th>Thời Gian</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <form method="POST">
                        <td><?php echo htmlspecialchars($row['ma_ykien'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <input type="text" name="noi_dung" value="<?php echo htmlspecialchars($row['noi_dung'], ENT_QUOTES, 'UTF-8'); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="update">Cập Nhật</button>
                            <button type="submit" name="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="export.php?date=<?php echo $selectedDate; ?>">Tải File Word</a>
</body>
</html>
<?php
$conn->close();
?>
