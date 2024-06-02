$(document).ready(function () {
  $(document).on("click", ".buy", function () {
    const product_id = $(this).data("id");
    console.log(product_id);

    const form_data = $("form[data-id=" + product_id + "]").serialize();
    $.ajax({
      type: "POST",
      url: "./update_cart.php",
      data: form_data,
      success: function (data) {
        console.log(data);

        products = JSON.parse(data);
        console.log(products);

        $(".products").html("");

        products.products.forEach(function (product) {
          const a = `
                    <div class="product">
                <div class="character">
                    
                    <div>
                        ${product.creator}
                    </div>
                        <div>        
                            <div>${product.name}</div>
                            <div>${product.price}руб</div>
                        </div>
                    </div>
                    <img src="${product.url}">
                    <div class="plus">
                        <form class="removes" data-id="${product.id}">
                            <div>Количество : ${product.count} </div>
                            <span>⠀</span>
                            <input type="number" name="count" value="${
                              product.count
                            }">
                            <input type="hidden" name="prod_id" value="${
                              product.id
                            }">
                            <input class="buy" type="button" value=" Задать определенное количество" data-id="${
                              product.id
                            }">
                            <span>⠀</span>
                            <span>Общая сумма: ${
                              product.price * product.count
                            }</span>
                            <span>⠀</span>
                        </form>
        
                        <span>
                            <a href="?buy_prod_id=66&amp;count=5">Купить</a>
                            <span>⠀</span>
                            <span>⠀</span>
                            <span>⠀</span>
                            <a href="?del_prod_id=66">Удалить</a>
                        </span>
                    </div>
                    </div>
                `;

          $(".products").append(a); // Добавляем HTML блок продукта к элементу с классом "products"
        });
      },
    });
  });
});