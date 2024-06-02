<?php
include "../../components/db-connect.php";
include "../../components/product.php";
session_start();

$user_id = $_SESSION["user_id"];
$DESC = isset($_SESSION["DESC"]) ? $_SESSION["DESC"] : false;
$from = isset($_SESSION["from"]) ? $_SESSION["from"] : "";
$to = isset($_SESSION["to"]) ? $_SESSION["to"] : "";
$filt_creator = isset($_SESSION["filt_creator"]) ? $_SESSION["filt_creator"] : "";

$p = $DESC ? "ORDER BY creator DESC" : "ORDER BY creator";

$query = "WHERE user_id = $user_id";
if ($from !== "") {
    $query .= " AND `price` >= $from ";
}
if ($to !== "") {
    $query .= " AND `price` <= $to ";
}
if ($filt_creator !== "") {
    $query .= " AND `creator` = '$filt_creator' ";
}

$rez = mysqli_query($des, "SELECT * FROM products $query $p");
$r = 1;

$options = [];
while ($mas = mysqli_fetch_assoc($rez)) {
    $options[] = $mas;
}

echo json_encode($options, JSON_UNESCAPED_UNICODE);
