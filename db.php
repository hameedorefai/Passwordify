<?php
$host = "localhost"; // خادم قاعدة البيانات
$username = "root";  // اسم المستخدم
$password = "";      // كلمة المرور
$dbname = "PasswordifyDB"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($host, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
