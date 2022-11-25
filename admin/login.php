<?php
require_once('dbconfig.php');

if (isset($_POST['login'])) {
    
    if (trim($_POST['username']) != '' && trim($_POST['password']) != '') {
        
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $user_select = $conn->prepare("SELECT * FROM `admin` WHERE password = :password AND (username = :username OR email = :username);");
        $user_select->execute(['password' => $password, 'username' => $username, 'email' => $username]);
        $admin = $user_select -> fetch(PDO::FETCH_ASSOC);
        
        if ($user_select->rowCount() == 1) {
            session_start();
            $_SESSION['adminId'] = $admin['id'];
            header("Location:index.php");
            exit();
        } else {
            header("Location:login.php?err_msg");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../images/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png" />
    <link rel="manifest" href="../images/favicon/site.webmanifest" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Box icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />

    <!-- font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- costume stylesheet -->
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/style.css" />

    <!-- jquery link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Title -->
    <title>ورود ادمین</title>

</head>

<body>
    <main class="login-main">
        <div class="login-header">
            <h1>دیجینو</h1>
        </div>
        <div class="login-form-container">
            <?php
            if (isset($_GET['err_msg'])) {
            ?>
                <div class="iformation-error">
                    <p><i class="fas fa-exclamation-circle"></i>اطلاعات وارد شده صحیح نمی‌باشد.</p>
                </div>
            <?php
            }
            ?>
            <form name="admin_login" id="admin_login" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateLoginForm())">
                <div class="form-control">
                    <label for="username">نام کاربری یا ایمیل:</label>
                    <input type="text" id="username" name="username">
                    <small>
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </small>
                </div>
                <div class="form-control">
                    <label for="password">رمز عبور:</label>
                    <input type="password" id="password" name="password">
                    <small>
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </small>
                </div>
                <div class="form-control">
                    <input type="submit" name="login" value="ورود">
                </div>
            </form>
        </div>
        <div class="back-mainpage">
            <a href="../index.php">&#8594 برگشت به صفحه اصلی</a>
        </div>
    </main>

    <script src="./js/script.js"></script>
</body>

</html>