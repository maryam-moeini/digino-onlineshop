<?php
require_once("./include/loginCheck.php");
$page_title = "سبد خرید -فروشگاه اینترنتی دیجینو";

if (isset($_GET['action'])) {

    if (isset($_GET['cid'])) {

        $cart_id = $_GET['cid'];

        if ($_GET['action'] == 'delete') {
            $sql = $conn->prepare("DELETE FROM `cart` WHERE id = :cart_id");
        } elseif ($_GET['action'] == 'increase') {
            $sql = $conn->prepare("UPDATE `cart` SET qty = qty+1 WHERE id = :cart_id");
        } elseif ($_GET['action'] == 'decrease') {
            $sql = $conn->prepare("UPDATE `cart` SET qty = qty-1 WHERE id = :cart_id");
        }

        $sql->bindParam(":cart_id", $cart_id, PDO::PARAM_STR);
        $sql->execute();
        header("Location: cart.php");
        exit();
    }
}

include_once("./include/header.php");
$page_subject = 'سبد خرید من';

$cartProducts = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
$cartProducts->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$cartProducts->execute();

$total_price = 0;
$no_cart = false;

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
                <div class="cartproducts-container">
                    <?php
                    if ($cartProducts->rowCount() > 0) {

                        foreach ($cartProducts as $cartProduct) {

                            $product_id = $cartProduct['product_id'];
                            $sql = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
                            $sql->bindParam(":product_id", $product_id, PDO::PARAM_STR);
                            $sql->execute();
                            $product = $sql->fetch(PDO::FETCH_ASSOC);

                            $cartProductColor = trim($cartProduct['color']);
                            $sql = $conn->prepare("SELECT * FROM `color` WHERE color_name = :productColor");
                            $sql->bindParam(":productColor", $cartProductColor, PDO::PARAM_STR);
                            $sql->execute();
                            $product_color = $sql->fetch(PDO::FETCH_ASSOC);

                    ?>
                            <div class="cartproduct">
                                <div class="cartproduct-img">
                                    <img src="./images/products/<?php echo $product['image'] ?>" alt="">
                                </div>
                                <div class="cartproduct-info">
                                    <div class="cartproduct-title">
                                        <h3><?php echo $product['title'] ?></h3>
                                    </div>
                                    <div class="cartproduct-feature">
                                        <div class="cartproduct-color">
                                            <div class="cartproduct-color__hexcode" style="background-color: <?php echo $product_color['hexcode']; ?>"></div>
                                            <span><?php echo $cartProductColor ?></span>
                                        </div>
                                        <div>
                                            <i class="fas fa-award"></i>
                                            گارانتی اصالت و سلامت فیزیکی کالا
                                        </div>
                                    </div>
                                    <div class="cartproduct-edit">
                                        <div class="cartproduct-qty p-number">
                                            <a href="<?php echo $cartProduct['qty'] == 9 ? "#" : "cart.php?action=increase&cid=" . $cartProduct['id'] ?>" class="p-number_count"><i class="fas fa-plus"></i></a>
                                            <input type="number" name="number" min="1" max="9" step="1" value="<?php echo $cartProduct['qty']; ?>">
                                            <a href="<?php echo $cartProduct['qty'] == 1 ? "#" : "cart.php?action=decrease&cid=" . $cartProduct['id'] ?>" class="p-number_count"><i class="fas fa-minus"></i></a>
                                        </div>
                                        <div class="cartproduct-delete">
                                            <a href="cart.php?action=delete&cid=<?php echo $cartProduct['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                                حذف
                                            </a>
                                        </div>
                                        <div class="cartproduct-price">
                                            <h3><?php echo toPersianNum(number_format($product['price'])); ?></h3>
                                            <small>تومان</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $total_price = $cartProduct['qty'] * $product['price'] + $total_price;
                        }
                    } else {
                        $no_cart = true;
                        ?>
                        <div class="no-cart">
                            <p>هیچ محصولی در سبد خرید قرار ندارد.</p>
                        </div>
                    <?php } ?>
                </div>
                <?php if(!$no_cart){ ?>
                <div class="cartproducts-total">
                    <span>جمع سبد خرید</span>
                    <span><?php echo toPersianNum(number_format($total_price)) ?></span>
                    <small>تومان</small>
                </div>
                <?php }?>
                <div class="cartproducts-btns">
                    <a href="./index.php"><i class="fas fa-angle-right"></i>بازگشت به فروشگاه</a>
                    <?php if (!$no_cart) {
                    ?>
                        <a href="./checkout.php">ادامه فرایند خرید<i class="fas fa-angle-left"></i></a>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>

</main>


<?php
include_once("./include/footer.php");
?>