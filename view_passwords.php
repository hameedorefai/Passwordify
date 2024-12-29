<?php
session_start();
include 'db.php';

// التحقق من أن المستخدم مسجل دخوله
if (!isset($_SESSION['user_id'])) {
    echo "لم تقم بتسجيل الدخول!";
    exit();
}

// استعلام لاسترجاع كلمات المرور المولدة الخاصة بالمستخدم
$userId = $_SESSION['user_id'];
$sql = "SELECT generated_password, created_at FROM generated_passwords WHERE user_id = ?";

// إعداد الاستعلام باستخدام العبارات المحضرة
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // عرض النتائج
    while ($row = $result->fetch_assoc()) {
        echo "كلمة المرور: " . $row["generated_password"] . " - تم إنشاؤها في: " . $row["created_at"] . "<br>";
    }
} else {
    echo "لا توجد كلمات مرور مولدة.";
}

$stmt->close();
$conn->close();
?>
