<style>
    body>header {
        z-index: 100000;
        font-size: 26px;
        position: fixed;
        width: 100%;
        top: 0;
        display: flex;
        justify-content: space-between;
        background-color: var(--main-color);
    }

    body>header>span {
        padding: 0 var(--border-distance);
    }

    .market-name {
        font-family: 'Pacifico', cursive;
    }

    footer {
        font-size: 20px;
        position: fixed;
        bottom: 0;
        width: 100%;

        text-align: center;
        background-color: var(--main-color);
    }
</style>

<?php

function create_header($name)
{

    if ($name == "") {
        $name  = "Войти";
    }
    $product = "            
        <header>
            <span class=market-name>
                Мяхко
            </span>
            <span>
                <a href=/pages/login>
                    $name
                </a>
            </span>
        </header>
    ";

    return $product;
}

function create_footer()
{
    $product = "            
        <footer>Все права защищены 2023</footer>
    ";

    return $product;
}
