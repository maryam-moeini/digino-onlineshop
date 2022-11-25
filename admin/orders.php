<?php
require_once('dbconfig.php');
$page_title = "سفارشات";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

if (isset($_GET['orderId'])) {

    $order_id = $_GET['orderId'];
    $deleteorder = $conn->prepare("DELETE FROM `orders` WHERE id = :order_id");
    $deleteorder->bindParam(":order_id", $order_id, PDO::PARAM_STR);
    $deleteorder->execute();

    header('Location: orders.php');
    exit();
}


$orders = $conn->prepare("SELECT * FROM `orders`");
$orders->execute();
?>

<main class="main orders-main">

    <!-- Recent Tables -->
    <section class="table-container">

        <div class="table-card">
            <div class="card-header">
                <h3>حساب‌های كاربری جديد</h3>
            </div>
            <div class="card-body">
                <div class="table-wrapper orders-table">
                    <table>
                        <thead>
                            <tr>
                                <td>شماره</td>
                                <td>شماره سفارش</td>
                                <td>نام‌کاربری</td>
                                <td>محصولات</td>
                                <td>تاریخ</td>
                                <td>وضعیت</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($orders->rowCount() > 0) {
                                $i = 1;
                                foreach ($orders as $order) {
                                    $order_date = date("Y/m/d", strtotime($order['created_at']));
                                    $products_id = explode(',', $order['products_id']);

                                    $user_id = $order['user_id'];
                                    $username = $conn->prepare("SELECT `username` FROM `users` WHERE id = :user_id");
                                    $username->bindParam(":user_id", $user_id, PDO::PARAM_STR);
                                    $username->execute();
                                    $username = $username->fetch(PDO::FETCH_ASSOC);
                            ?>
                                    <tr>
                                        <td><?php echo toPersianNum($i) ?></td>
                                        <td><?php echo toPersianNum($order['id']); ?></td>
                                        <td><?php echo $username['username']; ?></td>
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
                                                    <li><?php echo toPersianNum($p_counter) . '. ' . $product_title['title']; ?></li>
                                                <?php
                                                    $p_counter++;
                                                }
                                                ?>
                                            </ol>
                                        </td>
                                        <td><?php echo toPersianNum($order_date); ?></td>
                                        <td>
                                            <div></div>
                                            <?php echo $order['status'] ?>
                                        </td>
                                    </tr>
                            <?php
                                    $i += 1;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

</main>

</div>

<script src="./js/script.js"></script>
</body>

</html>