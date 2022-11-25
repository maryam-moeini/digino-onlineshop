<?php
require_once('dbconfig.php');
$page_title = "ارتباط با ما -فروشگاه اینترنتی دیجینو";
$current_page = "contact";

if (isset($_POST['new-message'])) {

    $subject = trim($_POST['subject']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);
    
    if ($subject !== "" && $name !== "" && $email !== "" && $phone !== "" && $message !== "") {
        
        $sql = $conn -> prepare("INSERT INTO `messages`(`subject`, `name`, `email`, `phone`, `message`) VALUES (:subject, :name, :email, :phone, :message)");
        $sql -> execute(['subject' => $subject, 'name' => $name, 'email' => $email,'phone' => $phone, 'message' => $message]);

        session_start();
        $_SESSION['message'] = "message send!";
        header("Location:contact.php");
        exit();
    } 
}

include_once("./include/header.php");
?>

<main>
    <!-- Horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <!-- Map section -->
    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1445.597380121925!2d53.36862050599843!3d35.57206354946521!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f9a4d8f8c130233%3A0xb8aa06971070fe1b!2z2K_Yp9mG2LTar9in2Ycg2YHYsdiy2KfZhtqv2KfZhiDYs9mF2YbYp9mG!5e0!3m2!1sen!2s!4v1629547415839!5m2!1sen!2s" width="100%" height="350" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
    </section>

    <!-- Contact section -->
    <section class="contact">
        <div class="contact-container">
            <div class="contact-content">
                <div class="contact-title">
                    <h1>ارتباط با ما</h1>
                </div>
                <div>
                    <span>
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <strong>آدرس: </strong>سمنان، انتهای بلوار ۱۷ شهریور، خیابان مالک اشتر، جنب فنی و حرفه‌ای خواهران، پردیس فرزانگان دانشگاه سمنان
                </div>
                <div>
                    <span>
                        <i class="far fa-envelope"></i>
                    </span>
                    <strong>ایمیل: </strong>company@gmail.com
                </div>
                <div>
                    <span>
                        <i class="fas fa-phone"></i>
                    </span>
                    <strong>تلفن تماس: </strong>67437-021 و 63454000-021 <br /><span><i class="far fa-clock"></i></span> هفت روز هفته،
                    ۲۴ ساعت شبانه‌روز پاسخگوی شما هستیم.
                </div>
            </div>
            <div class="contact-form-container">
                <div class="contact-form-error">
                    <p><i class="fas fa-exclamation-circle"></i><span id="contact-form-errormessage"></span></p>
                </div>
                <?php
                    if(isset($_SESSION['message'])) {
                ?>
                <div class="contact-form-success">
                    <p><i class="fas fa-check-circle"></i>پیام شما با موفقیت ارسال شد.</p>
                </div>
                <?php
                    unset($_SESSION['message']);
                }
                ?>
                <form name="contact_form" class="contact-form" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateContactForm())">
                    <select name="subject">
                        <option value="" disabled selected>انتخاب موضوع</option>
                        <option value="پیشنهاد">پیشنهاد</option>
                        <option value="انتقاد یا شکایات">انتقاد یا شکایات</option>
                        <option value="مدیریت">مدیریت</option>
                        <option value="حسابداری و امور مالی">حسابداری و امور مالی</option>
                        <option value="سایر موضوعات">سایر موضوعات</option>
                    </select>
                    <input type="text" name="name" placeholder="نام و نام‌خانوادگی" />
                    <input type="email" name="email" placeholder="ایمیل" />
                    <input type="text" name="phone" placeholder="تلفن تماس" />
                    <textarea name="message" cols="30" rows="8" placeholder="متن پیام"></textarea>
                    <input class="contact-submit" type="submit" name="new-message" value="ارسال" />
                </form>
            </div>
        </div>
    </section>
</main>

<?php

include_once("./include/footer.php");

?>