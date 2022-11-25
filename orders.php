<?php
require_once("./include/loginCheck.php");
$page_title = "سفارش‌های من -فروشگاه اینترنتی دیجینو";

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
$page_subject = 'سفارش‌های من';

$orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = :user_id");
$orders->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$orders->execute();

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
                <?php if ($orders->rowCount() > 0) {
                ?>
                    <div class="orders-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>محصولات</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orders as $order) {
                                    $order_date = date("Y/m/d", strtotime($order['created_at']));
                                    $products_id = explode(',', $order['products_id']);
                                ?>
                                    <tr>
                                        <td><?php echo toPersianNum($order['id']) ?></td>
                                        <td>
                                            <ol>
                                                <?php
                                                $p_counter = 1;
                                                foreach ($products_id as $product_id) {
                                                    $product_title = $conn->prepare("SELECT `title` FROM `products` WHERE id = :product_id");
                                                    $product_title->bindParam(":product_id", $product_id, PDO::PARAM_STR);
                                                    $product_title->execute();
                                                    $product_title = $product_title->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <li><?php echo toPersianNum($p_counter).'. '.$product_title['title'];?></li>
                                                <?php
                                                $p_counter++;
                                                }
                                                ?>
                                            </ol>
                                        </td>
                                        <td><?php echo toPersianNum($order_date) ?></td>
                                        <td><div></div><?php echo $order['status'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                ?>
                    <div class="no-order">
                        <p>هنوز هیچ سفارشی برای شما ثبت نشده است.</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </div>

</main>


<?php
include_once("./include/footer.php");
?>