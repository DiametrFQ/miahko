<?php
include "../../components/db-connect.php";
session_start();

$fullname = $_POST['fullname'];
$login = $_POST['login'];
$password = $_POST['password'];

if (!empty($fullname) && !empty($login) && !empty($password)) {
    $querySelect = "INSERT INTO `users` (`id`, `role`, `fullname`, `login`, `password`) VALUES (NULL, 'user', '$fullname', '$login', '$password')";

    $rez = mysqli_query($des, "SELECT * FROM products $query $p");
    $mas = mysqli_fetch_array($rez);
    echo $mas;

    $query = "INSERT INTO `users` (`id`, `role`, `fullname`, `login`, `password`) VALUES (NULL, 'user', '$fullname', '$login', '$password')";
    if (mysqli_query($des, $query)) {
        echo json_encode(['success' => true, 'redirect' => 'index.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
}
