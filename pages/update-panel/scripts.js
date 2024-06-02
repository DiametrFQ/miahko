const createProduct = (product) => {
  let numHTML = `<div> ${product["creator"]} </div> `;

  let plus = ` <button class=plus data-id='${product["id"]}'> Купить </button>`;

  let character = `
      <div>Имя: ${product["name"]} </div>
      <div>Цена: ${product["price"]}руб</div>
  `;

  let productHTML = `
      <div class='product'>
          <div class='character'>
              ${numHTML}
              <div>
                  ${character}
              </div>
          </div>
          <img src=${product["url"]}></img>
          ${plus} 
      </div>
  `;
  return productHTML;
};

$(document).ready(function () {
  // Функция для проверки заполненности всех полей
  function checkFormFields() {
    let allFilled = true;
    $("#updateForm input, #updateForm textarea").each(function () {
      if ($(this).val() === "") {
        allFilled = false;
      }
    });

    if (allFilled) {
      $("#submitBtn").show();
      $("#error_message").hide();
    } else {
      $("#submitBtn").hide();
      $("#error_message").show();
    }
  }

  // Проверяем поля при загрузке страницы
  checkFormFields();

  // Проверяем поля при изменении значений
  $("#updateForm input, #updateForm textarea").on("input", function () {
    checkFormFields();
  });

  // AJAX для отправки формы
  $("#updateForm").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "update_product.php",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          const newProduct = createProduct(response.updated_product);

          $(".popup-left").html($(".center-component").html());

          $("#success_message").show().delay(3000).fadeOut();
          // Обновляем информацию о продукте
          $(".center-component").first().html(newProduct);

          // Запускаем попапы
          $(".popup-right").css("right", "0px");
          $(".popup-left").css("left", "0px");

          $(".popup-right").html(newProduct);

          setTimeout(function () {
            $(".popup-right").css("right", "-700px");
            $(".popup-left").css("left", "-500px");
          }, 4000);
        }
      },
    });
  });
});
