<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/product.php";
    include "../../components/global-css-settings.php";
    include "../../components/header.php";
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Admin Panel</title>
</head>

<body>
    <?= create_header($_SESSION["user_login"]) ?>
    <a href="../../index.php"><button class="back"> Вернуться</button></a>
    <div class="view">
        <form id="filter-product" method="GET">
            <!-- <div>
                <span>Сортировать</span>
                <a href="#" id="sort-asc">по возрастанию</a>
                <a href="#" id="sort-desc">по убыванию</a>
            </div> -->

            <div class="filter">
                <span>Фильтр по цене</span>
                <div class="price-filter">
                    <span>От</span> <input type="number" name="from">
                    <span>До</span> <input type="number" name="to">
                </div>
            </div>
            <div class="filter">
                <span>Фильтр по Компаниям</span>
                <select name="filt_creator">
                    <option value=""></option>
                    <!-- Опции будут заполнены через AJAX -->
                </select>
            </div>
            <button type="submit"> Отфильтровать </button>
        </form>
        <form class="delete-products" method="POST">
            <div class="products"> </div>

        </form>
        <div class="settings">
            <button class="btn-del" type="submit">УДАЛИТЬ ВЫБРАННЫЕ ТОВАРЫ</button>
            Добавление
            <form id="create-product" method="POST">
                <div>
                    <span>Компания</span>
                    <input type="text" name="creator" required>
                </div>
                <div>
                    <span>Название</span>
                    <input type="text" name="name" required>
                </div>
                <div>
                    <span>Цена</span>
                    <input type="number" name="price" required>
                </div>
                <div>
                    <span>Скидка</span>
                    <input type="number" name="discount" min="0" max="100" required>
                </div>
                <div>
                    <span>Картинка</span>
                    <textarea name="url" required></textarea>
                </div>
                <button type="submit"> Добавить </button>
            </form>
        </div>
    </div>
    <?= create_footer() ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>
</body>

</html>