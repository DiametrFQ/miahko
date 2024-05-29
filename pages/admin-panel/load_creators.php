<?php
include "../../components/db-connect.php";
session_start();

$user_id = $_SESSION["user_id"];
$select_query = "SELECT `creator`, MAX(price) FROM `products` WHERE `user_id` = $user_id GROUP BY `creator`";
$abs_creators = mysqli_query($des, $select_query);

$options = '<option value=""></option>';
while ($creator = mysqli_fetch_array($abs_creators)['creator']) {
    $options .= "<option value='$creator'>$creator</option>";
}
echo $options;
