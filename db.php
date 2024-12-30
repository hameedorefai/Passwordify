<?php
$servername = "localhost";  // اسم الخادم (localhost في حال كان الخادم محلياً)
$username = "root";         // اسم المستخدم (افتراضي في كثير من الأحيان يكون root)
$password = "";             // كلمة السر (غالباً فارغة في بيئات التطوير المحلية)
$dbname = "passwordifydb";  // اسم قاعدة البيانات التي تريد الاتصال بها

// إنشاء الاتصال
$conn = new mysqli($servername, $username, password: $password, database: $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
} 

?>
