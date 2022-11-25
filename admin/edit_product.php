<?php

$page_title = "ویرایش محصول";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

$colors = $conn->prepare("SELECT * FROM `color`");
$colors->execute();

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];
    $product = $conn->prepare("SELECT * FROM `products` WHERE id =:product_id");
    $product->execute(["product_id" => $product_id]);
    $product = $product->fetch();

    $category_id = $product['category_id'];
    $selected_category = $conn->prepare("SELECT title FROM `categories` WHERE id =:category_id");
    $selected_category->execute(["category_id" => $category_id]);
    $selected_category = $selected_category->fetch();

    $color_arr = explode('،', $product['color']);
}

if (isset($_POST['edit_product'])) {

    if (trim($_POST['title']) != "" && trim($_POST['price']) != "" && trim($_POST['category']) != "" && count($_POST['color']) != 0 && trim($_POST['description']) != "") {

        $title = $_POST['title'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $color = implode('،', $_POST['color']);
        $description = $_POST['description'];

        if (trim($_FILES['image']['name']) != "") {
            $name_image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp_name, "../images/products/$name_image");
        } else {
            $name_image = $product['image'];
        }


        if (trim($_FILES['image2']['name']) != "") {
            $name_image2 = $_FILES['image2']['name'];
            $tmp_name2 = $_FILES['image2']['tmp_name'];
            move_uploaded_file($tmp_name2, "../images/products/$name_image2");
        } else {
            $name_image2 = $product['image2'];
        }

        if (trim($_FILES['image3']['name']) != "") {
            $name_image3 = $_FILES['image3']['name'];
            $tmp_name3 = $_FILES['image3']['tmp_name'];
            move_uploaded_file($tmp_name3, "../images/products/$name_image3");
        } else {
            $name_image3 = $product['image3'];
        }

        if (trim($_FILES['image4']['name']) != "") {
            $name_image4 = $_FILES['image4']['name'];
            $tmp_name4 = $_FILES['image4']['tmp_name'];
            move_uploaded_file($tmp_name4, "../images/products/$name_image4");
        } else {
            $name_image4 = $product['image4'];
        }

        $query = $conn->prepare("SELECT * FROM `categories` WHERE title = :category");
        $query->bindParam(":category", $category, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $p_category = $result['id'];

        $product_insert = $conn->prepare("UPDATE `products` SET `category_id`= :category_id, `title`= :title, `price`= :price, `description`= :description, `color`= :color, `image`= :image, `image2`= :image2, `image3`= :image3, `image4` = :image4 WHERE id = :product_id");
        $product_insert->execute(['product_id' => $product_id, 'title' => $title, 'category_id' => $p_category, 'price' => $price, 'description' => $description, 'color' => $color, 'image' => $name_image, 'image2' => $name_image2, 'image3' => $name_image3, 'image4' => $name_image4]);

        header("Location:products.php");
        exit();
    }
}

?>

<main class="main">

    <!-- new product -->
    <section class="new-product">
        <div class="form-container">
            <div id="add_product_error">
                <i class="fas fa-exclamation-triangle"></i>
                <span></span>
            </div>
            <form name="form_product" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return(validateFormProduct())">
                <!-- action="products.php" -->
                <div class="form-group">
                    <label for="title">نام محصول: </label>
                    <input type="text" name="title" id="title" value="<?php echo $product['title'] ?>">
                </div>

                <div class="form-group">
                    <label for="price">قیمت: </label>
                    <div>
                        <input type="text" name="price" id="price" value="<?php echo $product['price'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        <small><span style="color: red;">*</span>قیمت را به انگلیسی و تومان وارد کنید.</small>
                    </div>
                </div>

                <div class="form-group category-group">
                    <h4>دسته‌بندی: </h4>
                    <div>
                        <input type="radio" name="category" id="headphone" value="headphone" <?php echo $selected_category['title'] == "headphone" ? "checked" : ""; ?>>
                        <label for="headphone">هدفون</label>
                        <input type="radio" name="category" id="handsfree" value="handsfree" <?php echo $selected_category['title'] == "handsfree" ? "checked" : ""; ?>>
                        <label for="handsfree">هندزفری</label>
                        <input type="radio" name="category" id="mobileCover" value="mobileCover" <?php echo $selected_category['title'] == "mobileCover" ? "checked" : ""; ?>>
                        <label for="mobileCover">کاور موبایل</label>
                        <input type="radio" name="category" id="smartWatch" value="smartWatch" <?php echo $selected_category['title'] == "smartWatch" ? "checked" : ""; ?>>
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
                                <input type="checkbox" name="color[]" id="<?php echo $color['color_name']; ?>" value="<?php echo $color['color_name']; ?>" <?php echo in_array($color['color_name'], $color_arr) ? "checked" : ""; ?>>
                                <label style="background: <?php echo $color['hexcode']; ?>;" for="<?php echo $color['color_name']; ?>" title="<?php echo $color['color_name']; ?>"></label>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">توضیحات: </label>
                    <textarea name="description" id="description" rows="8"><?php echo $product['description'] ?></textarea>
                </div>

                <div class="selected-imgs-container" dir="ltr">

                <div>
                        <div class="selected-img" <?php echo $product['image'] ? 'style="background: #ffffff; border: 2px solid rgba(0,0,0,0.3);"' : ''; ?>>
                            <?php if ($product['image']) { ?>
                                <img src="../images/products/<?php echo $product['image'] ?>" alt="">
                            <?php } ?>
                        </div>
                        <h5 <?php echo $product['image'] ? '': 'style="display: none;"'?> >عکس اصلی</h5>
                    </div>

                    <div>
                        <div class="selected-img" <?php echo $product['image2'] ? 'style="background: #ffffff; border: 2px solid rgba(0,0,0,0.3);"' : ''; ?>>
                            <?php if ($product['image2']) { ?>
                                <img src="../images/products/<?php echo $product['image2'] ?>" alt="">
                            <?php } ?>
                        </div>
                        <h5 <?php echo $product['image2'] ? '': 'style="display: none;"'?> >عکس دوم</h5>
                    </div>

                    <div>
                        <div class="selected-img" <?php echo $product['image3'] ? 'style="background: #ffffff; border: 2px solid rgba(0,0,0,0.3);"' : ''; ?>>
                            <?php if ($product['image3']) { ?>
                                <img src="../images/products/<?php echo $product['image3'] ?>" alt="">
                            <?php } ?>
                        </div>
                        <h5 <?php echo $product['image3'] ? '': 'style="display: none;"'?> >عکس سوم</h5>
                    </div>

                    <div>
                        <div class="selected-img" <?php echo $product['image4'] ? 'style="background: #ffffff; border: 2px solid rgba(0,0,0,0.3);"' : ''; ?>>
                            <?php if ($product['image4']) { ?>
                                <img src="../images/products/<?php echo $product['image4'] ?>" alt="">
                            <?php } ?>
                        </div>
                        <h5 <?php echo $product['image4'] ? '': 'style="display: none;"'?> >عکس چهارم</h5>
                    </div>

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
                    <input type="submit" name="edit_product" value="ویرایش">
                </div>

            </form>

        </div>

    </section>

</main>
</div>

<script src="./js/script.js"></script>
</body>

</html>