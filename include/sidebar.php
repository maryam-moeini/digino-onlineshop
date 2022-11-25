
<input type="checkbox" id="sidebar-toggle">

<section class="sidebar">
    <div class="sidebar-header">
        <div class="user-img"><img src="images/user/account_circle_icon.png" alt=""></div>
        <div class="user-username">
            <h2><?php echo htmlentities($userInfo['username']) ?></h2>
            <?php if ($userInfo['name'] != null) { ?>
                <small><?php echo htmlentities($userInfo['name']) ?></small>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li><a href="./profile.php" <?php echo $page_subject == "اطلاعات حساب" ? 'class="active"' : ''; ?>><i class="fas fa-user"></i><span>اطلاعات حساب</span></a></li>
            <li><a href="./cart.php" <?php echo $page_subject == "سبد خرید من" ? 'class="active"' : ''; ?>><i class="fas fa-shopping-bag"></i><span>سبد خرید من</span></a></li>
            <li><a href="./orders.php" <?php echo $page_subject == "سفارش‌های من" ? 'class="active"' : ''; ?>><i class="fas fa-receipt"></i><span>سفارش‌های من</span></a></li>
            <li><a href="./wishlist.php" <?php echo $page_subject == "علاقه‌مندی ها" ? 'class="active"' : ''; ?>><i class="fas fa-heart"></i><span>علاقه‌مندی ها</span></a></li>
            <li><a href="./change_password.php" <?php echo $page_subject == "تغییر رمز عبور" ? 'class="active"' : ''; ?>><i class="fas fa-lock"></i><span>تغییر رمز عبور</span></a></li>
            <li><a href="./include/logout.inc.php"><i class="fas fa-sign-out-alt"></i><span>خروج</span></a></li>
        </ul>
    </div>
    <div class="sidebar-toggle-container">
    <label for="sidebar-toggle">
        <i class="fas fa-angle-down"></i>
    </label>
    </div>
</section>