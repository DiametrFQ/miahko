<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    include "../../components/product.php";

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

    <div class="center-component">
        <?= create_product($product, 1, "user") ?>
    </div>

    <div class="popup-right">asdasd</div>
    <div class="popup-left">asdasdas</div>

    <div id="create" class="center-component">
        <form id="updateForm" class="input_info">
            <input type="hidden" value="<?php echo $product["id"] ?>" name="update_id">
            <span>Компания</span> <input type="text" value="<?= $product["creator"] ?>" name="creator" required>
            <span>Название</span> <input type="text" value="<?= $product["name"] ?>" name="name" required>
            <span>Цена</span> <input type="number" value="<?= $product["price"] ?>" name="price" required>
            <span>Картинка</span> <textarea name="url" required><?= $product["url"] ?></textarea>
            <br><br><br><button type="submit" id="submitBtn">Изменить</button>
        </form>
        <div id="error_message" style="color: red; display: none;">Не все данные введены</div>
        <div id="success_message" style="color: green; display: none;">Информация успешно обновлена</div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js"></script>
</body>

</html>