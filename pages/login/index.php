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
    <script>
        $(document).ready(() => {
            $('#toggle-register').click((e) => {
                e.preventDefault();
                if ($('#register-fields').is(':visible')) {
                    $('#register-fields').hide();
                    $('#fullname').prop('required', false);
                    $('#toggle-register').text('Вы здесь в первый раз?');
                } else {
                    $('#register-fields').show();
                    $('#fullname').prop('required', true);
                    $('#toggle-register').text('Вы уже смешарик?');
                }
            });

            $('#loginForm').submit(function(e) {
                console.log('submit');
                e.preventDefault();
                let formData = $(this).serialize();
                let actionUrl = $('#register-fields').is(':visible') ? './register.php' : './login.php';

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);

                        response = JSON.parse(response);
                        console.log(response);
                        if (response.success === true) {
                            window.location.href = response.redirect;
                        } else {
                            $('#error-message').text(response.message).show();
                        }
                    },
                    error: () => {
                        console.log('error');
                        $('#error-message').text('Произошла ошибка. Попробуйте снова.').show();
                    }
                });
            });

            $('#register-link a').click((e) => {
                e.preventDefault();
                $('#loginForm').submit();
            });
        });
    </script>
</body>

</html>