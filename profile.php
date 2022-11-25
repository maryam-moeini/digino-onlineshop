<?php
require_once("./include/loginCheck.php");
$page_title = "پروفایل -فروشگاه اینترنتی دیجینو";
include_once("./include/header.php");
$page_subject = 'اطلاعات حساب';

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
            <div class="profile-content">
                <div class="account-info">
                    <div class="account-info-item">
                        <div>نام کاربری: </div>
                        <div><?php echo htmlentities($userInfo['username']) ?></div>
                    </div>
                    <div class="account-info-item">
                        <div>شماره موبایل: </div>
                        <div><?php echo $userInfo['phone'] != null ? htmlentities(toPersianNum($userInfo['phone'])) : "---" ?></div>
                    </div>
                    <div class="account-info-item">
                        <div>نام و نام‌خانوادگی: </div>
                        <div><?php echo $userInfo['name'] != null ? htmlentities($userInfo['name']) : "---" ?></div>
                    </div>
                    <div class="account-info-item">
                        <div>جنسیت: </div>
                        <div><?php echo $userInfo['gender'] != null ? htmlentities($userInfo['gender']) : "---" ?></div>
                    </div>
                    <div class="account-info-item">
                        <div>ایمیل: </div>
                        <div><?php echo htmlentities($userInfo['email']) ?></div>
                    </div>
                    <div class="account-info-item">
                        <div>آدرس: </div>
                        <div><?php echo $userInfo['address'] != null ? htmlentities($userInfo['address']) : "---" ?></div>
                    </div>
                </div>
                <div class="account-info-edit">
                    <a href="./edit_profile.php"><i class="far fa-edit"></i><span>ویرایش اطلاعات</span></a>
                </div>
            </div>
        </section>
    </div>

</main>


<?php
include_once("./include/footer.php");
?>