<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include "../../components/db-connect.php";
    include "../../components/global-css-settings.php";
    session_start();
    $_SESSION['page'] = "login";

    if ($_REQUEST['fullname'] != "") {
        $fullname = $_REQUEST['fullname'];
    }
    if ($_REQUEST['login'] != "") {
        $login = $_REQUEST['login'];
    }
    if ($_REQUEST['password'] != "") {
        $password = $_REQUEST['password'];
    }

    if ($fullname != "" and $login != ""  and $password != "") {
        $Q =
            "INSERT INTO `users` 
            (`id`, `role`, `fullname`, `login`, `password`) 
            VALUES (NULL, 'user', '$fullname', '$login', '$password')";

        mysqli_query($des, $Q);
    }

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>login</title>
</head>

<body>
    <div class="center-component">
        <?php
        if ($_REQUEST['reg'] == "true") {
            echo "<form id=login action=? method=GET>";
        } else {
            echo "<form id=login action=../admin-panel/index.php method=POST>";
        }

        ?>
        <form id="login" action="../admin-panel/index.php" method="POST">

            <?php
            if ($_REQUEST['select_user'] == "false") {
                echo "<div>";
                echo "  <span class='Error'>";
                echo "      Вы не правильно ввели логин или пароль";
                echo "  </span>";
                echo "</div>";
            };
            ?>
            <?php
            if ($_REQUEST['reg'] == "true") {
                echo "<div>";
                echo "  <span> Имя </span>";
                echo "  <input type=text name=fullname required>";
                echo "</div>";
            }
            ?>
            <div>
                <span>Логин</span>
                <input type="text" name="login" required>
            </div>
            <div>
                <span>Пароль</span>
                <input type="password" name="password" required>
            </div>
            <div>
                <button type="submit">
                    Войти
                </button>
            </div>
            <?php
            if ($_REQUEST['reg'] == "true") {
                echo "<a href=?>
                    Вы уже смешарик?
                </a>";
            } else {

                echo "<a href='?reg=true'>
                    Вы здесь в первый раз?
                </a>";
            }
            ?>
        </form>
    </div>
</body>

</html>