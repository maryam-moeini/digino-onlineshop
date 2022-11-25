<?php
require_once("./include/loginCheck.php");
$page_title = "نتیجه پرداخت -فروشگاه اینترنتی دیجینو";

if (isset($_POST['pay'])) {

    $cartProducts = $conn->prepare("SELECT `product_id` FROM `cart` WHERE user_id = :user_id");
    $cartProducts->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $cartProducts->execute();

    if ($cartProducts->rowCount() > 0) {
        
        $cartProducts = $cartProducts->fetchAll(PDO::FETCH_COLUMN);
        
        foreach($cartProducts as $cartProduct){
            $addSales = $conn->prepare("UPDATE `products` SET `sales_num`= sales_num + 1 WHERE id = :product_id");
            $addSales->bindParam(":product_id", $cartProduct, PDO::PARAM_STR);
            $addSales->execute();
        }

        $products = implode(',', $cartProducts);

        $total_price = $_POST['onlinepayment'];
        $order = $conn->prepare("INSERT INTO `orders`( `user_id`, `products_id`, `status`) VALUES (:user_id, :products, 'انجام شده')");
        $order->execute(['user_id' => $user_id, 'products' => $products]);
        $last_id = $conn->lastInsertId();
        $order = $order->fetch(PDO::FETCH_ASSOC);

        $cartDelete = $conn->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
        $cartDelete->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $cartDelete->execute();

        $_SESSION['payment'] = 'successful';
    }
}

include_once("./include/header.php");
$page_subject = 'نتیجه پرداخت';



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
            <?php

            ?>
            <div class="profile-title">
                <h1><?php echo $page_subject; ?></h1>
            </div>
            <?php
            if (isset($_SESSION['payment'])) {
            ?>
                <div class="profile-content">
                    <div class="pay-success">
                        <i class="fas fa-check-circle"></i>
                        <span>عملیات پرداخت با موفقیت انجام شد.</span>
                    </div>
                    <div class="payment-report">
                        <table>
                            <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مبلغ</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo toPersianNum($last_id) ?></td>
                                    <td><?php echo toPersianNum(number_format($total_price)) ?><small>تومان</small></td>
                                    <td>پرداخت موفق</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
                unset($_SESSION['payment']);
            }
            ?>
        </section>
    </div>

</main>

<?php
include_once("./include/footer.php");
?>