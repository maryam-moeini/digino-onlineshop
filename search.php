<?php

require_once('dbconfig.php');
if (isset($_GET['q'])) {
    $keyword = htmlspecialchars($_GET['q']);
    $page_title = "جستجو برای $keyword | فروشگاه اینترنتی دیجینو";
    $current_page = "search";
    include("./include/header.php");
    include("./functions/functions.php");

    $sort = "پیش فرض";
    if (isset($_REQUEST['sort'])) {

        $sort = $_POST['sort'];
        if ($_POST['sort'] == "ارزان ترین") {
            $sql = "SELECT * FROM `products` WHERE title LIKE :keyword ORDER BY price ASC";
        } elseif ($_POST['sort'] == "گران ترین") {
            $sql = "SELECT * FROM `products` WHERE title LIKE :keyword ORDER BY price DESC";
        } elseif ($_POST['sort'] == "پرفروش ترین") {
            $sql = "SELECT * FROM `products` WHERE title LIKE :keyword ORDER BY sales_num DESC";
        } else {
            $sql = "SELECT * FROM products WHERE title LIKE :keyword";
        }
    } else {
        $sql = "SELECT * FROM products WHERE title LIKE :keyword";
    }
    
    $products = $conn->prepare($sql);
    $keyword_q = "%$keyword%";
    $products->bindParam(":keyword", $keyword_q, PDO::PARAM_STR);
    // $products->execute(['keyword' => "%$keyword%"]);
    $products->execute();
?>

    <main>
        <!-- horizontal line bottom of menu -->
        <hr class="nav-linebreak" />

        <!-- Products section -->
        <section class="listing-products">
            <?php
            if ($products->rowCount() > 0) {
            ?>
                <div class="search-result">
                    <h3>جستجو برای <span class="search-keyword">"<?php echo "$keyword"; ?>"</span> <?php echo toPersianNum($products->rowCount()); ?> نتیجه یافت شد.</h3>
                </div>

                <div class="listing-products_filters">

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
                    foreach ($products as $product) {
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
                    ?>

                </div>
            <?php
            } else { ?>
                <div class="search-result">
                    <h3>جستجو برای <span class="search-keyword">"<?php echo "$keyword"; ?>"</span> نتیجه ای یافت نشد.</h3>
                </div>
            <?php
            }
            ?>
        </section>
    </main>

<?php

    include("./include/footer.php");
}
?>