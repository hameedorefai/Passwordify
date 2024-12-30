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
$sql = "SELECT id, generated_password, created_at FROM generated_passwords WHERE user_id = ?";

// إعداد الاستعلام باستخدام العبارات المحضرة
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // عرض النتائج
    while ($row = $result->fetch_assoc()) {
        echo "<div id='password_".$row["id"]."'>";
        echo "<span id='password_text_".$row["id"]."'>" . htmlspecialchars($row["generated_password"]) . "</span>";
        echo "<button type='button' class='togglePassword' data-password-id='".$row["id"]."'>👁️ إظهار</button>";
        echo "<a href='delete_password.php?id=".$row["id"]."' onclick='return confirm(\"هل أنت متأكد من حذف هذه الكلمة؟\");'>حذف</a>";
        echo " - <a href='update_password.php?id=".$row["id"]."'>تحديث</a>";
        echo " - تم إنشاؤها في: " . htmlspecialchars($row["created_at"]);
        echo "</div><br>";
    }
} else {
    echo "لا توجد كلمات مرور مولدة.";
}

$stmt->close();
$conn->close();
?>

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
                this.textContent = '👁️ إخفاء'; // تغيير النص في الزر
            } else {
                // استبدال كلمة المرور بـ "********"
                this.setAttribute('data-original-password', passwordText.textContent); // حفظ الكلمة الأصلية في الـ attribute
                passwordText.textContent = '********'; // إخفاء كلمة المرور
                this.textContent = '🔒 إخفاء'; // تغيير النص في الزر
            }
        });
    });
</script>
