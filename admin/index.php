<?php

$page_title = "داشبورد";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

if (isset($_GET['entity']) && isset($_GET['action']) && isset($_GET['id'])) {

    $entity = $_GET['entity'];
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'delete') {

        if ($entity == 'user') {
            $query = $conn->prepare("DELETE FROM `users` WHERE id =:id");
        } else {
            $query = $conn->prepare("DELETE FROM `comments` WHERE id =:id");
        }
        $query->execute(['id' => $id]);
    } else {
        $query = $conn->prepare("UPDATE `comments` SET `status`='1' WHERE id =:id");
        $query->execute(['id' => $id]);
    }
}

$comments = $conn->prepare("SELECT * FROM `comments` WHERE status = '0' ORDER BY id DESC LIMIT 3");
$comments->execute();

$users = $conn->prepare("SELECT * FROM `users` ORDER BY id DESC LIMIT 3");
$users->execute();

$orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC LIMIT 3");
$orders->execute();

$allUsers = $conn->prepare("SELECT * FROM `users`");
$allUsers->execute();

$allProducts = $conn->prepare("SELECT * FROM `products`");
$allProducts->execute();

$allOrders = $conn->prepare("SELECT * FROM `orders`");
$allOrders->execute();

$allComments = $conn->prepare("SELECT * FROM `comments`");
$allComments->execute();
?>

<main class="main">

    <section class="cards">
        <div class="card-single">
            <div>
                <h1><?php echo toPersianNum($allUsers->rowCount()) ?></h1>
                <span>حساب کاربری</span>
            </div>
            <div>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>

        <div class="card-single">
            <div>
                <h1><?php echo toPersianNum($allComments->rowCount()) ?></h1>
                <span>دیدگاه</span>
            </div>
            <div>
                <i class="fas fa-comments"></i>
            </div>
        </div>

        <div class="card-single">
            <div>
                <h1><?php echo toPersianNum($allProducts->rowCount()) ?></h1>
                <span>محصول</span>
            </div>
            <div>
                <i class="fas fa-shopping-basket"></i>
            </div>
        </div>

        <div class="card-single">
            <div>
                <h1><?php echo toPersianNum($allOrders->rowCount()) ?></h1>
                <span>سفارش</span>
            </div>
            <div>
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </section>

    <!-- Recent Tables -->
    <section class="recent-tables">

        <div class="table-card">
            <div class="card-header">
                <h3>سفارشات اخیر</h3>
                <a class="card-header_btn" href="orders.php">دیدن همه</a>
            </div>
            <div class="card-body">
                <div class="table-wrapper orders-table">
                    <table>
                        <thead>
                            <tr>
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
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="card-header">
                <h3>نظرات جديد</h3>
                <a class="card-header_btn" href="./comments.php">دیدن همه</a>
            </div>
            <div class="card-body">
                <div class="table-wrapper comments-table">
                    <table>
                        <thead>
                            <tr>
                                <td>نام</td>
                                <td>ديدگاه</td>
                                <td>تاريخ</td>
                                <td>تنظيمات</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($comments->rowCount() > 0) {
                                foreach ($comments as $comment) {
                            ?>
                                    <tr>
                                        <td><?php echo $comment['name']; ?></td>
                                        <td><?php echo $comment['comment']; ?></td>
                                        <td><?php echo toPersianNum($comment['date']); ?></td>
                                        <td>
                                            <a class="change-btn green" href="index.php?entity=comment&action=approve&id=<?php echo $comment['id']; ?>">تاييد</a>
                                            <a class="change-btn red" href="index.php?entity=comment&action=delete&id=<?php echo $comment['id']; ?>">حذف</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="table-card">
            <div class="card-header">
                <h3>حساب‌های كاربری جديد</h3>
                <a class="card-header_btn" href="./users.php">دیدن همه</a>
            </div>
            <div class="card-body">
                <div class="table-wrapper users-table">
                    <table>
                        <thead>
                            <tr>
                                <td>نام‌کاربری</td>
                                <td>ايميل</td>
                                <td>نام</td>
                                <td>شماره‌تماس</td>
                                <td>جنسیت</td>
                                <td>آدرس</td>
                                <td>تاريخ عضويت</td>
                                <td>تنظيمات</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($users->rowCount() > 0) {
                                foreach ($users as $user) {
                                    $join_date = date("Y/m/d", strtotime($user['created_at']));
                            ?>
                                    <tr>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['name'] ?? "---"; ?></td>
                                        <td><?php echo toPersianNum($user['phone'] ?? "---"); ?></td>
                                        <td><?php echo $user['gender'] ?? "---"; ?></td>
                                        <td><?php echo $user['address'] ?? "---"; ?></td>
                                        <td><?php echo toPersianNum($join_date); ?></td>
                                        <td>
                                            <a class="change-btn red" href="index.php?entity=user&action=delete&id=<?php echo $user['id']; ?>">حذف</a>
                                        </td>
                                    </tr>
                            <?php
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