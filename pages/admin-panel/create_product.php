<?php
include "../../components/db-connect.php";
session_start();
var_dump($_SESSION);
$user_id = $_SESSION["user_id"];
$creator = $_POST['creator'];
$name = $_POST['name'];
$price = $_POST['price'];
$url = $_POST['url'];

$select_query = "SELECT * FROM `products` WHERE `user_id` = '$user_id' AND `creator` = '$creator' AND `price` = '$price' AND `url` = '$url'";
$abs_product = mysqli_query($des, $select_query);

if (!mysqli_fetch_array($abs_product)) {
    $check = mysqli_query($des, "INSERT INTO `products` (`id`, `user_id`, `creator`, `name`, `price`, `url`) VALUES (NULL, '$user_id', '$creator', '$name', '$price', '$url')");
}
