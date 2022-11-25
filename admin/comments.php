<?php

$page_title = "نظرات";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");


if (isset($_GET['action']) && isset($_GET['id'])) {

    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'delete') {
        $query = $conn->prepare("DELETE FROM `comments` WHERE id =:id");
    } else {
        $query = $conn->prepare("UPDATE `comments` SET `status`='1' WHERE id =:id");
    }

    $query->execute(['id' => $id]);

    header("Location:comments.php");
    exit();
}

$comments = $conn->prepare("SELECT * FROM `comments` ORDER BY status DESC");
$comments->execute();

?>

<main class="main comments-main">

    <!-- Products Tables -->
    <section class="table-container">

        <div class="table-card">
            <div class="card-header">
                <h3>نظرات</h3>
                <!-- <a class="card-header_btn" href="./new_product.php">ایجاد محصول</a> -->
            </div>

            <div class="card-body">
                <div class="table-wrapper comments-table">
                    <table>
                        <thead>
                            <tr>
                                <td>شماره</td>
                                <td>نام</td>
                                <td>ديدگاه</td>
                                <td>تاريخ</td>
                                <td>تنظيمات</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($comments->rowCount() > 0) {
                                $i = 1;
                                foreach ($comments as $comment) {
                            ?>
                                    <tr>

                                        <td><?php echo toPersianNum($i) ?></td>
                                        <td><?php echo $comment['name']; ?></td>
                                        <td><?php echo $comment['comment']; ?></td>
                                        <td><?php echo toPersianNum($comment['date']); ?></td>
                                        <td>
                                            <?php if ($comment['status'] == '1') { ?>
                                                <a class="change-btn green approved" href="">تاييد شده</a>
                                            <?php } ?>
                                            <?php if ($comment['status'] == '0') { ?>
                                                <a class="change-btn green" href="comments.php?action=approve&id=<?php echo $comment['id']; ?>">تاييد</a>
                                            <?php } ?>
                                            <a class="change-btn red" href="comments.php?action=delete&id=<?php echo $comment['id']; ?>">حذف</a>
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