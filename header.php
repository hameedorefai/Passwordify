<!-- header.php -->
<body>
    <header>
        <div class="header-container">
            <!-- عنوان الموقع -->
            <h1>Passwordify</h1>
            <div class="logo">
                <span class="letter">🔒</span>
            </div>
            <!-- قائمة التنقل -->
            <nav>
                <ul>
                    
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="register.php">التسجيل</a></li>
                <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="passwords_managament.php">إدارة كلمات المرور</a></li>
                    <li><a href="add_password.php">إضافة كلمة مرور مولدة</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">الملف الشخصي</a></li>
                        <li><a href="logout.php">تسجيل الخروج</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
<!-- إضافة التنسيقات داخل ملف header.php -->
<style>
    .logo {
        width: 40px;
        height: 40px;
    
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: -60px;
    }

    .letter {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    h1 {
        display: flex;
        align-items: center;
        font-size: 24px;
        margin: 0;
    }

    body {
        font-family: Arial, sans-serif;
        direction: rtl;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #4CAF50;
        color: white;
        padding: 10px 0;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    h1 {
        font-size: 24px;
        margin: 0;
    }

    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin-left: 20px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
    }

    nav ul li a:hover {
        background-color: #45a049;
    }

    footer {
        text-align: center;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
