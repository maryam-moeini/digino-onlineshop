<?php

$page_title = "محصولات";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

if (isset($_GET['action']) && isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = $conn->prepare("SELECT image,image2,image3,image4 FROM `products` WHERE id =:product_id");
    $sql->bindParam(":product_id", $id, PDO::PARAM_STR);
    $sql->execute();
    $p_img = $sql->fetch(PDO::FETCH_ASSOC);
    $img_path = "../images/products/" . $p_img['image'];
    $img2_path = "../images/products/" . $p_img['image2'];
    $img3_path = "../images/products/" . $p_img['image3'];
    $img4_path = "../images/products/" . $p_img['image4'];

    if (file_exists($img_path)) {
        unlink($img_path);
    }
    if (file_exists($img2_path)) {
        unlink($img2_path);
    }
    if (file_exists($img3_path)) {
        unlink($img3_path);
    }
    if (file_exists($img4_path)) {
        unlink($img4_path);
    }

    $delete = $conn->prepare("DELETE FROM `products` WHERE id =:product_id");
    $delete->execute(["product_id" => $id]);

    header("Location:products.php");
    exit();
}

$products = $conn->prepare("SELECT * FROM `products`");
$products->execute();

?>

<main class="main products-main">

    <!-- Products Tables -->
    <section class="table-container">

        <div class="table-card">
            <div class="card-header">
                <h3>محصولات</h3>
                <a class="card-header_btn" href="./new_product.php">ایجاد محصول</a>
            </div>

            <div class="card-body">
                <div class="table-wrapper">
                <table class="products-table">
                    <thead>
                        <tr>
                            <td>شماره</td>
                            <td>نام‌محصول</td>
                            <td>تصویر</td>
                            <td>دسته بندی</td>
                            <td>قیمت</td>
                            <td>توضیحات</td>
                            <td>رنگ</td>
                            <td>تنظيمات</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($products->rowCount() > 0) {
                            $i = 1;
                            foreach ($products as $product) {

                                $category_id = $product['category_id'];
                                $query = $conn->prepare("SELECT * FROM `categories` WHERE id = :category_id");
                                $query->bindParam(":category_id", $category_id, PDO::PARAM_STR);
                                $query->execute();
                                $category = $query->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <tr>
                                    <td><?php echo toPersianNum($i) ?></td>
                                    <td><?php echo $product['title']; ?></td>
                                    <td><img src="../images/products/<?php echo $product['image']; ?>" alt=""></td>
                                    <td><?php echo categoryConversion($category['title']); ?></td>
                                    <td><?php echo toPersianNum(number_format($product['price'])); ?></td>
                                    <td class="description"><?php echo $product['description']; ?></td>
                                    <td><?php echo str_replace('،', '، ', $product['color']); ?></td>
                                    <td>
                                        <a class="change-btn green" href="./edit_product.php?id=<?php echo $product['id']; ?>">ویرایش</a>
                                        <a class="change-btn red" href="./products.php?action=delete&id=<?php echo $product['id']; ?>">حذف</a>
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