<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    include "../../components/product.php";

    $error_update = false;
    if (
        $_REQUEST['update_id'] != ""
        and $_REQUEST['creator'] != ""
        and $_REQUEST['name'] != ""
        and $_REQUEST['price'] != ""
        and $_REQUEST['url'] != ""
    ) {
        $select_query =
            "UPDATE `products` 
            SET 
            `creator` = '$_REQUEST[creator]', 
            `name` = '$_REQUEST[name]', 
            `price` = '$_REQUEST[price]', 
            `url` = '$_REQUEST[url]' 
            WHERE 
            `products`.`id` = $_REQUEST[update_id]";

        mysqli_query($des, $select_query);
    } else {
        if ($_REQUEST['is_update']) {
            $error_update = true;
        }
    }
    $product_abs = mysqli_query($des, "SELECT * from `products` WHERE `id` = '$_REQUEST[update_id]'");
    $product = mysqli_fetch_array($product_abs);
    ?>
    <style>
        .input_info {
            display: grid;
            grid-template-columns: 100px 1fr;
        }
    </style>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>

<body>
    <a href="../admin-panel/"><button> Вернутся</button></a>

    <?php
    if ($error_update) {
        echo '<h1 color="red" align=center>Не все данные введены</h1>';
    }
    ?>
    <div class="center-component">
        <?= create_product($product, 1, "user") ?>
    </div>

    <div id="create" class="center-component">

        <form class="input_info" action="?update=true&">
            <input type="hidden" value=<?php echo $product["id"] ?> name="update_id">
            <input type="hidden" value="true" name="is_update">
            <span>Компания</span> <input type="text" value=<?= $product["creator"] ?> name="creator" required>
            <span>Название</span> <input type="text" value=<?= $product["name"] ?> name="name" required>
            <span>Цена</span> <input type="number" value=<?= $product["price"] ?> name="price" required>
            <span>Картинка</span> <textarea name="url" required><?= $product["url"] ?></textarea>
            <br><br><br><button type="submit">Изменить</button>
        </form>
    </div>
</body>

</html>