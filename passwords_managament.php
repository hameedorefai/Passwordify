<?php
session_start();
include 'db.php';

// التحقق من أن المستخدم مسجل دخوله
if (!isset($_SESSION['user_id'])) {
    echo "لم تقم بتسجيل الدخول!";
    exit();
}

// دالة لتوليد كلمة مرور عشوائية
function generateRandomPassword($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-+=<>?';
    $password = '';
    $charactersLength = strlen($characters);
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
}

// معالجة طلب توليد كلمة مرور جديدة
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwordLength = $_POST['password_length'];
    $generatedPassword = generateRandomPassword($passwordLength);
    $userId = $_SESSION['user_id']; // افترضنا أن المستخدم قد قام بتسجيل الدخول

    // حفظ كلمة المرور في قاعدة البيانات
    $sql = "INSERT INTO generated_passwords (user_id, generated_password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $generatedPassword);

    if ($stmt->execute()) {
        $successMessage = "تم إنشاء كلمة المرور بنجاح: $generatedPassword";
    } else {
        $errorMessage = "حدث خطأ أثناء إضافة كلمة المرور.";
    }
}

// استعلام لاسترجاع كلمات المرور المولدة الخاصة بالمستخدم
$userId = $_SESSION['user_id'];
$sql = "SELECT id, generated_password, created_at FROM generated_passwords WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة كلمات المرور</title>
    <style>
        /* إعدادات الصفحة */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            direction: rtl;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        main {
            margin: 20px;
        }

        h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 15px;
        }

        /* رسائل النجاح والخطأ */
        .success-message {
            color: green;
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* تصميم البطاقة التي تحتوي على كلمات المرور */
        .password-card {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .password-text {
            font-size: 18px;
            font-weight: bold;
        }

        .togglePassword {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .togglePassword:hover {
            background-color: #45a049;
        }

        .password-actions {
            margin-top: 10px;
        }

        .password-actions a {
            color: #4CAF50;
            text-decoration: none;
        }

        .password-actions a:hover {
            text-decoration: underline;
        }

        .created-at {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }

        /* تصميم الروابط (حذف، تحديث) */
        .delete-link {
            color: #e74c3c;
            font-weight: bold;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        .update-link {
            color: #3498db;
            font-weight: bold;
        }

        .update-link:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
    <?php include 'header.php'; ?>

        <h1>إدارة كلمات المرور</h1>
    </header>

    <main>
        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <!-- نموذج لتوليد كلمة مرور -->
        <h2>كلمات المرور المولدة:</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="password-card">
                    <span class="password-text" id="password_text_<?php echo $row["id"]; ?>"><?php echo htmlspecialchars($row["generated_password"]); ?></span>
                    <button type="button" class="togglePassword" data-password-id="<?php echo $row["id"]; ?>">👁️ إظهار</button>
                    <div class="password-actions">
                        <a href="delete_password.php?id=<?php echo $row["id"]; ?>" class="delete-link" onclick="return confirm('هل أنت متأكد من حذف هذه الكلمة؟');">حذف</a>
                        <span>-</span>
                    </div>
                    <div class="created-at">تم إنشاؤها في: <?php echo htmlspecialchars($row["created_at"]); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>لا توجد كلمات مرور مولدة.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 منصة Passwordify</p>
    </footer>

    <!-- JavaScript لإخفاء/إظهار كلمات السر -->
    <script>
    document.querySelectorAll('.togglePassword').forEach(function(button) {
        
        button.addEventListener('click', function() {
            // تحديد العنصر الذي يحتوي على كلمة المرور
            var passwordId = this.getAttribute('data-password-id');
            var passwordText = document.getElementById('password_text_' + passwordId);
            // إذا كانت كلمة المرور مخفية، نعرض "********"، وإذا كانت ظاهرة نعيد الكلمة الأصلية
            if (passwordText.textContent === '********') {
                // إظهار كلمة المرور الأصلية
                passwordText.textContent = this.getAttribute('data-original-password');
                this.textContent = '🔒 إخفاء'; // تغيير النص في الزر

            } else {
                // استبدال كلمة المرور بـ "********"
                this.setAttribute('data-original-password', passwordText.textContent); // حفظ الكلمة الأصلية في الـ attribute
                passwordText.textContent = '********'; // إخفاء كلمة المرور
                this.textContent = '👁️ إظهار'; // تغيير النص في الزر

            }
        });
    });
</script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
