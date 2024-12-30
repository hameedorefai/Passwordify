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
    <?php include 'header.php'; ?>

    </header>

    <main>
        <section>
            <h2>أهلاً بك في منصة Passwordify</h2>
            <p>هذه المنصة مخصصة لإنشاء كلمات مرور قوية وعشوائية لمساعدتك في تأمين حساباتك الإلكترونية.</p>
            <p>سجل الدخول لتخزين كلمات السر بأمان.</p>
        </section>

        <section>
            <h3>المميزات</h3>
            <ul>
                <li>توليد كلمات مرور عشوائية وقوية</li>
                <li>حفظ كلمات المرور المولدة لكل مستخدم</li>
                <li>إمكانية عرض كلمات المرور المولدة من قبل المستخدمين</li>
                <li>إمكانية حذف كلمات المرور في أي وقتت.</li>
                <li>إرسال ايميل تأكيد مع كل عملية تسجيل دخول لضمان الأمان</li>
                <li>إمكانية تحديث الايميل في أي وقت</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 منصة Passwordify</p>
    </footer>
</body>
</html>
