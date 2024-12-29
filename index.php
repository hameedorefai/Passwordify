<?php
// بدء الجلسة (اختياري إذا كنت بحاجة للتحقق من تسجيل الدخول)
session_start();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>مرحبًا بك في منصة Passwordify</h1>
        <nav>
            <ul>
                <li><a href="register.php">التسجيل</a></li>
                <li><a href="login.php">تسجيل الدخول</a></li>
                <li><a href="view_passwords.php">عرض كلمات المرور المولدة</a></li>
                <li><a href="add_password.php">إضافة كلمة مرور مولدة</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">الملف الشخصي</a></li>
                    <li><a href="logout.php">تسجيل الخروج</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>أهلاً بك في منصة Passwordify</h2>
            <p>هذه المنصة مخصصة لإنشاء كلمات مرور قوية وعشوائية لمساعدتك في تأمين حساباتك الإلكترونية.</p>
            <p>ابدأ الآن عن طريق التسجيل أو تسجيل الدخول.</p>
        </section>

        <section>
            <h3>المميزات</h3>
            <ul>
                <li>توليد كلمات مرور عشوائية وقوية</li>
                <li>حفظ كلمات المرور المولدة لكل مستخدم</li>
                <li>إمكانية عرض وحذف كلمات المرور المولدة من قبل المستخدمين</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 منصة Passwordify</p>
    </footer>
</body>
</html>
