<?php
require_once("./dbconfig.php");
include_once("./functions/functions.php");
session_start();

if (!isset($_SESSION['userId'])) {

    header("Location: ../index.php");
    exit();

} else {
    
    $user_id = $_SESSION['userId'];
    $sql = $conn->prepare("SELECT * FROM `users` WHERE id = :user_id");
    $sql->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $sql->execute();
    $userInfo = $sql->fetch(PDO::FETCH_ASSOC);
}
