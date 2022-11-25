<?php

$page_title = "ایجاد محصول";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

$colors = $conn->prepare("SELECT * FROM `color`");
$colors->execute();

if (isset($_POST['add_product'])) {

    if (trim($_POST['title']) != "" && trim($_POST['price']) != "" && trim($_POST['category']) != "" && count($_POST['color']) != 0 && trim($_POST['description']) != "" && trim($_FILES['image']['name']) != "") {

        $title = $_POST['title'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $color = implode('،', $_POST['color']);
        $description = $_POST['description'];

        $name_image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../images/products/$name_image");

        if (trim($_FILES['image2']['name']) == "") {
            $name_image2 = null;
        } else {
            $name_image2 = $_FILES['image2']['name'];
            $tmp_name2 = $_FILES['image2']['tmp_name'];
            move_uploaded_file($tmp_name2, "../images/products/$name_image2");
        }

        if (trim($_FILES['image3']['name']) == "") {
            $name_image3 = null;
        } else {
            $name_image3 = $_FILES['image3']['name'];
            $tmp_name3 = $_FILES['image3']['tmp_name'];
            move_uploaded_file($tmp_name3, "../images/products/$name_image3");
        }

        if (trim($_FILES['image4']['name']) == "") {
            $name_image4 = null;
        } else {
            $name_image4 = $_FILES['image4']['name'];
            $tmp_name4 = $_FILES['image4']['tmp_name'];
            move_uploaded_file($tmp_name4, "../images/products/$name_image4");
        }

        $query = $conn->prepare("SELECT * FROM `categories` WHERE title = :category");
        $query->bindParam(":category", $category, PDO::PARAM_STR);
        $query->execute();
        $find_category = $query->fetch(PDO::FETCH_ASSOC);
        $category_id = $find_category['id'];

        $product_insert = $conn->prepare("INSERT INTO `products`(`category_id`, `title`, `price`, `description`, `color`, `image`, `image2`, `image3`, `image4`) VALUES (:category_id, :title, :price, :description, :color, :image, :image2, :image3, :image4)");
        $product_insert->execute(['title' => $title, 'category_id' => $category_id, 'price' => $price, 'description' => $description, 'color' => $color, 'image' => $name_image, 'image2' => $name_image2, 'image3' => $name_image3, 'image4' => $name_image4]);

        header("Location: products.php");
        exit();
    }
}

?>

<main class="main">

    <!-- new product -->
    <section class="new-product">
        <div class="form-container">
            <div id="add_product_error" class="checkImage">
            <i class="fas fa-exclamation-triangle"></i>
            <span></span>
            </div>
            <form name="form_product" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateFormProduct())">
                <!-- action="products.php" -->
                <div class="form-group">
                    <label for="title">نام محصول: </label>
                    <input type="text" name="title" id="title">
                </div>

                <div class="form-group">
                    <label for="price">قیمت: </label>
                    <div>
                        <input type="text" name="price" id="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        <small><span style="color: red;">*</span>قیمت را به انگلیسی و تومان وارد کنید.</small>
                    </div>
                </div>

                <div class="form-group category-group">
                    <h4>دسته‌بندی: </h4>
                    <div>
                        <input type="radio" name="category" id="headphone" value="headphone">
                        <label for="headphone">هدفون</label>
                        <input type="radio" name="category" id="handsfree" value="handsfree">
                        <label for="handsfree">هندزفری</label>
                        <input type="radio" name="category" id="mobileCover" value="mobileCover">
                        <label for="mobileCover">کاور موبایل</label>
                        <input type="radio" name="category" id="smartWatch" value="smartWatch">
                        <label for="smartWatch">ساعت هوشمند</label>
                    </div>
                </div>

                <div class="form-group">
                    <h4>رنگ: </h4>
                    <div>
                        <?php
                        if ($colors->rowCount() > 0) {

                            foreach ($colors as $color) {
                        ?>
                                <input type="checkbox" name="color[]" id="<?php echo $color['color_name']; ?>" value="<?php echo $color['color_name']; ?>">
                                <label style="background: <?php echo $color['hexcode']; ?>;" for="<?php echo $color['color_name']; ?>" title="<?php echo $color['color_name']; ?>"></label>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">توضیحات: </label>
                    <textarea name="description" id="description" rows="8"></textarea>
                </div>

                <div class="form-group">
                    <h4>تصویر: </h4>
                    <div>
                        <!-- <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="file" class="svg-inline--fa fa-file fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"></path></svg> -->
                        <input type="file" name="image" id="image">
                        <label for="image"><i class="far fa-file"></i><span>عکس اصلی</span><i class="fas fa-cloud-upload-alt"></i></label>
                        <div class="imgShow"><img src="" alt=""></div>
                        <input type="file" name="image2" id="image2">
                        <label for="image2"><i class="far fa-file"></i><span>عکس دوم</span><i class="fas fa-cloud-upload-alt"></i></label>
                        <div class="imgShow"><img src="" alt=""></div>
                        <input type="file" name="image3" id="image3">
                        <label for="image3"><i class="far fa-file"></i><span>عکس سوم</span><i class="fas fa-cloud-upload-alt"></i></label>
                        <div class="imgShow"><img src="" alt=""></div>
                        <input type="file" name="image4" id="image4">
                        <label for="image4"><i class="far fa-file"></i><span>عکس چهارم</span><i class="fas fa-cloud-upload-alt"></i></label>
                        <div class="imgShow"><img src="" alt=""></div>

                    </div>
                </div>

                <div class="submit-container">
                    <input type="submit" name="add_product" value="ایجاد">
                </div>

            </form>

        </div>

    </section>

</main>
</div>

<script src="./js/script.js"></script>
</body>

</html>