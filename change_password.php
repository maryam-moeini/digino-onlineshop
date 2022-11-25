<?php

require_once("./include/loginCheck.php");

$oldPwdHashed = $userInfo['password'];

if (isset($_POST['change_password'])) {

    if (trim($_POST['old_password']) != "" && trim($_POST['new_password']) != "" && trim($_POST["new_password2"]) != "") {

        $old_password = trim($_POST['old_password']);
        $new_password = trim($_POST['new_password']);

        $checkPwd = password_verify($old_password, $oldPwdHashed);

        if ($checkPwd == true) {
            $hashedPwd = password_hash($new_password, PASSWORD_DEFAULT);
            $password_update = $conn->prepare("UPDATE `users` SET `password`= :password WHERE id = :user_id");
            $password_update->execute(['user_id' => $user_id, 'password' => $hashedPwd]);

            $_SESSION['password'] = "done";
            header("Location: change_password.php");
            exit();
        } else if ($checkPwd == false) {
            $_SESSION['password'] = "wrong";
            header("Location: change_password.php");
            exit();
        }
    }
}

$page_title = "تغییر رمز عبور -فروشگاه اینترنتی دیجینو";
include_once("./include/header.php");
$page_subject = 'تغییر رمز عبور';
?>

<main>
    <!-- horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <div class="profile">

        <!-- Sidebar -->
        <?php
        include_once("./include/sidebar.php");
        ?>

        <!-- content -->
        <section class="content">
            <div class="profile-title">
                <h1><?php echo $page_subject;?></h1>
            </div>
            <?php
            if (isset($_SESSION['password'])) {
                if ($_SESSION['password'] == "done") {
            ?>
                    <div class="profile-form-success">
                        <p><i class="fas fa-check-circle"></i>رمز عبور جدید شما با موفقیت ثبت شد.</p>
                    </div>
            <?php
                }
            }
            ?>
            <div class="profile-error<?php echo isset($_SESSION['password']) && $_SESSION['password']=="wrong" ? " active" : "";?>">
                <i class="fas fa-exclamation-triangle"></i>
                <span>
                    <?php
                    if (isset($_SESSION['password'])) {
                        if ($_SESSION['password'] == "wrong") {
                            echo "رمز عبور فعلی صحیح نمی باشد.";
                        }
                        unset($_SESSION['password']);
                    }
                    ?>
                </span>
            </div>
            <form class="profile-content" name="update_password" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validatePasswordForm())">
                <div class="password-wrapper">
                    <div class="password-item">
                        <label for="old-password">رمز عبور فعلی: </label>
                        <input type="password" name="old_password" id="old-password">
                    </div>
                    <div class="password-item">
                        <label for="new-password">رمز عبور جدید: </label>
                        <input type="password" name="new_password" id="new-password">
                    </div>
                    <div class="password-item">
                        <label for="new-password2">تکرار رمز عبور جدید: </label>
                        <input type="password" name="new_password2" id="new-password2">
                    </div>
                </div>
                <div class="password-change">
                    <button type="submit" name="change_password">ثبت</button>
                </div>
            </form>
        </section>
    </div>

</main>


<?php
include_once("./include/footer.php");
?>