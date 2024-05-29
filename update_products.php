<?php
// Подключаемся к базе данных
include "./components/db-connect.php";

// Получаем данные из запроса
$search = isset($_POST["search"]) ? $_POST["search"] : "";
$from = isset($_POST["from-price"]) ? $_POST["from-price"] : "";
$to = isset($_POST["to-price"]) ? $_POST["to-price"] : "";

// Строим SQL запрос для поиска продуктов
$query = "SELECT * FROM `products` WHERE `name` LIKE '%" . $search . "%' OR `creator` LIKE '%" . $search . "%'";

if (!empty($from) && !empty($to)) {
    $query .= " AND `price` BETWEEN " . intval($from) . " AND " . intval($to);
}
// Выполняем запрос к базе данных
$result = mysqli_query($des, $query);

// Проверяем успешность запроса
if (!$result) {
    die('Invalid query: ' . mysqli_error($des));
}

// Формируем массив с результатами
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Возвращаем результат в формате JSON
echo json_encode($products);
