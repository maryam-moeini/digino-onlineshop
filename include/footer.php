
<footer id="footer" class="footer">
    <div class="footer-container">
        <div class="footer-center">
            <h3 class="accordion">اطلاعات فروشگاه</h3>
            <div class="footer-center_links">
                <div>
                    <span>
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    سمنان، انتهای بلوار 17 شهریور، خیابان مالک اشتر، جنب فنی و حرفه‌ای خواهران، پردیس فرزانگان دانشگاه سمنان
                </div>
                <div>
                    <span>
                        <i class="far fa-envelope"></i>
                    </span>
                    company@gmail.com
                </div>
                <div>
                    <span>
                        <i class="fas fa-phone"></i>
                    </span>
                    67437-021 و 63454000-021 <br />هفت روز هفته، ۲۴ ساعت شبانه‌روز پاسخگوی
                    شما هستیم.
                </div>
            </div>
        </div>

        <div class="footer-center">
            <h3 class="accordion">لینک های مفید</h3>
            <div class="footer-center_links">
                <a href="index.php#bestselling">پرفروش ترین ها</a>
                <a href="index.php#latestProducts">محصولات جدید</a>
                <a href="about.php">درباره دیجینو</a>
                <a href="contact.php">تماس با ما</a>
            </div>
        </div>

        <div class="footer-center">
            <h3 class="accordion">حساب‌کاربری</h3>
            <div class="footer-center_links">
                <a href="<?php echo isset($_SESSION['userId']) ? 'orders.php':'login.php'; ?>">سفارشات من</a>
                <a href="<?php echo isset($_SESSION['userId']) ? 'profile.php':'login.php'; ?>">اطلاعات شخصی من</a>
                <a href="<?php echo isset($_SESSION['userId']) ? 'wishlist.php':'login.php'; ?>">علاقه‌مندی های من</a>
            </div>
        </div>

        <div class="footer-center">
            <h3>مارا دنبال کنید</h3>
            <form action="./include/subscribe.inc.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="footer_email-content">
                    <h4>از جدیدترین تخفیف های سایت باخبر شوید</h4>
                </div>
                <div class="footer_email-box">
                    <input type="email" class="footer_email-request" name="email" placeholder="آدرس ایمیل خود را وارد کنید" />
                    <button type="submit" class="footer_email-submit" name="subscribe"></button>
                </div>
            </form>

            <div class="social-icons">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-telegram-plane"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>
</footer>

<script src="js/main.js"></script>
<script src="js/script.js"></script>
</body>

</html>