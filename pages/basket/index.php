<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/header.php";
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    include "../../components/product.php";
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Basket</title>
</head>

<body>
    <?= create_header($_SESSION["user_login"]) ?>

    <div>asdasdasd</div>

    <a class="back" href="../../index.php?user_login=<?= $_SESSION['user_login'] ?>">Назад</a>

    <div class="products">
        <?php
        $select_query =
            "SELECT * 
        FROM `bucket` as `b` 
        inner join `products` as `pr` 
        ON `b`.`product_id` = `pr`.`id` 
        WHERE `b`.`user_id` = '$_SESSION[user_id]'";

        $abs_products = mysqli_query($des, $select_query);

        while ($product = mysqli_fetch_array($abs_products)) {
            echo create_product($product, $product["count"], "basket");
        }
        ?>
    </div>

    <?= create_footer() ?>
    <script src="./scripts.js"> </script>
</body>

</html>