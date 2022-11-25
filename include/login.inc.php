<?php
require_once('../dbconfig.php');
require_once('../functions/functions.php');

if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username !== "" && $password !== "") {

        $usernameExists = $conn->prepare("SELECT * FROM `users` WHERE username = :username OR email = :username");
        $usernameExists->execute(['username' => $username]);
        $account = $usernameExists -> fetch(PDO::FETCH_ASSOC);
        

        if ($usernameExists->rowCount() == 1) {

            $pwdHashed = $account['password'];
            $checkPwd = password_verify($password, $pwdHashed);

            if ($checkPwd == false) {
                header("location: ../login.php?error=wronglogin");
                exit();
            }
            else if ($checkPwd == true) {
                session_start();
                $_SESSION['userId'] = $account['id'];
                header("location: ../index.php");
                exit();
            }

        } else if ($usernameExists->rowCount() == 0) {
            header("location: ../login.php?error=wronglogin");
            exit();
        }



        $sql = $conn->prepare("INSERT INTO `users`(`username`, `email`, `password`) VALUES (:username, :email, :password)");
        $sql->execute(['username' => $username, 'email' => $email, 'password' => $hashedPwd]);

        header("Location: ../login.php?login=successfull");
        exit();
    } else {
        header('location: ../login.php');
        exit();
    }
} else {
    header('location: ../login.php');
}
