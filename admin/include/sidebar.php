<?php
session_start();
require_once('dbconfig.php');

if ( ! isset($_SESSION['adminId'])) {
    header("Location:login.php");
    exit();
}

$admin_id = $_SESSION['adminId'];
$admin = $conn->prepare("SELECT * FROM `admin` WHERE id = :admin_id");
$admin->bindParam(":admin_id", $admin_id, PDO::PARAM_STR);
$admin->execute();
$admin = $admin -> fetch(PDO::FETCH_ASSOC);
 
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
    <title><?php echo $page_title; ?>- پنل ادمین</title>

</head>

<body>

    <input type="checkbox" id="nav-toggle">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="./logo/T401642966026465.png" alt="">
            <!-- <h2>دیجینو</h2> -->
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="./index.php" <?php echo $page_title == "داشبورد" ? 'class="active"' : ''; ?>><i class="fas fa-th-large"></i><span>داشبورد</span></a>
                </li>
                <li>
                    <a href="./orders.php" <?php echo $page_title == "سفارشات" ? 'class="active"' : ''; ?>><i class="fas fa-shopping-cart"></i><span>سفارشات</span></a>
                </li>
                <li>
                    <a href="./products.php" <?php echo $page_title == "محصولات" ? 'class="active"' : ''; ?>><i class="fas fa-shopping-basket"></i><span>محصولات</span></a>
                </li>
                <li>
                    <a href="./users.php" <?php echo $page_title == "حساب‌های کاربری" ? 'class="active"' : ''; ?>><i class="fas fa-user-circle"></i><span>حساب‌های کاربری</span></a>
                </li>
                <li>
                    <a href="./comments.php" <?php echo $page_title == "نظرات" ? 'class="active"' : ''; ?>><i class="fas fa-comments"></i><span>نظرات</span></a>
                </li>
                <li>
                    <a href="./subscribers.php" <?php echo $page_title == "دنبال‌کننده ها" ? 'class="active"' : ''; ?>><i class="fas fa-users"></i><span>دنبال‌کننده ها</span></a>
                </li>

                <li>
                    <a href="./logout.php"><i class="fas fa-sign-out-alt"></i><span>خروج</span></a>
                </li>

            </ul>
        </div>
    </div>