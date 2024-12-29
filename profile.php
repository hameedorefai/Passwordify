<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>الملف الشخصي</h1>
    </header>

    <main>
        <h2>مرحباً، <?php echo $user['name']; ?>!</h2>
        <p><strong>البريد الإلكتروني:</strong> <?php echo $user['email']; ?></p>
        <p><strong>حالة التحقق:</strong> <?php echo $user['is_email_verified'] ? 'مفعل' : 'غير مفعل'; ?></p>

        <a href="logout.php">تسجيل الخروج</a>
    </main>

    <footer>
        <p>&copy; 2024 منصة المستخدمين</p>
    </footer>
</body>
</html>
