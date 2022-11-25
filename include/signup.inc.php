<?php
require_once('../dbconfig.php');
require_once('../functions/functions.php');

if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    if($username !== "" && $email !== "" && $password !== "" && $password2 !== "" ) {

        $usernameExists = $conn -> prepare("SELECT * FROM `users` WHERE username = :username");
        $usernameExists -> execute(['username' => $username]);
        if( $usernameExists -> rowCount() != 0){
            header("location: ../signup.php?error=usernametaken&username=$username&email=$email");
            exit();
        }

        $emailExists = $conn -> prepare("SELECT * FROM `users` WHERE email = :email");
        $emailExists -> execute(['email' => $email]);
        if( $emailExists -> rowCount() != 0){
            header("location: ../signup.php?error=emailtaken&username=$username&email=$email");
            exit();
        }

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = $conn -> prepare("INSERT INTO `users`(`username`, `email`, `password`) VALUES (:username, :email, :password)");
        $sql -> execute(['username' => $username, 'email' => $email, 'password' => $hashedPwd]);
        
        header("Location: ../signup.php?signup=successfull");
        exit();
    }
    else {
    header('location: ../signup.php');
    exit();
    }

} else {
    header('location: ../signup.php');
}