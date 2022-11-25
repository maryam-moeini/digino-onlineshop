<?php
require_once('dbconfig.php');
$page_title = "دنبال‌کننده ها";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

if (isset($_GET['subId'])) {

    $sub_id = $_GET['subId'];

    $deleteScriber = $conn->prepare("DELETE FROM `subscribers` WHERE id = :sub_id");
    $deleteScriber->bindParam(":sub_id", $sub_id, PDO::PARAM_STR);
    $deleteScriber->execute();

    header('Location: subscribers.php');
    exit();
}

$subscribers = $conn->prepare("SELECT * FROM `subscribers`");
$subscribers->execute();

?>

<main class="main subscribers-main">

    <!-- Recent Tables -->
    <section class="table-container">

        <div class="table-card">
            <div class="card-header">
                <h3>دنبال‌کننده ها</h3>
            </div>
            <div class="card-body">
                <div class="table-wrapper subscribers-table">
                    <table>
                        <thead>
                            <tr>
                                <td>شماره</td>
                                <td>ايميل</td>
                                <td>تنظيمات</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($subscribers->rowCount() > 0) {
                                $i = 1;
                                foreach ($subscribers as $subscriber) {
                            ?>
                                    <tr>
                                        <td><?php echo toPersianNum($i)?></td>
                                        <td><?php echo $subscriber['email']; ?></td>
                                        <td>
                                            <a class="change-btn red" href="subscribers.php?subId=<?php echo $subscriber['id']; ?>">حذف</a>
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