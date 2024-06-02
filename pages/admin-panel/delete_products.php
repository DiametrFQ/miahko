<?php

use function PHPSTORM_META\map;

include "../../components/db-connect.php";
session_start();

$user_id = $_SESSION["user_id"];
$delete_query = "DELETE FROM `products` WHERE `user_id` = $user_id";

$products_id = [];
if (isset($_POST["products_id"])) {
    foreach ($_POST["products_id"] as $id) {

        $products_id[] = $id;
        // $delete_query .= " AND `id` = $id";
    };
    $products_id = array_map(function ($id) {
        return "`id` = $id";
    }, $products_id);
    $products_id = implode(" OR ", $products_id);
    $delete_query .= " AND ($products_id)";
}
if (isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];
    $delete_query .= " AND `id` = $product_id";
}

mysqli_query($des, $delete_query);
