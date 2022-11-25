<?php

require_once("./include/loginCheck.php");

if (isset($_POST['edit_account'])) {

    if (trim($_POST['username']) != "" && trim($_POST['email']) != "") {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone = setNull($_POST['phone']);
        $name = setNull($_POST['name']);
        $gender = setNull($_POST['gender']);
        $address = setNull($_POST['address']);

        $usernameExists = $conn->prepare("SELECT * FROM `users` WHERE id != :user_id AND username = :username");
        $usernameExists->execute(['username' => $username, 'user_id' => $user_id]);
        if ($usernameExists->rowCount() != 0) {
            $_SESSION['error'] = "username";
            header("Location: edit_profile.php");
            exit();
        }

        $emailExists = $conn->prepare("SELECT * FROM `users` WHERE id != :user_id AND email = :email");
        $emailExists->execute(['email' => $email, 'user_id' => $user_id]);
        if ($emailExists->rowCount() != 0) {
            $_SESSION['error'] = "email";
            header("Location: edit_profile.php");
            exit();
        }
        $accont_update = $conn->prepare("UPDATE `users` SET `username`= :username, `name`= :name,`email`= :email, `gender`= :gender, `phone`= :phone, `address`= :address WHERE id = :user_id");
        $accont_update->execute(['user_id' => $user_id, 'username' => $username, 'email' => $email, 'name' => $name, 'gender' => $gender, 'phone' => $phone, 'address' => $address]);

        header("Location: profile.php");
        exit();
    }
}

$page_title = "ویرایش پروفایل -فروشگاه اینترنتی دیجینو";
include_once("./include/header.php");
$page_subject = 'ویرایش اطلاعات شخصی';
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
                <h1><?php echo $page_subject; ?></h1>
            </div>
            <div class="profile-error" <?php echo isset($_SESSION['error']) ? 'style="display: block;"' : '' ?>>
                <i class="fas fa-exclamation-triangle"></i>
                <span>
                    <?php
                    if (isset($_SESSION['error'])) {

                        if ($_SESSION['error'] == 'username') {
                            echo 'نام کاربری وارد شده قبلاً ثبت شده است.';
                        } elseif ($_SESSION['error'] == 'email') {
                            echo 'ایمیل وارد شده قبلاً ثبت شده است.';
                        }
                        unset($_SESSION['error']);
                    }
                    ?>
                </span>
            </div>
            <form class="profile-content" name="account_info" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateProfileForm())">
                <div class="account-info">
                    <div class="account-info-item">
                        <div>نام کاربری: </div>
                        <input type="text" name="username" value="<?php echo htmlentities($userInfo['username']) ?>">
                    </div>
                    <div class="account-info-item">
                        <div>شماره موبایل: </div>
                        <input type="text" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" maxlength="11" value="<?php echo $userInfo['phone'] != null ? htmlentities($userInfo['phone']) : "" ?>">
                    </div>
                    <div class="account-info-item">
                        <div>نام و نام‌خانوادگی: </div>
                        <input type="text" name="name" value="<?php echo $userInfo['name'] != null ? htmlentities($userInfo['name']) : "" ?>">
                    </div>
                    <div class="account-info-item">
                        <div>جنسیت: </div>
                        <select name="gender">
                            <option value="" disabled selected></option>
                            <option value="مرد" <?php echo $userInfo['gender'] == "مرد" ? "selected" : "" ?>>مرد</option>
                            <option value="زن" <?php echo $userInfo['gender'] == "زن" ? "selected" : "" ?>>زن</option>
                        </select>
                    </div>
                    <div class="account-info-item">
                        <div>ایمیل: </div>
                        <input type="email" name="email" value="<?php echo htmlentities($userInfo['email']) ?>">
                    </div>
                    <div class="account-info-item">
                        <div>آدرس: </div>
                        <input type="text" name="address" value="<?php echo $userInfo['address'] != null ? htmlentities($userInfo['address']) : "" ?>">
                    </div>
                </div>
                <div class="account-info-edit">
                    <button type="submit" name="edit_account">ثبت</button>
                </div>
            </form>
        </section>
    </div>

</main>

<script>
    // hover and focus on input items to change style
    const profileInputs = document.querySelectorAll(".account-info-item input");
    const accountInfo = document.querySelector("form.profile-content .account-info");

    for (let profileInput of profileInputs) {
        profileInput.addEventListener("click", function() {
            if (accountInfo.querySelector(".focus")) {
                accountInfo.querySelector(".focus").classList.remove("focus");
            }
            if (this === document.activeElement) {
                this.parentElement.className = "account-info-item focus";
            }
        });
    }

    // unfocus inputs if click on outside the form
    function UnfocusProfile(e) {
        let isClickInside = accountInfo.contains(e.target);
        if (!isClickInside && accountInfo.querySelector(".focus")) {
            accountInfo.querySelector(".focus").classList.remove("focus");
        }
    }
    document.addEventListener("click", UnfocusProfile, false);

    // var input = document.account_info.username;
    // input.oninvalid = function(event) {
    //     event.target.setCustomValidity('نام کاربری فقط می‌تواند شامل حروف کوچک انگلیسی و اعداد باشد.');
    // }
</script>


<?php
include_once("./include/footer.php");
?>