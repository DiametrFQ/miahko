<?php
include "../../components/db-connect.php";
include "../../components/product.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_id = $_POST["prod_id"];
    $count = $_POST["count"];

    $update_query = "UPDATE `bucket` 
                    SET `count` = $count 
                    WHERE `user_id` = $_SESSION[user_id]
                    AND `product_id` = $prod_id";


    if (mysqli_query($des, $update_query)) {
        // Получаем обновленную информацию о товаре
        $select_query = "SELECT * FROM `bucket` WHERE `user_id` = '$_SESSION[user_id]'";

        $bucket_result = mysqli_query($des, $select_query);

        $products = [];

        while ($bucket = mysqli_fetch_array($bucket_result)) {
            $product_id = $bucket["product_id"];
            $select_query = "SELECT * FROM `products` WHERE `id` = '$product_id'";
            $products_result = mysqli_query($des, $select_query);
            $product = mysqli_fetch_assoc($products_result);
            $product["count"] = $bucket["count"];
            $products[] = $product;
        }
        // echo var_dump($product);
        // Возвращаем HTML для обновления товара
        echo json_encode([
            "products" => $products,
            "success" => true,
            "message" => "Корзина обновлена!",
            "code" => 200
        ]);
    } else {;
        echo json_encode([
            "products" => [],
            "success" => false,
            "message" => "Ошибка при обновлении корзины!",
            "code" => 400
        ]);
    }
}
