<?php
require_once("./include/loginCheck.php");
$page_title = "نهایی کردن سفارش -فروشگاه اینترنتی دیجینو";

include_once("./include/header.php");
$page_subject = 'نهایی کردن سفارش';

$cartProducts = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
$cartProducts->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$cartProducts->execute();

$total_price = 0;
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
            <div class="profile-content">
                <div class="checkout-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span></span>
                </div>
                <form class="checkout-container" name="checkout" action="./successful_payment.php" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateCheckoutForm())">
                    <div class="checkout-info checkout-card">
                        <div class="checkout-header">
                            <h3>اطلاعات</h3>
                        </div>
                        <div class="checkout-content">
                            <div class="form-control">
                                <label for="name">نام و نام‌خانوادگی: </label>
                                <input type="text" name="name" id="name" value="<?php echo $userInfo['name'] != null ? htmlentities($userInfo['name']) : "" ?>">
                            </div>
                            <div class="form-control">
                                <label for="phone">شماره تماس:</label>
                                <input type="text" name="phone" id="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" maxlength="11" value="<?php echo $userInfo['phone'] != null ? htmlentities($userInfo['phone']) : "" ?>">
                            </div>
                            <div class="form-control">
                                <label for="address">آدرس: </label>
                                <textarea name="address" id="address" rows="5"><?php echo $userInfo['address'] != null ? htmlentities($userInfo['address']) : "" ?></textarea>
                            </div>
                            <div class="form-control">
                                <label for="postal">کد پستی: </label>
                                <input type="text" name="postal" id="postal" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="checkout-orders checkout-card">
                        <div class="checkout-header">
                            <h3>خلاصه سفارش</h3>
                        </div>
                        <div class="checkout-content">
                            <?php
                            foreach ($cartProducts as $cartProduct) {

                                $product_id = $cartProduct['product_id'];
                                $sql = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
                                $sql->bindParam(":product_id", $product_id, PDO::PARAM_STR);
                                $sql->execute();
                                $product = $sql->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <div>
                                    <span><?php echo $product['title']; ?></span>
                                    <div class="checkout-price-container">
                                        <span class="checkout-price"><?php echo toPersianNum(number_format($product['price'])); ?></span>
                                        <small>تومان</small>
                                    </div>
                                </div>
                            <?php
                                $total_price = $cartProduct['qty'] * $product['price'] + $total_price;
                            }
                            ?>
                            <div class="checkout-number">
                                <span>تعداد محصول</span>
                                <span><?php echo toPersianNum($cartProducts->rowCount()); ?></span>
                            </div>
                            <div class="checkout-total">
                                <strong>جمع قیمت</strong>
                                <div class="checkout-price-container">
                                    <strong class="checkout-price"><?php echo toPersianNum(number_format($total_price)) ?></strong>
                                    <small>تومان</small>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="checkout-pay checkout-card">
                        <div class="checkout-header">
                            <h3>نحوه پرداخت</h3>
                        </div>
                        <div class="checkout-content">
                            <div class="checkout-payment">
                                <input type="checkbox" name="onlinepayment" id="onlinepayment" value="<?php echo $total_price;?>">
                                <label for="onlinepayment">پرداخت آنلاین</label>
                            </div>
                            <div class="checkout-btn">
                                <button type="submit" name="pay">پرداخت</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>

</main>

<?php
include_once("./include/footer.php");
?>