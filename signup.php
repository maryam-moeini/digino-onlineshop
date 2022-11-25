<?php

require_once('dbconfig.php');
$page_title = "ایجاد حساب -فروشگاه اینترنتی دیجینو";
include_once("./include/header.php");
include("./functions/functions.php");

$hasError = false;
$usernametaken = false;
$emailtaken = false;

if (isset($_GET['error']) && isset($_GET['username']) && isset($_GET['email'])) {
    $hasError = true;
    $username = $_GET['username'];
    $email = $_GET['email'];

    if ($_GET['error'] == 'usernametaken') {
        $usernametaken = true;
    } else if ($_GET['error'] == 'emailtaken') {
        $emailtaken = true;
    }
}


?>

<main>

    <!-- horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <!-- Account Login -->
    <section class="signup">

        <div class="signup-wrapper">
            <div class="signup-header">
                <h1>ایجاد حساب کاربری</h1>
            </div>
            <form name="signup" action="./include/signup.inc.php" class="signup-form" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateSignupForm())">
                <?php
                if (isset($_GET['signup'])) {
                    if ($_GET['signup'] == 'successfull') {
                ?>
                        <div class="signup-message">
                            <p><i class="fas fa-check-circle"></i>حساب کاربری با موفقیت ایجاد شد.</p>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="form-control<?php echo $usernametaken ? " error" : "";
                                        echo $hasError == true && $usernametaken == false ? " success" : ""; ?>">
                    <label for="username">نام کاربری: </label>
                    <input type="text" id="username" name="username" <?php echo $hasError ? "value='$username'" : ""; ?>>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small><?php echo $usernametaken ? "نام کاربری قبلا انتخاب شده است." : ""; ?></small>
                </div>

                <div class="form-control<?php echo $emailtaken ? " error" : ""; ?>">
                    <label for="email">ایمیل: </label>
                    <input type="email" id="email" name="email" <?php echo $hasError ? "value='$email'" : ""; ?>>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small><?php echo $emailtaken ? "ایمیل قبلا انتخاب شده است." : ""; ?></small>
                </div>

                <div class="form-control">
                    <label for="password">رمز عبور: </label>
                    <input type="password" id="password" name="password">
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small></small>
                </div>

                <div class="form-control">
                    <label for="password2">تکرار رمر عبور: </label>
                    <input type="password" id="password2" name="password2">
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small></small>
                </div>

                <button type="submit" name="submit">ثبت</button>

            </form>
        </div>
    </section>

</main>

<?php

include_once("./include/footer.php");

?>