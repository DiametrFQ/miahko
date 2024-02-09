<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/header.php";
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    include "../../components/product.php";

    $product_id = $_REQUEST["product_id"];
    $Rcount = $_REQUEST["count"];
    $del_prod_id = $_REQUEST["del_prod_id"];
    $prod_id = $_REQUEST["prod_id"];
    $buy_prod_id = $_REQUEST["buy_prod_id"];

    $basket = $_COOKIE["basket"];

    if ($_REQUEST["product_id"] != "") {
        $select_query =
            "SELECT count
                FROM `bucket` 
                WHERE `user_id` = '$_COOKIE[user_id]' 
                    AND `product_id` = '$product_id'";

        $abs_product = mysqli_query($des, $select_query);

        if ($count = mysqli_fetch_array($abs_product)['count']) {
            ++$count;
            $U =
                "UPDATE `bucket` 
                    SET `count` = '$count'
                    WHERE `user_id` = '$_COOKIE[user_id]' 
                    AND `product_id` = '$product_id' ";

            mysqli_query($des, $U);
        } else {
            $Q = "INSERT INTO 
                `bucket` (`id`, `user_id`, `product_id`, `count`) 
                VALUES (NULL, '$_COOKIE[user_id]', '$product_id', '1');";

            mysqli_query($des, $Q);
        }
        header("Location: index.php");
    }

    if ($_REQUEST["del_prod_id"] != "") {
        $D =
            "DELETE FROM `bucket` 
            WHERE `user_id` = '$_COOKIE[user_id]' 
            AND `product_id` = '$del_prod_id'";

        mysqli_query($des, $D);
    }

    if ($_REQUEST["count"] != "") {

        $select_query =
            "SELECT count
                FROM `bucket` 
                WHERE `user_id` = '$_COOKIE[user_id]' 
                    AND `product_id` = '$prod_id '";

        $abs_product = mysqli_query($des, $select_query);

        if ($count = mysqli_fetch_array($abs_product)['count']) {
            $SUMM = $Rcount + $count;

            $U =
                "UPDATE `bucket` 
                    SET `count` = '$SUMM' 
                    WHERE `user_id` = '$_COOKIE[user_id]' 
                    AND `product_id` = '$prod_id'";

            mysqli_query($des, $U);
        }
    }

    if ($_COOKIE["user_id"] == "") {
        header("Location: ../login/index.php");
    }
    if ($_REQUEST["buy_prod_id"] != "") {
        $select_query =
            "SELECT count
            FROM `buy` 
            WHERE `id_product` = '$buy_prod_id'";

        $abs_product = mysqli_query($des, $select_query);
        if ($count = mysqli_fetch_array($abs_product)['count']) {
            $SUM = $count + $Rcount;
            echo $SUM;
            echo $count;
            echo $Rcount;

            $Q =
                "UPDATE buy 
                    SET `count` = $SUM
                    WHERE `id_product` = '$buy_prod_id'";

            mysqli_query($des, $Q);
        } else {
            $Q =
                "INSERT 
                INTO `buy` (`id_product`, `count`) 
                VALUES ('$buy_prod_id', '$Rcount')";

            mysqli_query($des, $Q);
        }

        $D =
            "DELETE FROM `bucket` 
            WHERE `user_id` = '$_COOKIE[user_id]' 
            AND `product_id` = '$buy_prod_id'";

        mysqli_query($des, $D);
        header("Location: index.php");
    }


    if ($basket != null) {
        if (stripos($basket, $product_id) === false) {
            setcookie('basket', $basket . " " . $product_id, time() + 3600);
        }
    } else {
        setcookie('basket', $product_id, time() + 3600);
    }
    $addId = function ($value) {
        return "`id` = '$value'";
    };

    $basket = array_map($addId, explode(" ", $basket));
    $basket = "OR" . implode(" OR ", $basket);
    $query = "SELECT * from `products` WHERE `id` = '$_REQUEST[product_id]' $basket ";
    $product_abs = mysqli_query($des, $query);

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <title>Basket</title>
</head>

<body>
    <?= create_header($_COOKIE["user_login"]) ?>

    <a class="back" href="../../index.php?user_login=<?= $_COOKIE['user_login'] ?>">Назад</a>

    <?php

    $select_query =
        "SELECT * 
        FROM `bucket` as `b` 
        inner join `products` as `pr` 
        ON `b`.`product_id` = `pr`.`id` 
        WHERE `b`.`user_id` = '$_COOKIE[user_id]'";


    $abs_products = mysqli_query($des, $select_query);

    echo "<div class=products>";
    while ($product = mysqli_fetch_array($abs_products)) {
        echo create_product($product, $product["count"], "basket");
    }
    echo "</div>";
    ?>

    <?= create_footer() ?>
</body>

</html>