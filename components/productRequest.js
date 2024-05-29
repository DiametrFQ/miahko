// <?php

// function create_product($product_info, $num, $role)
// {
//     if ($role == "admin") {
//         $numHTML = "
//             <div>
//                 $num <input type=checkbox name=delete_id[] value=$product_info[id] />
//             </div>
//         ";
//         $plus =
//             "<div>
//             <div class=delete data-id=$product_info[id]'>Удалить</div>
//             <div class=edit data-id=$product_info[id]'>Изменить</div>
//         </div>";
//         $character = "
//             <div>Имя: $product_info[name] </div>
//             <div>Цена: $product_info[price]руб</div>
//         ";
//     }
//     if ($role === "user") {
//         $numHTML = "
//             <div>
//                 $product_info[creator]
//             </div>
//         ";
//         $character = "
//             <div>$product_info[name]</div>
//             <div>$product_info[price]руб</div>
//         ";
//         $plus = "<div class=plus data-id=$product_info[id]'> Купить </div>";
//     }
//     if ($role === "basket") {
//         $numHTML = "
//             <div>
//                 $product_info[creator]
//             </div>
//         ";

//         $character = "
//             <div>$product_info[name]</div>
//             <div>$product_info[price]руб</div>
//         ";
//         $summ = $product_info['price'] * $product_info['count'];
//         $plus =
//             "<div class=plus>
//                 <form class='removes'>
//                     <div>Количество : $num </div>
//                     <span>⠀</span>
//                     <input type=number name=count value=$num>
//                     <input type=hidden name=prod_id value=$product_info[id] value=$num>
//                     <button class='buy'> Задать определенное количество</button>
//                     <span>⠀</span>
//                     <span>Общая сумма: $summ</span>
//                     <span>⠀</span>
//                 </form>

//                 <span>
//                     <a href=?buy_prod_id=$product_info[id]&count=$product_info[count]>Купить</a>
//                     <span>⠀</span>
//                     <span>⠀</span>
//                     <span>⠀</span>
//                     <a href=?del_prod_id=$product_info[id]>Удалить</a>
//                 </span>
//             </div>";
//     }

//     $product = "
//         <div class='product'>
//             <div class='character'>
//                 $numHTML
//                 <div>
//                     $character
//                 </div>
//             </div>
//             <img src=$product_info[url]></img>
//             $plus
//         </div>
//     ";

//     return $product;
// }

const create_product_ajax = (role) => {
    console.log(1);
  if (role === "admin") {
    $(".delete").on("click", function () {
      let id = $(this).data("id");
      $.ajax({
        url: "deleteProduct.php",
        type: "POST",
        data: { id },
        success: function (data) {
          console.log(data);
        },
      });
    });

    $(".edit").on("click", function () {
      let id = $(this).data("id");
      $.ajax({
        url: "editProduct.php",
        type: "POST",
        data: { id },
        success: function (data) {
          console.log(data);
        },
      });
    });
  } else if (role === "user") {
    $(".plus").on("click", function () {
      console.log(1);
      let id = $(this).data("id");
      $.ajax({
        url: "buyProduct.php",
        type: "POST",
        data: { id },
        success: function (data) {
          console.log(data);
        },
      });
    });
  } else if (role === "basket") {
    $(".buy").on("click", function () {
      $.ajax({
        url: "buyProduct.php",
        type: "POST",
        data: $(".removes").serialize(),
        success: function (data) {
          console.log(data);
        },
      });
    });
  }
};
