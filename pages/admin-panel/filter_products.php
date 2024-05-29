<?php
include "../../components/db-connect.php";
include "../../components/product.php";
session_start();

$user_id = $_SESSION["user_id"];
$from = isset($_GET["from"]) ? $_GET["from"] : "";
$to = isset($_GET["to"]) ? $_GET["to"] : "";
$filt_creator = isset($_GET["filt_creator"]) ? $_GET["filt_creator"] : "";

$_SESSION["from"] = $from;
$_SESSION["to"] = $to;
$_SESSION["filt_creator"] = $filt_creator;

$DESC = isset($_SESSION["DESC"]) ? $_SESSION["DESC"] : false;
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
while ($mas = mysqli_fetch_array($rez)) {
    echo create_product($mas, $r++, "admin");
}
