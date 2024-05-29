<?php
include "./components/db-connect.php";
include "./components/product.php";

$search = $_GET["search"] ?? '';
$from = $_GET["from_price"] ?? '';
$to = $_GET["to_price"] ?? '';

$query = "SELECT * FROM `products` WHERE (creator LIKE '%$search%' OR name LIKE '%$search%')";

if (!empty($from)) {
    $query .= " AND `price` >= $from";
}
if (!empty($to)) {
    $query .= " AND `price` <= $to";
}

$rez = mysqli_query($des, $query);

$output = "";
while ($mas = mysqli_fetch_array($rez)) {
    $output .= create_product($mas, 1, "user");
}
echo $output;
