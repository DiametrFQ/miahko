$(".plus").on("click", function () {
  let id = $(this).data("id");
  $.ajax({
    url: "./add_to_basket.php",
    type: "POST",
    data: {
      id,
    },
    success: function (data) {
      console.log(data);
      data = JSON.parse(data);
      console.log(data.success);
      if (data.success) {
        window.location.href = "pages/basket/index.php";
      }
    },
  });
});

$(document).ready(function () {
  function updateData(formData, url) {
    console.log(formData);
    $.ajax({
      type: "POST",
      url: url,
      data: formData,
      dataType: "json", // Указываем, что ожидаем JSON ответ
      success: function (response) {
        console.log(response);

        $(".products").html(""); // Очищаем содержимое элемента
        response.forEach(function (product) {
          const a = `
                    <form class="product">
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
                        <button type="submit" id="buy" -data-id="${product.id}"> Купить </div> 
                    </form>`;
          $(".products").append(a);
        });
      },
      error: (xhr, status, error) => {
        console.error(xhr.responseText);
      },
    });
  }

  $("#searchBtn").click(function (e) {
    e.preventDefault();
    var formData =
      $("#settingsForm").serialize() + "&" + $("#searchForm").serialize();
    updateData(formData, "./update_products.php");
  });

  $("#searchForm").submit(function (e) {
    e.preventDefault();
    var formData =
      $("#settingsForm").serialize() + "&" + $("#searchForm").serialize();
    updateData(formData, "./update_products.php");
  });
});
