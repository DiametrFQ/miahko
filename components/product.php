<style>
    img {
        width: 200px;
        height: 200px;
        margin: auto;
    }

    .products {
        margin: auto;
        position: relative;
        display: flex;
        flex-flow: row wrap;
        width: 90%;
        justify-content: center;
    }

    .product {
        --indentation: 20px;

        display: grid;
        grid-template-columns: 200px 200px;

        margin: calc(var(--indentation) /2);
        padding: var(--indentation);

        min-width: calc(440px - var(--indentation)*2);
        max-width: 100%;

        border: solid black 1px;
        border-radius: 12px;

        background-color: var(--main-color);
    }

    .product>.character {
        font-size: 20px;
        padding: auto;
        padding-right: 20px;

        display: grid;
        text-align: left;
        align-items: center;
        grid-template-rows: 20px 1fr;
    }

    .product>.character>div>div {
        margin-bottom: 20px;
    }

    .product>.character>input[type='checkbox'] {
        width: 14px;
        height: 14px;
    }

    .plus>form {
        display: flex;
        flex-direction: column;
        flex: 130px;
        margin: 20px
    }
</style>

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
        $plus = "<div><a href='./pages/basket/?product_id=$product_info[id]'> Купить </a> </div>";
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
                <form action='./' method=GET>
                    <div>Количество : $num </div>
                    <span>⠀</span>
                    <input type=number name=count value=$num>
                    <input type=hidden name=prod_id value=$product_info[id] value=$num>
                    <button type=submit> Задать определенное количество</button>
                    <span>⠀</span>
                    <span>Общая сумма: $summ</span>
                    <span>⠀</span>

                    <span>
                        <a href=?buy_prod_id=$product_info[id]&count=$product_info[count]>Купить</a>
                        <span>⠀</span>
                        <span>⠀</span>
                        <span>⠀</span>
                        <a href=?del_prod_id=$product_info[id]>Удалить</a>
                    </span>
                </form>
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
