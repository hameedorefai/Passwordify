<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT); // تشفير كلمة المرور
    $is_email_verified = 0; // غير مفعل بشكل افتراضي

    $sql = "INSERT INTO users (name, email, password_hashed, is_email_verified) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password_hashed, $is_email_verified);

    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!-- HTML Form to add user -->
<form method="POST">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Create User">
</form>
