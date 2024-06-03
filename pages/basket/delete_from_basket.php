<?php
include "../../components/db-connect.php";

session_start();

$select_query =
    "DELETE FROM bucket WHERE `product_id` = '$_REQUEST[product_id]' AND `user_id` = '$_SESSION[user_id]'";

mysqli_query($des, $select_query);
