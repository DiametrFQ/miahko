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

<body>
    <a href="../../index.php"><button class="back"> Вернуться</button></a>
    <div class="view">
        <div class="filters">
            Сортировать <a href="#" id="sort-asc">по возрастанию</a> <a href="#" id="sort-desc">по убыванию</a>
            <br>
            <div class="filter">
                Фильтр по цене
                <form id="filter-price" method="GET">
                    <span>От</span> <input type="number" name="from">
                    <span>До</span> <input type="number" name="to">
                    <br><button type="submit"> Отфильтровать </button>
                </form>
            </div>
            <div class="filter">
                Фильтр по Компаниям
                <form id="filter-creator" method="GET">
                    <select name="filt_creator">
                        <option value=""></option>
                        <!-- Опции будут заполнены через AJAX -->
                    </select>
                    <br><button type="submit"> Отфильтровать </button>
                </form>
            </div>
            <br>
            <div class="filter">
                Добавление
                <form id="create-product" method="POST">
                    <span>Компания</span> <input type="text" name="creator" required>
                    <span>Название</span> <input type="text" name="name" required>
                    <span>Цена</span> <input type="number" name="price" required>
                    <span>Картинка</span> <textarea name="url" required></textarea>
                    <br><button type="submit"> Добавить </button>
                </form>
            </div>
        </div>
        <form id="delete-products" method="POST">
            <div class="products"> </div>
            <button class="btn-del" type="submit">УДАЛИТЬ ВЫБРАННЫЕ ТОВАРЫ!!!</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadProducts() {
                $.ajax({
                    url: './load_products.php',
                    method: 'GET',
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            }

            function loadCreators() {
                $.ajax({
                    url: './load_creators.php',
                    method: 'GET',
                    success: function(data) {
                        $('select[name="filt_creator"]').html(data);
                    }
                });
            }

            $('#filter-price').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './filter_products.php',
                    method: 'GET',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            });

            $('#filter-creator').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './filter_products.php',
                    method: 'GET',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            });

            $('#create-product').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './create_product.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        loadProducts();
                    }
                });
            });

            $('#delete-products').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './delete_products.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        loadProducts();
                    }
                });
            });

            $('#sort-asc').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './sort_products.php',
                    method: 'GET',
                    data: {
                        order: 'asc'
                    },
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            });

            $('#sort-desc').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: './sort_products.php',
                    method: 'GET',
                    data: {
                        order: 'desc'
                    },
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            });

            loadProducts();
            loadCreators();
        });
    </script>
</body>

</html>