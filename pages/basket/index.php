<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/header.php";
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    include "../../components/product.php";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Basket</title>
</head>

<body>
    <?= create_header($_COOKIE["user_login"]) ?>

    <a class="back" href="../../index.php?user_login=<?= $_COOKIE['user_login'] ?>">Назад</a>

    <div class="products">
        <?php
        $select_query =
            "SELECT * 
        FROM `bucket` as `b` 
        inner join `products` as `pr` 
        ON `b`.`product_id` = `pr`.`id` 
        WHERE `b`.`user_id` = '$_COOKIE[user_id]'";

        $abs_products = mysqli_query($des, $select_query);

        while ($product = mysqli_fetch_array($abs_products)) {
            echo create_product($product, $product["count"], "basket");
        }
        ?>
    </div>

    <?= create_footer() ?>
    <script src="components/productRequest.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".buy", function() {
                const product_id = $(this).data("id");
                console.log(product_id);

                const form_data = $("form[data-id=" + product_id + "]").serialize();
                $.ajax({
                    type: "POST",
                    url: "./update_cart.php",
                    data: form_data,
                    success: function(data) {
                        console.log(data);

                        products = JSON.parse(data);
                        console.log(products);

                        $(".products").html("");

                        products.products.forEach(function(product) {
                            const a = `
                            <div class="product">
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
                            <div class="plus">
                                <form class="removes" data-id="${product.id}">
                                    <div>Количество : ${product.count} </div>
                                    <span>⠀</span>
                                    <input type="number" name="count" value="${product.count}">
                                    <input type="hidden" name="prod_id" value="${product.id}">
                                    <input class="buy" type="button" value=" Задать определенное количество" data-id="${product.id}">
                                    <span>⠀</span>
                                    <span>Общая сумма: ${product.price * product.count}</span>
                                    <span>⠀</span>
                                </form>
                
                                <span>
                                    <a href="?buy_prod_id=66&amp;count=5">Купить</a>
                                    <span>⠀</span>
                                    <span>⠀</span>
                                    <span>⠀</span>
                                    <a href="?del_prod_id=66">Удалить</a>
                                </span>
                            </div>
                            </div>
                        `

                            $(".products").append(a); // Добавляем HTML блок продукта к элементу с классом "products"
                        });
                    },
                });
            });
        })
    </script>
</body>

</html>