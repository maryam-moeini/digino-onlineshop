<?php

require_once('dbconfig.php');
$page_title = "ورود به حساب -فروشگاه اینترنتی دیجینو";
include_once("./include/header.php");
include("./functions/functions.php");

?>

<main>

    <!-- horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <!-- Account Login -->
    <section class="login">

        <div class="login-wrapper">
            <div class="login-header">
                <h1>ورود به حساب کاربری</h1>
            </div>
            <form name="login" action="./include/login.inc.php" class="login-form" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateLoginForm())">
                <?php
                if (isset($_GET['error'])) {

                    if ($_GET['error'] == 'wronglogin') {
                ?>
                        <div class="login-message">
                            <p><i class="fas fa-exclamation-circle"></i>اطلاعات وارد شده صحیح نمی باشد.</p>
                        </div>
                    <?php
                    } elseif ($_GET['error'] == 'loginfirst') {
                    ?>
                        <div class="login-message">
                            <p><i class="fas fa-exclamation-circle"></i>برای افزودن کالا به سبد خرید باید ابتدا وارد حساب شوید.</p>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="form-control">
                    <label for="username">نام کاربری یا ایمیل: </label>
                    <input type="text" id="username" name="username">
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small></small>
                </div>

                <div class="form-control">
                    <label for="password">رمز عبور: </label>
                    <input type="password" id="password" name="password">
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small></small>
                </div>

                <button type="submit" name="submit">ثبت</button>

                <a href="./signup.php"><small><i class="fas fa-user-plus"></i>ایجاد حساب کاربری</small></a>

            </form>
        </div>
    </section>

</main>

<?php

include_once("./include/footer.php");

?>