<?php
session_start();

function generateRandomPassword($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-+=<>?';
    $password = '';
    $charactersLength = strlen($characters);
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwordLength = $_POST['password_length'];
    $generatedPassword = generateRandomPassword($passwordLength);
    $userId = $_SESSION['user_id']; // افترضنا أن المستخدم قد قام بتسجيل الدخول

    // حفظ كلمة المرور في قاعدة البيانات
    include 'db.php';
    $sql = "INSERT INTO generated_passwords (user_id, generated_password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $generatedPassword);

    if ($stmt->execute()) {
        $successMessage = "تم إنشاء كلمة المرور بنجاح: $generatedPassword";
    } else {
        $errorMessage = "حدث خطأ أثناء إضافة كلمة المرور.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء كلمة مرور</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>إنشاء كلمة مرور عشوائية</h1>
        <nav>
            <a href="index.php">الصفحة الرئيسية</a>
            <a href="add_password.php">إنشاء كلمة مرور</a>
        </nav>
    </header>

    <main>
        <?php if (isset($successMessage)): ?>
            <p style="color: green; text-align: center;"><?php echo $successMessage; ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="POST" action="add_password.php">
            <label for="password_length">أدخل طول كلمة المرور المطلوبة:</label>
            <input type="number" id="password_length" name="password_length" min="8" required><br>

            <input type="submit" value="توليد كلمة المرور">
        </form>

        <?php if (isset($generatedPassword)): ?>
            <div class="generated-password">
                <h2>كلمة المرور المولدة:</h2>
                <p style="font-weight: bold;"><?php echo $generatedPassword; ?></p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 منصة Passwordify</p>
    </footer>
</body>
</html>
