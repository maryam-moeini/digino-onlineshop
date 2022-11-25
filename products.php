<?php

require_once('dbconfig.php');
$page_title = "محصولات -فروشگاه اینترنتی دیجینو";
$current_page = "products";
include("./include/header.php");
include("./functions/functions.php");
    
    
$category_title = $_GET['ctg'];
$sort = "پیش فرض";
if (isset($_REQUEST['sort'])) {

    $sort = $_POST['sort'];
    if ($_POST['sort'] == "ارزان ترین") {
        $sql = "SELECT * FROM `products` ORDER BY price ASC";
    } elseif ($_POST['sort'] == "گران ترین") {
        $sql = "SELECT * FROM `products` ORDER BY price DESC";
    } elseif ($_POST['sort'] == "پرفروش ترین") {
        $sql = "SELECT * FROM `products` ORDER BY sales_num DESC";
    } else {
        $sql = "SELECT * FROM products";
    }
} else {
    $sql = "SELECT * FROM products";
}

$products = $conn->query($sql);
?>

<main>
    <!-- horizontal line bottom of menu -->
    <hr class="nav-linebreak" />

    <!-- Products section -->
    <section class="listing-products">
        <div class="listing-products_top">
            <div class="listing-products_top-content">
                <h1>محصولات</h1>
                <h2>گجت ها و لوازم جانبی گوشی موبایل</h2>
                <h2>با اطمینان از ما خرید کنید</h2>
            </div>
        </div>

        <div class="listing-products_filters">

            <div class="products-category">
                <div class="category">
                    <span>دسته بندی</span>
                    <span><i class="fas fa-caret-down"></i></span>
                </div>
                <input class="category-toggle" type="checkbox" checked />
                <div class="category-content">
                    <a href="products.php?ctg=all" class="button-category <?php echo $category_title == 'all' ? "active" : ""; ?>">همه</a>
                    <a href="products.php?ctg=headphone" class="button-category <?php echo $category_title == 'headphone' ? "active" : ""; ?>">هدفون</a>
                    <a href="products.php?ctg=handsfree" class="button-category <?php echo $category_title == 'handsfree' ? "active" : ""; ?>">هندزفری</a>
                    <a href="products.php?ctg=smartWatch" class="button-category <?php echo $category_title == 'smartWatch' ? "active" : ""; ?>">ساعت هوشمند</a>
                    <a href="products.php?ctg=mobileCover" class="button-category <?php echo $category_title == 'mobileCover' ? "active" : ""; ?>">کاور گوشی موبایل</a>
                </div>
            </div>

            <div class="products-category">
                <div class="category">
                    <span>مرتب سازی</span>
                    <span><i class="fas fa-caret-down"></i></span>
                </div>
                <input class="category-toggle" type="checkbox" checked />
                <form class="category-content" method="POST">
                    <input class="button-category btn-sort <?php echo $sort == 'پیش فرض' ? "active" : ""; ?>" type="submit" name="sort" value="پیش فرض">
                    <input class="button-category btn-sort <?php echo $sort == 'ارزان ترین' ? "active" : ""; ?>" type="submit" name="sort" value="ارزان ترین">
                    <input class="button-category btn-sort <?php echo $sort == 'گران ترین' ? "active" : ""; ?>" type="submit" name="sort" value="گران ترین">
                    <input class="button-category btn-sort <?php echo $sort == 'جدید ترین' ? "active" : ""; ?>" type="submit" name="sort" value="جدید ترین">
                    <input class="button-category btn-sort <?php echo $sort == 'پرفروش ترین' ? "active" : ""; ?>" type="submit" name="sort" value="پرفروش ترین">
                </form>
            </div>

            <div class="toggle-view-container">
                <h3>نمایش:</h3>
                <div class="toggle-view">
                    <span class="view grid-view active"><i class="fas fa-th"></i></span>
                    <span class="view list-view"><i class="fas fa-list"></i></span>
                </div>
            </div>
        </div>

        <hr class="nav-linebreak" />


        <div class="products-view">

            <?php

            if ($products->rowCount() > 0) {

                $category_query = "SELECT * FROM categories WHERE id = :category_id";
                $result = $conn->prepare($category_query);
                $result->bindParam(":category_id", $category_id, PDO::PARAM_STR);

                foreach ($products as $product) {
                    $category_id = $product['category_id'];
                    $result->execute();
                    $category = $result->fetch(PDO::FETCH_ASSOC);

                    if ($category_title == $category['title'] || $category_title == "all") {

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
                                <div class="products-list_footer">
                                    <p><?php echo $product['description']; ?></p>
                                    <div class="products-list_btn">
                                        <span data-pid="<?php echo $product['id']; ?>" class="addShopping_listview">افزودن به سبد خرید</span>
                                        <a href="./productPage.php?p=<?php echo $product['id']; ?>" target="_blank">بیشتر ...</a>
                                    </div>
                                </div>
                            </div>
                        </div>

            <?php
                    }
                }
            }
            ?>

        </div>
    </section>
</main>

<?php

include("./include/footer.php");

?>