<?php
include "../../components/db-connect.php";
session_start();

$user_id = $_SESSION["user_id"];
$creator = $_POST['creator'];
$name = $_POST['name'];
$price = $_POST['price'];
$url = $_POST['url'];
if ($_POST['discount'] == "") {
    $_POST['discount'] = 0;
}
$discount = $_POST['discount'];

// INSERT INTO `products` (`id`, `user_id`, `creator`, `name`, `price`, `url`, `discount`) VALUES (NULL, '1', 'asdsad', 'asdasd', '12', 'asdasd', '4');

$select_query = "SELECT * FROM `products` WHERE `user_id` = '$user_id' AND `creator` = '$creator' AND `price` = '$price' AND `url` = '$url'";
$abs_product = mysqli_query($des, $select_query);

if (!mysqli_fetch_array($abs_product)) {
    $insert_query = "INSERT INTO `products` (`id`, `user_id`, `creator`, `name`, `price`, `url`, `discount`) VALUES (NULL, '$user_id', '$creator', '$name', '$price', '$url', '$discount')";
    echo $insert_query;
    mysqli_query($des, $insert_query);
}

// echo json_encode($select_query, JSON_UNESCAPED_UNICODE);
