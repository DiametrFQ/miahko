<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <title>Мяхко</title>
</head>

<body class="index">
    <?php
    session_start();
    $_SESSION['page'] = "view";

    if (isset($_REQUEST["user_id"]) && $_REQUEST["user_id"] != "") {
        $_SESSION["user_id"] = $_REQUEST["user_id"];
        setcookie("user_id", $_REQUEST["user_id"], time() + 3600 * 24 * 7);
    }
    if (isset($_REQUEST["user_login"]) && $_REQUEST["user_login"] != "") {
        $_SESSION["user_login"] = $_REQUEST["user_login"];
        setcookie("user_login", $_REQUEST["user_login"], time() + 3600 * 24 * 7);
    }

    include "./components/db-connect.php";
    include "./components/product.php";
    include "./components/global-css-settings.php";
    include "./components/header.php";

    $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
    $from = isset($_REQUEST["from-price"]) ? $_REQUEST["from-price"] : "";
    $to = isset($_REQUEST["to-price"]) ? $_REQUEST["to-price"] : "";

    $query = "SELECT * FROM `products` WHERE (creator LIKE '%$search%' OR name LIKE '%$search%')";

    if (!empty($from) && !empty($to)) {
        $query .= " AND `price` BETWEEN $from AND $to";
    }

    $rez = mysqli_query($des, $query);

    ?>
    <?= create_header($_SESSION["user_login"]) ?>

    <form class="search" id="searchForm">
        <search role="search">
            <input type="text" name="search" value="<?= $search ?>">
            <button class="buttonSrch" type="submit">Найти</div>
        </search>
    </form>

    <div class="view">
        <div>
            <form class="settings" id="settingsForm">
                Цена
                <div>
                    <span>От</span>
                    <input type="number" name="from-price" value="<?= $from ?>">
                </div>
                <div>
                    <span>До</span>
                    <input type="number" name="to-price" value="<?= $to ?>">
                </div>
                <input type="hidden" name="search" value="<?= $search ?>">
                <button type="button" id="searchBtn">Искать</button>
            </form>
        </div>
        <div class="products">
            <?php
            $r = 1;
            while ($mas = mysqli_fetch_array($rez)) {
                echo create_product($mas, $r++, "user");
            }
            ?>
        </div>
    </div>

    <?= create_footer() ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".plus").on("click", function() {
            let id = $(this).data("id");
            $.ajax({
                url: "./add_to_basket.php",
                type: "POST",
                data: {
                    id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data.success);
                    if (data.success) {
                        window.location.href = "pages/basket/index.php";
                    }
                },
            });
        });

        $(document).ready(function() {

            function updateData(formData, url) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json", // Указываем, что ожидаем JSON ответ
                    success: function(response) {
                        console.log(response);

                        $(".products").html(""); // Очищаем содержимое элемента
                        response.forEach(function(product) {
                            console.log(product);
                            const a = `
                            <form class="product">
                                <div class="character">                       
                                    <div>
                                        ${product.creator}
                                    </div>
                                <div>
                                            
                                <div>${product.name}</div>
                                <div>${product.price}</div>
                                
                            </div>
                            </div>
                                <img src="${product.url}">
                                <button type="submit" id="buy" -data-id="${product.id}"> Купить </div> 
                            </form>`
                            console.log(product);
                            $(".products").append(a);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }



            $("#searchBtn").click(function(e) {
                e.preventDefault();
                var formData = $("#settingsForm").serialize() + "&" + $("#searchForm").serialize();
                updateData(formData, "./update_products.php");
            });


            $("#searchForm").submit(function(e) {
                e.preventDefault();
                var formData = $("#settingsForm").serialize() + "&" + $("#searchForm").serialize();
                updateData(formData, "./update_products.php");
            });
        });
    </script>
</body>

</html>