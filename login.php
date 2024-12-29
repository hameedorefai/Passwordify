<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hashed'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: profile.php');
    } else {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>تسجيل الدخول</h1>
    </header>

    <main>
        <form method="POST" action="login.php">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required><br>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <input type="submit" value="تسجيل الدخول">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 منصة المستخدمين</p>
    </footer>
</body>
</html>
