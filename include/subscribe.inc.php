<?php
require_once('../dbconfig.php');
session_start();

if (isset($_POST['subscribe'])) {

    if (trim($_POST['email'] != "")) {

        $email = $_POST['email'];
        $subscribers = $conn->prepare("SELECT * FROM subscribers where email = :email");
        $subscribers -> execute(['email' => $email]);

        if ($subscribers->rowCount() == 1) {
            $_SESSION['subscribe'] = 'emailtaken';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();

        } else if ($subscribers->rowCount() == 0) {
            $subscribe_insert = $conn->prepare("INSERT INTO `subscribers` (email) VALUES (:email)");
            $subscribe_insert->bindParam(":email", $email, PDO::PARAM_STR);
            $subscribe_insert->execute();
            $_SESSION['subscribe'] = 'done';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['subscribe'] = 'wrongemail';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

}
