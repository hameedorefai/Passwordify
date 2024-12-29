<?php
include 'db.php';

// تحقق إذا كان تم إرسال الـ ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // استعلام لحذف كلمة المرور المولدة
    $sql = "DELETE FROM generated_passwords WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "تم حذف كلمة المرور بنجاح!";
    } else {
        echo "حدث خطأ أثناء الحذف.";
    }
} else {
    echo "لم يتم تحديد ID الحذف.";
}
?>

<!-- رابط للحذف -->
<a href="delete_password.php?id=1">حذف كلمة مرور ID 1</a>
