<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    session_start();
    $_SESSION['page'] = "login";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>login</title>
</head>

<body>
    <div class="center-component">
        <form id="loginForm">
            <div id="error-message" style="display:none; color:red;"></div>
            <div id="register-fields" style="display:none;">
                <span>Имя</span>
                <input type="text" id="fullname" name="fullname">
            </div>
            <div>
                <span>Логин</span>
                <input type="text" name="login" required>
            </div>
            <div>
                <span>Пароль</span>
                <input type="password" name="password" required>
            </div>
            <div>
                <button type="submit">Войти</button>
            </div>
            <div id="register-link">
                <div id="toggle-register">Вы здесь в первый раз?</div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>
</body>

</html>