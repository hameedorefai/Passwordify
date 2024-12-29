<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT); // تشفير كلمة المرور

    // تحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل في قاعدة البيانات
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // إذا كان البريد الإلكتروني موجودًا
    if ($stmt->num_rows > 0) {
        $error = "البريد الإلكتروني هذا موجود بالفعل. يرجى استخدام بريد إلكتروني آخر.";
    } else {
        // إذا كان البريد الإلكتروني غير موجود، قم بإدخال البيانات
        $is_email_verified = 0;
        $sql = "INSERT INTO users (name, email, password_hashed, is_email_verified) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $password_hashed, $is_email_verified);

        if ($stmt->execute()) {
            header('Location: login.php'); // إعادة توجيه إلى صفحة تسجيل الدخول بعد التسجيل
        } else {
            $error = "حدث خطأ أثناء التسجيل. يرجى المحاولة مرة أخرى.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التسجيل</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>التسجيل</h1>
    </header>

    <main>
        <form method="POST" action="register.php">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required><br>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <input type="submit" value="تسجيل">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 منصة المستخدمين</p>
    </footer>
</body>
</html>
