<?php
require_once('dbconfig.php');
$page_title = "حساب‌های کاربری";
include("./include/sidebar.php");
include("./include/header.php");
include("./functions/functions.php");

if (isset($_GET['userId'])) {

    $user_id = $_GET['userId'];
    $deleteUser = $conn->prepare("DELETE FROM `users` WHERE id = :user_id");
    $deleteUser->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $deleteUser->execute();

    header('Location: users.php');
    exit();
}


$users = $conn->prepare("SELECT * FROM `users`");
$users->execute();
?>

<main class="main users-main">

    <!-- Recent Tables -->
    <section class="table-container">

        <div class="table-card">
            <div class="card-header">
                <h3>حساب‌های كاربری جديد</h3>
            </div>
            <div class="card-body">
                <div class="table-wrapper users-table">
                    <table>
                        <thead>
                            <tr>
                                <td>شماره</td>
                                <td>نام‌کاربری</td>
                                <td>ايميل</td>
                                <td>نام</td>
                                <td>شماره‌تماس</td>
                                <td>جنسیت</td>
                                <td>آدرس</td>
                                <td>تاريخ عضويت</td>
                                <td>تنظيمات</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($users->rowCount() > 0) {
                                $i = 1;
                                foreach ($users as $user) {
                                    $join_date = date("Y/m/d", strtotime($user['created_at']));
                            ?>
                                    <tr>
                                        <td><?php echo toPersianNum($i) ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['name'] ?? "---"; ?></td>
                                        <td><?php echo toPersianNum($user['phone'] ?? "---"); ?></td>
                                        <td><?php echo $user['gender'] ?? "---"; ?></td>
                                        <td><?php echo $user['address'] ?? "---"; ?></td>
                                        <td><?php echo toPersianNum($join_date); ?></td>
                                        <td>
                                            <a class="change-btn red" href="users.php?userId=<?php echo $user['id']; ?>">حذف</a>
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