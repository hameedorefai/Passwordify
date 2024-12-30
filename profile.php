<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        main {
            padding: 20px;
            background-color: white;
            max-width: 800px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 18px;
            margin: 8px 0;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }

        .update-form {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .update-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .update-form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .update-form input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <h2>مرحباً، <?php echo $user['name']; ?>!</h2>
        <div class="user-info">
            <p><strong>البريد الإلكتروني:</strong> <?php echo $user['email']; ?></p>
            <p><strong>حالة التحقق:</strong> <?php echo $user['is_email_verified'] ? 'مفعل' : 'غير مفعل'; ?></p>
        </div>

        <a href="logout.php" class="btn">تسجيل الخروج</a>

        <div class="update-form">
            <h3>تحديث المعلومات</h3>
            <form method="POST" action="update_user.php">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                <label for="name">الاسم:</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required />
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required />
                <label for="password">كلمة المرور الحالية:</label>
                <input type="password" name="password" required />
                <input type="submit" value="تحديث المعلومات" />
            </form>
        </div>

    </main>

    <footer>
        <p>&copy; 2024 منصة المستخدمين</p>
    </footer>

</body>
</html>
