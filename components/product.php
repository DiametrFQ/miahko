<?php

function create_product($product_info, $num, $role)
{
    if ($role == "admin") {
        $numHTML = "
            <div>
                $num <input type=checkbox name=delete_id[] value=$product_info[id] />
            </div>
        ";
        $plus =
            "<div>
            <a href='?delete_id[]=$product_info[id]'>Удалить</a>
            <a href='../update-panel/index.php?update_id=$product_info[id]'>Изменить</a>
        </div>";
        $character = "
            <div>Имя: $product_info[name] </div>
            <div>Цена: $product_info[price]руб</div>
        ";
    }
    if ($role === "user") {
        $numHTML = "
            <div>
                $product_info[creator]
            </div>
        ";
        $character = "
            <div>$product_info[name]</div>
            <div>$product_info[price]руб</div>
        ";
        $plus = "<button class=plus data-id='$product_info[id]'> Купить </button>";
    }
    if ($role === "basket") {
        $numHTML = "
            <div>
                $product_info[creator]
            </div>
        ";

        $character = "
            <div>$product_info[name]</div>
            <div>$product_info[price]руб</div>
        ";
        $summ = $product_info['price'] * $product_info['count'];
        $plus =
            "<div class=plus>
                <form class='removes' data-id=$product_info[id]>
                    <div>Количество : $num </div>
                    <span>⠀</span>
                    <input type=number name=count value=$num>
                    <input type=hidden name=prod_id value=$product_info[id] value=$num>
                    <input class='buy' type='button' value='Задать определенное количество' data-id=$product_info[id] >
                    <span>⠀</span>
                    <span>Общая сумма: $summ</span>
                    <span>⠀</span>
                </form>

                <span>
                    <a href=?buy_prod_id=$product_info[id]&count=$product_info[count]>Купить</a>
                    <span>⠀</span>
                    <span>⠀</span>
                    <span>⠀</span>
                    <button class=removes data-id=$product_info[id]>Удалить</button>
                </span>
            </div>";
    }

    $product = "
        <div class='product'>
            <div class='character'>
                $numHTML
                <div>
                    $character
                </div>
            </div>
            <img src=$product_info[url]></img>
            $plus
        </div>
    ";

    return $product;
}
