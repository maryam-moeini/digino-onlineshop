<?php
require_once('dbconfig.php');
include("./functions/functions.php");
$current_page = "singleProducts";
session_start();
// error_reporting(E_ALL ^ E_WARNING); /* removing warning */

if (isset($_GET['p'])) {
    $product_id = intval($_GET['p']);
    $result = $conn->prepare("SELECT * FROM products WHERE id = :productId");
    $result->bindParam(":productId", $product_id, PDO::PARAM_STR);
    $result->execute();
    $product = $result->fetch(PDO::FETCH_ASSOC);
    $page_title = $product['title'];
    $colors = explode('،', $product['color']);
    $firstcolor = $colors[0];
}


$category_id = $product['category_id'];
$category_query = $conn->prepare("SELECT * FROM categories WHERE id = :category_id");
$category_query->bindParam(":category_id", $category_id, PDO::PARAM_STR);
$category_query->execute();
$category = $category_query->fetch(PDO::FETCH_ASSOC);
$category_title = $category['title'];

if (isset($_POST['post_comment'])) {

    if (trim($_POST['name']) != "" & trim($_POST['comment']) != "") {

        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d");
        $comment_insert = $conn->prepare("INSERT INTO `comments`(`product_id`, `name`, `comment`, `date`, `status`) VALUES (:product_id, :review_name, :comment, :current_date, '0')");
        $comment_insert->execute(['product_id' => $product_id, 'review_name' => $name, 'comment' => $comment, 'current_date' => $date]);
        header("Location:productPage.php?p=$product_id");
        exit();
    } else {
        echo "<script>alert('فیلدها نباید خالی باشند!');</script>";
    }
}

$comments = $conn->prepare("SELECT * FROM `comments` WHERE `product_id`= :product_id and status = '1'");
$comments->bindParam(":product_id", $product_id, PDO::PARAM_STR);
$comments->execute();
$comments_num = $comments->rowCount();


if (isset($_POST["addToShoppingBag"])) {

    if (isset($_SESSION["userId"])) {

        $user_id = $_SESSION['userId'];

        $product_color = $_POST['color'];
        $product_qty = $_POST['number'];
        $sameProduct = $conn->prepare("SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id AND color = :color");
        $sameProduct->execute(['product_id' => $product_id, 'user_id' => $user_id, 'color' => $product_color]);

        if ($sameProduct->rowCount() == 1) {
            $sameProduct = $sameProduct->fetch(PDO::FETCH_ASSOC);
            $sameProductQty = $sameProduct['qty'];
            $qty = $sameProductQty + $product_qty;
            $sql = $conn->prepare("UPDATE `cart` SET `qty`= :qty WHERE product_id = :product_id AND user_id = :user_id AND color = :color");
        } else if ($sameProduct->rowCount() == 0) {
            $qty = $product_qty;
            $sql = $conn->prepare("INSERT INTO `cart` (`product_id`, `user_id`, `qty`, `color`) VALUES (:product_id, :user_id, :qty, :color)");
        }

        $sql->execute(['product_id' => $product_id, 'user_id' => $user_id, 'qty' => $qty, 'color' => $product_color]);
        header("Location: cart.php");
        exit();
    } else {
        echo '<script>if (window.confirm("برای افزودن کالا به سبد خرید باید وارد حساب کاربری شوید.\nآیا می‌خواهید وارد حساب کاربریتان شوید؟")) {
            window.open("./login.php", "_blank");
        };
    </script>';
    }
}

include_once("./include/header.php");

if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];
    $IsInWishlist = $conn->prepare("SELECT product_id FROM `wishlist` WHERE user_id = :user_id AND product_id = :product_id;");
    $IsInWishlist->execute(['user_id' => $user_id, 'product_id' => $product_id]);

    if ($IsInWishlist->rowCount() == 1) {
        $fullheart = true;
    }
}


?>

