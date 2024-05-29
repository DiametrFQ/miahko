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
    <script>
        $(document).ready(function() {
            // Функция для проверки заполненности всех полей
            function checkFormFields() {
                let allFilled = true;
                $('#updateForm input, #updateForm textarea').each(function() {
                    if ($(this).val() === '') {
                        allFilled = false;
                    }
                });

                if (allFilled) {
                    $('#submitBtn').show();
                    $('#error_message').hide();
                } else {
                    $('#submitBtn').hide();
                    $('#error_message').show();
                }
            }

            // Проверяем поля при загрузке страницы
            checkFormFields();

            // Проверяем поля при изменении значений
            $('#updateForm input, #updateForm textarea').on('input', function() {
                checkFormFields();
            });

            // AJAX для отправки формы
            $("#updateForm").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "update_product.php",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            console.log($(".center-component").html());
                            $(".popup-left").html($(".center-component").html());

                            $("#success_message").show().delay(3000).fadeOut();
                            // Обновляем информацию о продукте
                            $(".center-component").first().html(response.updated_product_html);

                            // Запускаем попапы
                            $(".popup-right").css("right", "0px");
                            $(".popup-left").css("left", "0px");

                            $(".popup-right").html(response.updated_product_html);

                            setTimeout(function() {
                                $(".popup-right").css("right", "-700px");
                                $(".popup-left").css("left", "-500px");
                            }, 4000);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>