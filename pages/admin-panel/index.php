<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/product.php";
    include "../../components/global-css-settings.php";

    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Admin Panel</title>
</head>

<?php

if (isset($_POST['login'])) $login = $_POST['login'];
if (isset($_POST['password'])) $password = $_POST['password'];

$user_abs = mysqli_query($des, "SELECT * from users WHERE login = '$login' AND password = '$password'");
$user = mysqli_fetch_array($user_abs);

if ($_SESSION['page'] != "admin") {
    if ($user['role'] == "user") {
        header("Location: ../../index.php?user_id=$user[id]&user_login=$user[login]");
    }
    if ($user['id'] != "") {
        $_SESSION["user_id"] = $user['id'];
    } else {
        header("Location: ../login/index.php?select_user=false");
    }
    $_SESSION['page'] = "admin";
}
$user_id = $_SESSION["user_id"];


if ($_GET['DESC'] != "") {
    $_SESSION["DESC"] = $_GET['DESC'] == "true" ? true : false;
}
$DESC = $_SESSION["DESC"];

if ($_GET['from'] != "") {
    $_SESSION["from"] = $_GET['from'];
}
$from = $_SESSION["from"];

if ($_GET['to'] != "") {
    $_SESSION["to"] = $_GET['to'];
}
$to = $_SESSION["to"];


$_SESSION["filt_creator"] = $_GET['filt_creator'];
$filt_creator = $_SESSION["filt_creator"];

if (isset($_REQUEST["delete_id"]))
    foreach ($_REQUEST["delete_id"] as $key => $value) {
        mysqli_query($des, "DELETE FROM `products` WHERE `products`.`id` = $value ");
    }
?>

<body>
    <a href="../../index.php"><button> Вернутся</button></a>
    <div class="view">
        <?php
        $input_error = false;
        if (
            isset($_REQUEST['creator']) and
            isset($_REQUEST['name']) and
            isset($_REQUEST['price']) and
            isset($_REQUEST['url'])
        ) {

            $creator = $_GET['creator'];
            $name = $_GET['name'];
            $price = $_GET['price'];
            $url = $_GET['url'];

            $select_query =
                "SELECT * 
                FROM `products` 
                WHERE `user_id` = '$user_id' 
                    AND `creator` = '$creator' 
                    AND `price` = '$price' 
                    AND `url` = '$url'";

            $abs_product = mysqli_query($des, $select_query);

            if (!mysqli_fetch_array($abs_product)) {
                $check = mysqli_query(
                    $des,
                    "INSERT INTO `products` (`id`, `user_id`, `creator`, `name`, `price`, `url`) 
                    VALUES (NULL, '$user_id', '$creator', '$name', '$price', '$url')"
                );
            }
        } else {
            $input_error = true;
        }

        ?>
        <div class="filters">
            Сортировать <a href="?DESC=false">по возрастанию</a> <a href="1.php?DESC=true">по убыванию</a>
            <br>
            <div class="filter">
                Фильтр по цене

                <form id="filter" action="./" method="GET">
                    <span>От</span> <input type="number" name="from">
                    <span>До</span> <input type="number" name="to">

                    <br><button type="submit"> Отфильтровать </button>
                </form>
            </div>
            <div class="filter">
                Фильтр по Компаниям

                <form id="filter" action="./" method="GET">
                    <span>⠀</span>
                    <span>⠀</span>
                    <span>⠀</span>

                    <select name="filt_creator">
                        <option value=""></option>
                        <?php
                        $select_query =
                            "SELECT `creator`, MAX(price) FROM `products` WHERE `user_id` = $user_id  GROUP BY `creator`";

                        $abs_creators = mysqli_query($des, $select_query);

                        while ($creator = mysqli_fetch_array($abs_creators)['creator']) {
                            echo "<option value=$creator  > $creator </option>";
                        }

                        ?>
                    </select>
                    <span>⠀</span>
                    <span>⠀</span>
                    <span>⠀</span>

                    <button type="submit"> Отфильтровать </button>
                </form>
            </div>

            <br>
            <div class="filter">
                Добавление
                <form id="create" action="./" method="GET">

                    <span>Компания</span> <input type="text" <?php echo $input_error ?  'value="' . $_REQUEST["creator"] . '"' : "" ?> name="creator" required>
                    <span>Название</span> <input type="text" <?php echo $input_error ?  'value="' . $_REQUEST["name"] . '"' : "" ?> name="name" required>
                    <span>Цена</span> <input type="number" <?php echo $input_error ?  'value="' . $_REQUEST["price"] . '"' : "" ?> name="price" required>
                    <span>Картинка</span> <textarea name="url" required><?php echo $input_error ?  $_REQUEST["url"] : "" ?></textarea>
                    <br><button type="submit"> Добавить </button>

                </form>
            </div>

        </div>

        <form class="target-products" action="index.php" method="GET">
            <div class="products">
                <?php

                if (!$DESC) $p = "ORDER BY creator";
                else $p = "ORDER BY creator DESC";

                $query = "WHERE user_id = $user_id";

                if (isset($from) && isset($to)) {

                    if ($from !== "") {
                        $query = $query . " AND `price` >= $from ";
                    }
                    if ($to !== "") {
                        $query = $query . " AND `price` <= $to ";
                    }
                    if ($filt_creator !== "") {
                        $query = $query . " AND `creator` = '$filt_creator' ";
                    }
                }
                $rez = mysqli_query($des, "SELECT * FROM products $query $p");

                $r = 1;
                while (
                    $mas = mysqli_fetch_array($rez)
                ) {
                    echo create_product($mas, $r++, "admin");
                }
                ?>
            </div>
            <button class="btn-del" type=submit>УДАЛИТЬ ВЫБРАННЫЕ ПРОДУКТЫ!!!</button>
        </form>
    </div>
</body>

</html>