<main>
    <!-- line break -->
    <hr class="nav-linebreak" />

    <?php
    if ($product) {
    ?>

        <!-- breadcrumb -->
        <section class="breadcrumb-container">
            <ul class="breadcrumb">
                <li>
                    <a class="breadcrumb-item" href="index.php">صفحه اصلی</a>
                    <span>&nbsp&#47&nbsp&nbsp</span> <!-- space slash space space -->
                </li>
                <li>
                    <a class="breadcrumb-item" href="products.php?ctg=all">محصولات</a>
                    <span>&nbsp&#47&nbsp&nbsp</span>
                </li>
                <li>
                    <a class="breadcrumb-item" href="products.php?ctg=<?php echo $category_title ?>"><?php echo categoryConversion($category_title) ?></a>
                    <span>&nbsp&#47&nbsp&nbsp</span>
                </li>
                <li>
                    <h4 class="breadcrumb-item"><?php echo $product['title'] ?></h4>
                </li>
            </ul>
        </section>

        <section class="product-container">

            <div class="product-images">
                <div class="product-images_container">
                    <!-- main product image -->
                    <div class="product-img_up">
                        <div class="product-mainimg">
                            <div class="zoom active" style="background-image: url(images/products/<?php echo $product['image']; ?>);"></div>
                            <img class="main-img active" src="images/products/<?php echo $product['image']; ?>" alt="">

                            <div class="zoom" style="background-image: url(images/products/<?php echo $product['image2']; ?>);"></div>
                            <img class="main-img" src="images/products/<?php echo $product['image2']; ?>" alt="">

                            <div class="zoom" style="background-image: url(images/products/<?php echo $product['image3']; ?>);"></div>
                            <img class="main-img" src="images/products/<?php echo $product['image3']; ?>" alt="">

                            <div class="zoom" style="background-image: url(images/products/<?php echo $product['image4']; ?>);"></div>
                            <img class="main-img" src="images/products/<?php echo $product['image4']; ?>" alt="">
                        </div>
                    </div>

                    <!-- other product images -->
                    <div class="product-imgs_down">
                        <div onclick="currentImage(0)"><img src="images/products/<?php echo $product['image']; ?>" alt=""></div>
                        <?php if ($product['image2'] !== null) { ?><div onclick="currentImage(1)"><img src="images/products/<?php echo $product['image2']; ?>" alt=""></div><?php } ?>
                        <?php if ($product['image3'] !== null) { ?><div onclick="currentImage(2)"><img src="images/products/<?php echo $product['image3']; ?>" alt=""></div><?php } ?>
                        <?php if ($product['image4'] !== null) { ?><div onclick="currentImage(3)"><img src="images/products/<?php echo $product['image4']; ?>" alt=""></div><?php } ?>
                    </div>

                </div>
            </div>

            <div class="product-specifications">
                <form name="singleProduct" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="p-title"><?php echo $product['title']; ?></div>
                    <div class="p-price"><?php echo toPersianNum(number_format($product['price'])); ?><span> تومان</span></div>
                    <div class="p-rate">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="p-review-num"><a onclick="goToReview()"><span><?php echo toPersianNum($comments_num); ?></span>&nbsp<span>دیدگاه کاربران</span></a></div>
                        <div class="p-review-new"><a onclick="goToAddReview()">افزودن دیدگاه</a></div>
                    </div>
                    <div class="p-features">
                        <h3>ویژگی های کالا</h3>
                        <ul>
                            <li><i class="fas fa-circle"></i>قابلیت نصب سیم کارت: ندارد</li>
                            <li><i class="fas fa-circle"></i>صفحه نمایش لمسی: دارد</li>
                            <li><i class="fas fa-circle"></i>GPS: دارد</li>
                            <li><i class="fas fa-circle"></i>نوع کاربری: ورزشی، رسمی، روزمره</li>
                            <li><i class="fas fa-circle"></i>فرم صفحه: مستطیل</li>
                        </ul>
                    </div>
                    <div class="p-colors">
                        <div class="color-name">
                            <h3>رنگ: <span class="selected-color"><?php echo count($colors) == 1 ? $product['color'] : ""; ?></span></h3>
                        </div>
                        <div class="pickcolor">
                            <?php
                            if (sizeof($colors) > 1) {

                                foreach ($colors as $color) {

                                    $sql = $conn->prepare("SELECT * FROM color WHERE color_name = :color");
                                    $sql->bindParam(":color", $color, PDO::PARAM_STR);
                                    $sql->execute();
                                    $p_color = $sql->fetch(PDO::FETCH_ASSOC);
                            ?>
                                    <input type="radio" name="color" id="<?php echo $p_color['color_name']; ?>" value="<?php echo $p_color['color_name']; ?>" />
                                    <label for="<?php echo $p_color['color_name']; ?>">
                                        <span class="p-color" style="background-color: <?php echo $p_color['hexcode']; ?>"></span>
                                    </label>
                                <?php
                                }
                            } elseif (count($colors) == 1) {

                                $sql = $conn->prepare("SELECT * FROM color WHERE color_name = :color");
                                $sql->bindParam(":color", $colors[0], PDO::PARAM_STR);
                                $sql->execute();
                                $p_color = $sql->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <input type="radio" name="color" id="<?php echo $p_color['color_name']; ?>" value="<?php echo $p_color['color_name']; ?>" checked />
                                <label for="<?php echo $p_color['color_name']; ?>">
                                    <span class="p-color" style="background-color: <?php echo $p_color['hexcode']; ?>"></span>
                                </label>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="p-order">
                        <div class="p-number">
                            <div class="p-number_count" onClick="increaseCount(event, this)"><i class="fas fa-plus"></i></div>
                            <input type="number" name="number" min="1" max="9" step="1" value="1">
                            <div class="p-number_count" onClick="decreaseCount(event, this)"><i class="fas fa-minus"></i></div>
                        </div>
                        <div class="p-buttons">
                            <div class="p-buy">
                                <label for=""><i class="fas fa-shopping-cart"></i></label>
                                <input type="submit" name="addToShoppingBag" value="افزودن به سبد خرید">
                            </div>
                            <div class="p-wishlist">
                                <span data-pid="<?php echo $product['id']; ?>" class="wishlist addToWishlist"><i class="<?php echo $fullheart == true ? 'fas' : 'far'; ?> fa-heart"></i><span>افزودن به علاقه‌مندی ها</span></span>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>

        <section class="product-information">
            <div class="tabs-container">
                <input type="radio" class="p-tabs" name="p-tabs" id="tab-1" checked>
                <label for="tab-1" class="p-tabs-label">توضیحات</label>
                <div class="p-panel">
                    <p><?php echo $product['description']; ?></p>
                </div>
                <input type="radio" class="p-tabs" name="p-tabs" id="tab-2">
                <label for="tab-2" class="p-tabs-label">دیدگاه کاربران <span>(<?php echo toPersianNum($comments_num); ?>)</span></label>
                <div class="p-panel">
                    <div id="reviews" class="reviews">
                        <?php
                        if ($comments->rowCount() > 0) {

                            foreach ($comments as $review) {
                        ?>
                                <div class="review-container">
                                    <div class="review-up">
                                        <div class="review-upright">
                                            <span class="review-name"><?php echo $review['name']; ?></span>
                                            <span class="review-date"><?php echo toPersianNum($review['date']); ?></span>
                                        </div>
                                        <div class="review-rate">
                                            <span class="review-like" onclick="clickThump(this)"><i class="far fa-thumbs-up"></i></span>
                                            <span class="review-like-num">0</span>
                                            <span class="review-dislike" onclick="clickThump(this)"><i class="far fa-thumbs-down"></i></span>
                                            <span class="review-dislike-num">0</span>
                                        </div>
                                    </div>
                                    <div class="review-down">
                                        <div class="review-text"><?php echo $review['comment']; ?></div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="no-review">
                                <p>هیج نظری ارسال نشده است. شما می‌توانید نظر خود را در کادر پایین ارسال کنید.</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="add-review" class="add-review-container">
                        <div class="add-review_label">
                            <h2>نظر خود را بنویسید</h2>
                        </div>
                        <form class="add-review" method="POST" autocomplete="off">
                            <div class="add-review_name">
                                <label for="name">نام</label>
                                <input type="text" name="name">
                            </div>
                            <div class="add-review_comment">
                                <label for="comment">دیدگاه</label>
                                <textarea id="comment" name="comment" rows="8"></textarea>
                            </div>
                            <div class="add-review_submit">
                                <input type="submit" name="post_comment" value="ارسال">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="related-products">
            <div class="related-products_header">
                <h2>محصولات مرتبط</h2>
            </div>
            <div class="related-products_container">
                <?php
                $query = "SELECT * FROM `products` WHERE id != :id AND category_id = :category_id LIMIT 4";
                $products = $conn->prepare($query);
                $products->bindParam(":id", $product_id, PDO::PARAM_STR);
                $products->bindParam(":category_id", $category_id, PDO::PARAM_STR);
                $products->execute();

                if ($products->rowCount() > 0) {

                    foreach ($products as $related_product) {

                        if (isset($_SESSION['userId']) && is_int(array_search($related_product['id'], array_column($wishlist, 'product_id')))) {
                            $fullheart = true;
                        } else {
                            $fullheart = false;
                        }

                ?>
                        <div class="product">
                            <div class="product-header">
                                <a href="./productPage.php?p=<?php echo $related_product['id']; ?>" target="_blank"><img src="./images/products/<?php echo $related_product['image']; ?>" alt="" /></a>
                                <div class="triangle"></div>
                                <span data-pid="<?php echo $related_product['id']; ?>" class="add-wishlist addToWishlist"><i class="<?php echo $fullheart == true ? 'fas' : 'far'; ?> fa-heart"></i></span>
                            </div>
                            <div class="product-footer">
                                <a href="./productPage.php?p=<?php echo $related_product['id']; ?>" target="_blank">
                                    <h3><?php echo $related_product['title']; ?></h3>
                                </a>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4 class="price"><?php echo toPersianNum(number_format($related_product['price'])); ?><span> تومان</span></h4>
                                <span data-pid="<?php echo $related_product['id']; ?>" class="addShopping" title="اضافه کردن به سبد خرید"><i class="fas fa-cart-plus"></i></span>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </section>

    <?php
    } else {
    ?>
        <div class="alert-product">
            <p>کالا مورد نظر یافت نشد!</p>
        </div>
    <?php
    }
    ?>
</main>

<?php

include("./include/footer.php");

?>