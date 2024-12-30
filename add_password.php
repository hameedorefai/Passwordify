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
    $notes = $_POST['notes'] ?? '';
    $generatedPassword = generateRandomPassword($passwordLength);
    $userId = $_SESSION['user_id'] ?? 10; // افترضنا أن المستخدم قد قام بتسجيل الدخول

    // حفظ كلمة المرور في قاعدة البيانات
    include 'db.php';
    $sql = "INSERT INTO generated_passwords (user_id, generated_password, notes) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $generatedPassword, $notes);

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        main {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .copy-btn {
            background-color:rgb(59, 172, 65);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .copy-btn:hover {
            background-color:rgb(45, 122, 49);
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #f1f1f1;
        }
    </style>
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
            <p style="color: green; text-align: center; font-weight: bold;"><?php echo $successMessage; ?></p>
            <button class="copy-btn" onclick="copyToClipboard('<?php echo $generatedPassword; ?>')">نسخ كلمة المرور</button>
        <?php elseif (isset($errorMessage)): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="POST" action="add_password.php">
            <label for="password_length">أدخل طول كلمة المرور المطلوبة:</label>
            <input type="number" id="password_length" name="password_length" min="8" required>

            <label for="notes">ملاحظات (اختياري):</label>
            <textarea id="notes" name="notes" placeholder="أدخل أي ملاحظات هنا..."></textarea>

            <input type="submit" value="توليد كلمة المرور">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 منصة Passwordify</p>
    </footer>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                console('تم نسخ كلمة المرور بنجاح!');
            }).catch(err => {
                alert('فشل النسخ: ' + err);
            });
        }
    </script>
</body>
</html>
