<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['subscribe'])) {

    if ($_SESSION['subscribe'] == 'wrongemail') {
        echo "<script>alert('ایمیل نامعتبر است');</script>";
    } else if ($_SESSION['subscribe'] == 'emailtaken') {
        echo "<script>alert('ایمیل شما قبلا در خبرنامه ثبت شده است.');</script>";
    } else if ($_SESSION['subscribe'] == 'done') {
        echo "<script>alert('ایمیل شما با موفقیت در خبرنامه ثبت شد.');</script>";
    }

    unset($_SESSION['subscribe']);
}

$fullheart = false;
if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];
    $haswishlist = $conn->prepare("SELECT product_id FROM `wishlist` WHERE user_id = :user_id;");
    $haswishlist->execute(['user_id' => $user_id]);
    $wishlist = $haswishlist ->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png" />
    <link rel="manifest" href="images/favicon/site.webmanifest" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />

    <!-- font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->

    <!-- costume stylesheet -->
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/style.css" />

    <!-- jquery link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Title -->
    <title><?php echo $page_title; ?></title>

</head>
<?php
include_once("./include/loading.php");
?>
<body>

    <div id="invisible"></div>
    <!-- back to top button -->
    <a id="backtop" href="#header"><i class="fas fa-chevron-up"></i></a>

    <!-- header -->
    <header id="header">

        <!-- navigaion -->
        <nav class="nav">

            <!-- logo -->
            <div class="logo">
                <a href="index.php">
                    <img src="./images/logo/T401643010454809.png" alt="">
                </a>
            </div>

            <!-- menu -->
            <ul class="menu">
                <li class="menu-item"><a href="index.php">صفحه‌اصلی</a></li>
                <li class="menu-item has-submenu <?php echo $current_page == 'products' ? "active" : ""; ?>">
                    <p>محصولات</p>
                    <ul class="submenu">
                        <li class="submenu-item"><a href="products.php?ctg=headphone">هدفون</a></li>
                        <li class="submenu-item"><a href="products.php?ctg=handsfree">هندزفری</a></li>
                        <li class="submenu-item"><a href="products.php?ctg=mobileCover">کاور موبایل</a></li>
                        <li class="submenu-item"><a href="products.php?ctg=smartWatch">ساعت‌هوشمند</a></li>
                    </ul>
                </li>
                <li class="menu-item <?php echo $current_page == 'about' ? "active" : ""; ?>"><a href="about.php">درباره</a></li>
                <li class="menu-item <?php echo $current_page == 'contact' ? "active" : ""; ?>"><a href="contact.php">ارتباط</a></li>
                <li class="menu-item has-submenu">
                    <p>حساب‌کاربری</p>
                    <ul class="submenu acc-submenu">
                        <?php if (isset($_SESSION['userId'])) { ?>
                            <li class="submenu-item"><a href="./profile.php">پروفایل من</a></li>
                            <li class="submenu-item"><a href="./include/logout.inc.php">خروج</a></li>
                        <?php
                        } else {
                        ?>
                            <li class="submenu-item"><a href="./login.php">ورود به حساب</a></li>
                            <li class="submenu-item"><a href="./signup.php">ایجاد حساب‌کاربری</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>

            <!-- menu icons -->
            <ul class="icon-container">
                <li class="menu-icon">
                    <a class="icon open-search" href="#">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
                <li class="menu-icon">
                    <a class="icon shopping-bag" href="./cart.php">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="badge"></span>
                    </a>
                </li>
            </ul>

            <!-- hamburger menu -->
            <div class="open-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="close-nav">
                <i class="fas fa-times"></i>
            </div>
        </nav>
        <div class="search-container">
            <form action="./search.php" method="GET" name="search" autocomplete="off">
                <div class="search-bar">
                    <input type="text" placeholder="جستجو در دیجینو ..." name="q">
                </div>
            </form>
        </div>
    </header>