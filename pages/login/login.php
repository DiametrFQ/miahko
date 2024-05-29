<?php
include "../../components/db-connect.php";
session_start();

$login = $_POST['login'];
$password = $_POST['password'];

if (!empty($login) && !empty($password)) {
    $query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($des, $query);
    $user = mysqli_fetch_array($result);

    

    if ($user) {
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["user_login"] = $user['login'];

        if ($user["role"] == "admin") {
            $_SESSION["admin"] = true;
            echo json_encode(['success' => true, 'redirect' => '../admin-panel/index.php']);
        } else {
            $_SESSION["admin"] = false;
            echo json_encode(['success' => true, 'redirect' => '../../index.php']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Неправильный логин или пароль.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
}
