<?php
include "../../components/db-connect.php";
include "../../components/product.php";

$response = ["success" => false];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST['update_id']) &&
        !empty($_POST['creator']) &&
        !empty($_POST['name']) &&
        !empty($_POST['price']) &&
        !empty($_POST['url'])
    ) {
        $update_id = $_POST['update_id'];
        $creator = $_POST['creator'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $url = $_POST['url'];
        $discount = 0;
        if (!empty($_POST['url'])) {
            $discount = $_POST['discount'];
        }

        $update_query = "UPDATE `products` 
                        SET 
                        `creator` = '$creator', 
                        `name` = '$name', 
                        `price` = '$price', 
                        `url` = '$url',
                        `discount` = '$discount'
                        WHERE 
                        `id` = '$update_id'";

        if (mysqli_query($des, $update_query)) {
            // Получаем обновленную информацию о продукте
            $select_query = "SELECT * FROM `products` WHERE `id` = '$update_id'";
            $result = mysqli_query($des, $select_query);
            $product = mysqli_fetch_assoc($result);

            $response = [
                "success" => true,
                "updated_product" => $product
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
