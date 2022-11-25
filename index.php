<?php

require_once('dbconfig.php');
$page_title = "فروشگاه اینترنتی دیجینو";
$current_page = "home";
include_once("./include/header.php");
include("./functions/functions.php");

?>

<main>

    <!-- horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <!-- Intro section-->
    <section class="intro">

        <!-- right image -->
        <div class="intro_rightImg">
            <img src="images/intro/jascent-leung-678CnSHWuXU-unsplash2.jpg" alt="" />
            <div class="rightIimg-content">
                <div class="rightIimg-text">
                    <h2>طراحی شده برای شما</h2>
                    <h3>انواع کاور موبایل</h3>
                </div>
                <button class="buy-btn">
                    <a href="./products.php?ctg=mobileCover">خرید<span>&#10095;</span></a>
                </button>
            </div>
        </div>

        <!-- Slideshow container -->
        <div class="slideshow-container">
            <!-- Full-width images with number and caption text -->
            <div class="slides fade slide1">
                <img src="images/intro/christopher-gower-_aXa21cf7rY-unsplash (3).jpg" />
                <div class="slide1-content">
                    <h2>به بهترین ها فکر کنید!</h2>
                    <h3>بهترین کیفیت و کمترین هزینه را در سایت ما بیابید</h3>
                </div>
            </div>

            <div class="slides fade slide2">
                <img src="images/intro/rupixen-com-3I41s9-BMro-unsplash.jpg" />
                <div class="slide2-content">
                    <div class="slide2-discount">
                        <h3>تخفیف تا ۲۵٪</h3>
                    </div>
                    <div class="slide2-text">
                        <h2>صدا در جریان است</h2>
                        <h3>هندزفری سیمی اپل</h3>
                    </div>
                    <button class="buy-btn">
                        <a href="./productPage.php?p=22">خرید<span>&#10095;</span></a>
                    </button>
                </div>
            </div>

            <div class="slides fade slide2">
                <img src="images/intro/marcin-nowak-vWTimrvu2dc-unsplash.jpg" />
                <div class="slide3-content">
                    <div class="slide3-discount">
                        <h3>تخفیف تا ۲۵٪</h3>
                    </div>
                    <div class="slide3-text">
                        <h2>همراه همیشگی تو</h2>
                        <h3>ساعت هوشمند اپل</h3>
                    </div>
                    <button class="buy-btn">
                        <a href="./productPage.php?p=1">خرید<span>&#10095;</span></a>
                    </button>
                </div>
            </div>

            <!-- Next and previous buttons -->
            <a class="prev-slide" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next-slide" onclick="plusSlides(1)">&#10095;</a>

            <!-- The dots/circles -->
            <div class="dots-container">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>

        <!-- <br /> -->
    </section>

    <!-- advert section -->
    <section class="advert">
        <div class="advert-center">
            <div class="advert-box">
                <div class="advert-content">
                    <h2>هندزفری بی‌سیم</h2>
                    <h4>انواع هندزفری های سیمی و بی‌سیم</h4>
                </div>
                <img src="images/advert/pic1.png" alt="" />
            </div>

            <div class="advert-box">
                <div class="advert-content">
                    <h2>ساعت هوشمند</h2>
                    <h4>انواع ساعت های هوشمند</h4>
                </div>
                <img src="images/advert/daniel-tomlinson-fFJqJ_GWxxk-unsplash-removebg-preview3.png" alt="" />
            </div>

            <div class="advert-box">
                <div class="advert-content">
                    <h2>هدفون</h2>
                    <h4>انواع هدفون های سیمی و بلوتوثی</h4>
                </div>
                <img src="images/advert/pic7.png" alt="" />
            </div>
        </div>
    </section>

    <!-- bestselling section -->
    <section class="bestselling products" id="bestselling">
        <div class="products-top">
            <div class="bestselling-title products-title">
                <h1>پرفروش ترین های هفته</h1>
            </div>
            <div class="button-container">
                <div class="button-right">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="button-left">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </div>
        </div>

        <div class="bestselling-container products-container">
            <?php
            $sql = "SELECT * FROM `products` ORDER BY sales_num DESC LIMIT 7";
            $products = $conn->query($sql);

            if ($products->rowCount() > 0) {

                $i = 1;
                foreach ($products as $product) {

                    if (isset($_SESSION['userId']) && is_int(array_search($product['id'], array_column($wishlist, 'product_id')))) {
                        $fullheart = true;
                    } else {
                        $fullheart = false;
                    }

            ?>
                    <div class="product" <?php if ($i == 1) {
                                                echo 'id="firstproduct"';
                                            } elseif ($i == 2) {
                                                echo 'id="secondproduct"';
                                            } ?>>
                        <div class="product-header">
                            <a href="./productPage.php?p=<?php echo $product['id']; ?>" target="_blank"><img src="./images/products/<?php echo $product['image']; ?>" alt="" /></a>
                            <div class="triangle"></div>
                            <span data-pid="<?php echo $product['id']; ?>" class="add-wishlist addToWishlist"><i class="<?php echo $fullheart == true ? 'fas' : 'far'; ?> fa-heart"></i></span>
                        </div>
                        <div class="product-footer">
                            <a href="./productPage.php?p=<?php echo $product['id']; ?>" target="_blank">
                                <h3><?php echo $product['title']; ?></h3>
                            </a>

                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="price"><?php echo toPersianNum(number_format($product['price'])); ?><span> تومان</span></h4>
                            <span data-pid="<?php echo $product['id']; ?>" class="addShopping" title="اضافه کردن به سبد خرید"><i class="fas fa-cart-plus"></i></span>
                        </div>
                    </div>

            <?php
                    $i += 1;
                }
            }
            ?>
        </div>
    </section>

    <!-- Product Banner -->
    <section class="banner">
        <div class="product-banner">
            <img src="images/barrett-ward-0lMpQaXfOCg-unsplash (2).jpg" alt="" />
            <div class="product-banner_content">
                <div class="product-banner_discount">
                    <h3>تخفیف تا ۲۵٪</h3>
                </div>
                <div class="product-banner_text">
                    <h2>صدا در جریان است</h2>
                    <h3>هندزفری بی‌سیم اپل</h3>
                    <button class="buy-btn">
                        <a href="./productPage.php?p=18">خرید<span>&#10095;</span></a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands -->
    <section class="brands">
        <div class="brands-container">
            <div class="brand">
                <img src="images/brands/24-241942_apple-ipad-logo-png-download-apple-logo-with2-removebg-preview.png" alt="" />
            </div>
            <div class="brand">
                <img src="images/brands/unnamed2-removebg-preview.png" alt="" />
            </div>
            <div class="brand">
                <img src="images/brands/kisspng-logo-brand-panasonic-chhota-bheem-hd-5b562230c12204.7153067515323715047911-removebg-preview.png" alt="" />
            </div>
            <div class="brand"><img src="images/brands/Philips-Logo.png" alt="" /></div>
            <div class="brand">
                <img src="images/brands/png-clipart-samsung-electronics-samsung-galaxy-samsung-logo-text-logo2-removebg-preview.png" alt="" />
            </div>
            <div class="brand">
                <img src="images/brands/Lenovo_logo_black.png" alt="" />
            </div>
        </div>
    </section>

    <!-- latest product -->
    <section class="latest products" id="latestProducts">
        <div class="products-top">
            <div class="products-title">
                <h1>جدیدترین محصولات</h1>
            </div>

            <div class="button-container">
                <div class="latest_button-right button-right">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="latest_button-left button-left">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </div>
        </div>

        <div class="latest-container products-container">
            <?php

            $sql = "SELECT * FROM products LIMIT 7";
            $products = $conn->query($sql);
            if ($products->rowCount() > 0) {


                foreach ($products as $product) {

                    if (isset($_SESSION['userId']) && is_int(array_search($product['id'], array_column($wishlist, 'product_id')))) {
                        $fullheart = true;
                    } else {
                        $fullheart = false;
                    }

            ?>
                    <div class="product">
                        <div class="product-header">
                            <a href="./productPage.php?p=<?php echo $product['id']; ?>" target="_blank"><img src="./images/products/<?php echo $product['image']; ?>" alt="" /></a>
                            <div class="triangle"></div>
                            <span data-pid="<?php echo $product['id']; ?>" class="add-wishlist addToWishlist"><i class="<?php echo $fullheart == true ? 'fas' : 'far'; ?> fa-heart"></i></span>
                        </div>
                        <div class="product-footer">
                            <a href="./productPage.php?p=<?php echo $product['id']; ?>" target="_blank">
                                <h3><?php echo $product['title']; ?></h3>
                            </a>

                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="price"><?php echo toPersianNum(number_format($product['price'])); ?><span> تومان</span></h4>
                            <span data-pid="<?php echo $product['id']; ?>" class="addShopping" title="اضافه کردن به سبد خرید"><i class="fas fa-cart-plus"></i></span>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
    </section>

    <section class="email-center">
        <div class="email-container">
            <form action="./include/subscribe.inc.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="email-content">
                    <h4>از جدیدترین تخفیف های سایت باخبر شوید</h4>
                </div>
                <div class="email-box">
                    <input type="email" class="email-request" name="email" placeholder="آدرس ایمیل خود را وارد کنید" />
                    <input type="submit" name="subscribe" class="email-submit" value="ارسال" />
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // Intro Slideshow
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides((slideIndex += n));
    }

    function currentSlide(n) {
        showSlides((slideIndex = n));
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("slides");
        var dots = document.getElementsByClassName("dot");

        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].classList.add("active");
    }

    //  calculating distance between to product cart
    const firstProduct = document.getElementById("firstproduct").getBoundingClientRect();
    const secondProduct = document.getElementById("secondproduct").getBoundingClientRect();

    const distance = Math.abs(firstProduct.left - secondProduct.right) + 5;

    const productWidth = document.querySelector(".product").offsetWidth;
    const scrollSize = distance + productWidth;

    //  Scroll to right or left element
    const buttonRight = document.getElementsByClassName("button-right");
    const buttonLeft = document.getElementsByClassName("button-left");
    const productsContainer = document.getElementsByClassName("products-container");

    for (let i = 0; i < buttonRight.length; i++) {
        buttonRight[i].addEventListener("click", function() {
            productsContainer[i].scrollLeft += scrollSize;
        });
    }

    for (let i = 0; i < buttonLeft.length; i++) {
        buttonLeft[i].addEventListener("click", function() {
            productsContainer[i].scrollLeft -= scrollSize;
        });
    }
</script>

<?php

include_once("./include/footer.php");

?>