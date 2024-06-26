<?php
include "../../components/header.php";
include "../../components/db-connect.php";
include "../../components/global-css-settings.php";
include "../../components/product.php";
// Подключение к базе данных и другие необходимые операции
session_start();

// Получение данных из POST-запроса
$name = $_REQUEST['name'];
$creator = $_REQUEST['creator'];
$price = $_REQUEST['price'];

// echo var_dump($_REQUEST);
// echo var_dump($_SESSION);
// echo var_dump($_COOKIE);



// Добавление продукта в базу данных
// Здесь будет ваш код для добавления продукта в базу данных

// Подключение к базе данных и другие необходимые операции

$select_query =
    "SELECT `count` FROM `bucket` WHERE `user_id` = '$_SESSION[user_id]' AND `product_id` = '$_REQUEST[id]';";

$rez = mysqli_query($des, $select_query);

if (mysqli_num_rows($rez) > 0) {
    $mas = mysqli_fetch_array($rez);
    $count = $mas['count'] + 1;
    $query = "UPDATE `bucket` SET `count` = $count WHERE `user_id` = '$_SESSION[user_id]' AND `product_id` = '$_REQUEST[id]';";
} else {
    $count = 1;
    $query =
        "INSERT INTO `bucket` ( `user_id`, `product_id`, `count`) VALUES ( '$_SESSION[user_id]', '$_REQUEST[id]', $count);";
}
mysqli_query($des, $query);
// Возврат ответа в формате JSON


$response = array(
    'code' => 200,
    'count' => $count,
    'success' => true,
    'message' => 'Product added to basket successfully',
);

echo json_encode($response);
