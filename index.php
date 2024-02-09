<!DOCTYPE html>
<html lang="ru">

<head>
    <?php
    $_SESSION['page'] = "view";

    if ($_REQUEST["user_id"] != "") {
        $_SESSION["user_id"] =  $_REQUEST["user_id"];
        setcookie("user_id", $_REQUEST["user_id"], time() + 3600 * 24 * 7);
    }
    if ($_REQUEST["user_login"] != "") {
        $_SESSION["user_login"] =  $_REQUEST["user_login"];
        setcookie("user_login", $_REQUEST["user_login"], time() + 3600 * 24 * 7);
    }
    include "./components/db-connect.php";
    include "./components/product.php";
    include "./components/global-css-settings.php";
    include "./components/header.php";

    if ($_REQUEST["search"] != "") {
        $search = $_REQUEST["search"];
    }
    if ($_REQUEST["from-price"] != "") {
        $from = $_REQUEST["from-price"];
    }
    if ($_REQUEST["to-price"] != "") {
        $to = $_REQUEST["to-price"];
    }

    $query =
        "SELECT *
        FROM `products` 
        WHERE 
            (creator LIKE '%$search%' OR 
            name LIKE '%$search%')";


    $QPrice =
        "SELECT MAX(price), MIN(price)
        FROM `products` 
        WHERE 
            (creator LIKE '%$search%' OR 
            name LIKE '%$search%')";


    if (isset($from) && isset($to)) {

        if ($from !== "") {
            $query = $query . " AND `price` >= $from ";
            $QPrice = $QPrice . " AND `price` >= $from ";
        }
        if ($to !== "") {
            $query = $query . " AND `price` <= $to ";
            $QPrice = $QPrice . " AND `price` <= $to ";
        }
    }

    $price = mysqli_fetch_array(mysqli_query($des, $QPrice));
    $maxPrice = $price["MAX(price)"];
    $minPrice = $price["MIN(price)"];

    $rez = mysqli_query($des, $query);

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <title>Мяхко</title>
</head>

<body class="index">
    <?= create_header($_COOKIE["user_login"]) ?>

    <form class="search">
        <search role="search">
            <input type="text" name="search" value=<?= $search ?>>
            <div class="buttonSrch" type="submit">Найти</div>
            <script>
                "use strict"
                const btnsrch = document.querySelector(".buttonSrch")
                btnsrch.onclick = () => {
                    document.querySelector(".search").submit()
                }
            </script>
        </search>
    </form>

    <div class="view">
        <div>
            <form class="settings">
                Цена
                <div>
                    <span>От</span>
                    <input type="number" name="from-price" value=<?= $minPrice ?>>
                </div>
                <div>
                    <span>До</span>
                    <input type="number" name="to-price" value=<?= $maxPrice ?>>
                </div>
                <input type="hidden" name="search" value=<?= $search ?>>

                <button type="submit">Искать</button>

            </form>
        </div>
        <div class="products">
            <?php
            $r = 1;
            while (
                $mas = mysqli_fetch_array($rez)
            ) {
                echo create_product($mas, $r++, "user");
            }
            ?>
        </div>
    </div>

    <?= create_footer() ?>
</body>

</html>