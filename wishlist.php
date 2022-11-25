<?php
require_once("./include/loginCheck.php");
$page_title = "علاقه‌مندی ها -فروشگاه اینترنتی دیجینو";

if (isset($_GET['action'])) {

    if (isset($_GET['wid'])) {

        $wishlist_id = $_GET['wid'];

        if ($_GET['action'] == 'delete') {
            $sql = $conn->prepare("DELETE FROM `wishlist` WHERE id = :wishlist_id");
            $sql->bindParam(":wishlist_id", $wishlist_id, PDO::PARAM_STR);
            $sql->execute();
            header("Location: ./wishlist.php");
            exit();
        }
    }
}

include_once("./include/header.php");
$page_subject = 'علاقه‌مندی ها';

$wishlistProducts = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = :user_id");
$wishlistProducts->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$wishlistProducts->execute();

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
                    if ($wishlistProducts->rowCount() > 0) {

                        foreach ($wishlistProducts as $wishlistProduct) {

                            $product_id = $wishlistProduct['product_id'];
                            $sql = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
                            $sql->bindParam(":product_id", $product_id, PDO::PARAM_STR);
                            $sql->execute();
                            $product = $sql->fetch(PDO::FETCH_ASSOC);

                    ?>
                            <div class="cartproduct wishlistproduct">
                                <div class="cartproduct-img">
                                    <img src="./images/products/<?php echo $product['image'] ?>" alt="">
                                </div>
                                <div class="cartproduct-info wishlistproduct-info">
                                    <div class="cartproduct-title">
                                        <h3><?php echo $product['title'] ?></h3>
                                    </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="cartproduct-color">
                                            <?php
                                            $colors = explode('،', $product['color']);
                                            foreach ($colors as $color) {

                                                $sql = $conn->prepare("SELECT * FROM `color` WHERE color_name = :productColor");
                                                $sql->bindParam(":productColor", $color, PDO::PARAM_STR);
                                                $sql->execute();
                                                $product_color = $sql->fetch(PDO::FETCH_ASSOC);

                                            ?>
                                                <span class="cartproduct-color__hexcode" style="background-color: <?php echo $product_color['hexcode']; ?>"></span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <div class="cartproduct-edit">
                                    <div class="wishlistproductPage">
                                            <a href="productPage.php?p=<?php echo $product['id']; ?>" target="_blank">
                                            <i class="fas fa-info-circle"></i>
                                                اطلاعات بیشتر
                                            </a>
                                        </div>
                                        <div class="cartproduct-delete">
                                            <a href="wishlist.php?action=delete&wid=<?php echo $wishlistProduct['id']; ?>">
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
                        }
                    } else {
                    ?>
                        <div class="no-wishlist">
                            <p>هیچ محصولی در لیست علاقه‌مندی قرار ندارد.</p>
                        </div>
                    <?php }?>
                </div>
            </div>
        </section>
    </div>

</main>


<?php
include_once("./include/footer.php");
?>