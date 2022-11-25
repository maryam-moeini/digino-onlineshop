<?php
require_once('../dbconfig.php');
include_once("../functions/functions.php");
session_start();

if (isset($_POST["addToCart"])) {

    $product_id = $_POST["product_id"];

    if (isset($_SESSION["userId"])) {

        $sql = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
        $sql->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $sql->execute();
        $product = $sql->fetch(PDO::FETCH_ASSOC);
        $colors = explode('،', $product['color']);
        $firstcolor = $colors[0];

        $user_id = $_SESSION["userId"];

        $sameProduct = $conn->prepare("SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id AND color = :color");
        $sameProduct->execute(['product_id' => $product_id, 'user_id' => $user_id, 'color' => $firstcolor]);

        if ($sameProduct->rowCount() > 0) {
            echo "<script>alert('این محصول قبلا به سبد خرید اضافه شده است.');</script>";
        } else {
            $sql = $conn->prepare("INSERT INTO `cart` (`product_id`, `user_id`, `qty`, `color`) VALUES (:product_id, :user_id, '1', :color)");
            $sql-> execute(['product_id' => $product_id, 'user_id' => $user_id, 'color' => $firstcolor]);
        }
    } else {
        echo '<script>if (window.confirm("برای افزودن کالا به سبد خرید باید وارد حساب کاربری شوید.\nآیا می‌خواهید وارد حساب کاربریتان شوید؟")) {
            window.open("./login.php", "_blank");
        };
    </script>';
    }
}


//Count User cart item
if (isset($_POST["count_item"])) {
    if (isset($_SESSION["userId"])) {

        $user_id = $_SESSION["userId"];
        $sql = $conn->prepare("SELECT COUNT(*) AS count_item FROM cart WHERE user_id = :user_id");
        $sql->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        echo (toPersianNum($row["count_item"]));
        exit();
    }
}


if (isset($_POST["addToWishlist"])) {

    $product_id = $_POST["product_id"];

    if (isset($_SESSION["userId"])) {

        $user_id = $_SESSION["userId"];

        $sameProduct = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = :user_id AND product_id = :product_id;");
        $sameProduct->execute(['product_id' => $product_id, 'user_id' => $user_id]);

        if ($sameProduct->rowCount() == 1) {
            $sql = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = :user_id AND product_id = :product_id;");

        } else if ($sameProduct->rowCount() == 0) {
            $sql = $conn->prepare("INSERT INTO `wishlist` (`product_id`, `user_id`) VALUES (:product_id, :user_id)");
        }

        $sql->execute(['product_id' => $product_id, 'user_id' => $user_id]);

    } else {
        echo '<script>if (window.confirm("برای افزودن کالا به علاقه‌مندی ها باید وارد حساب کاربری شوید.\nآیا می‌خواهید وارد حساب کاربریتان شوید؟")) {
            window.open("./login.php", "_self");
        };
    </script>';
    }
}
