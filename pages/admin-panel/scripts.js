const createProduct = (data) =>
  data.map((product, i) => {
    let numHTML = `
            <div>
                ${i + 1} <input type=checkbox name=delete_id value=${
      product["id"]
    } />
            </div>
        `;
    let plus = `
            <div>
                <button type="button" class="delete-product-btn" data-id=${product["id"]}>Удалить</button>
                <a href='../update-panel/index.php?update_id=${product["id"]}'>Изменить</a>
            </div>`;
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
  });

$(document).ready(function () {
  function loadProducts() {
    $.ajax({
      url: "./load_products.php",
      method: "GET",
      success: function (data) {
        data = JSON.parse(data);
        $(".products").html(createProduct(data));
      },
    });
  }

  function loadCreators() {
    $.ajax({
      url: "./load_creators.php",
      method: "GET",
      success: (data) => {
        data = JSON.parse(data);
        console.log("creators", data);
        console.log(data);
        $('select[name="filt_creator"]').html(
          data.map((product) => {
            return `<option value="${product}">${product}</option>`;
          })
        );
      },
    });
  }

  $("#filter-price,#filter-product").on("submit", function (e) {
    e.preventDefault();
    console.log(
      $("#filter-product").serialize() + "&" + $("#filter-price").serialize()
    );
    $.ajax({
      url: "./filter_products.php",
      method: "GET",
      data:
        $("#filter-product").serialize() + "&" + $("#filter-price").serialize(),
      success: function (data) {
        console.log(data);
        data = JSON.parse(data);
        $(".products").html(createProduct(data));
      },
    });
  });

  $("#create-product").on("submit", function (e) {
    e.preventDefault();
    console.log($(this).serialize());
    $.ajax({
      url: "./create_product.php",
      method: "POST",
      data: $(this).serialize(),
      success: function (data) {
        console.log(data);
        loadProducts();
      },
    });
  });

  $(".delete-products").on("submit", function (e) {
    e.preventDefault();
    let productsId = Array.from($("input[type=checkbox]"))
      .filter((chbx) => chbx.checked)
      .map((chbx) => chbx.value);

    console.log(productsId);
    if (!productsId.length) {
      const ans = confirm("Вы уверенны что хотите удалить все элементы?");
      if (!ans) return;
    }

    $.ajax({
      url: "./delete_products.php",
      method: "POST",
      data: {
        products_id: productsId,
      },
      success: function (data) {
        console.log(data);
        loadProducts();
      },
    });
  });

  $(".products").on("click", ".delete-product-btn", function (e) {
    e.preventDefault();
    console.log(this, `--data-id=${$(this).data("id")}`);
    const productId = $(this).data("id");
    $.ajax({
      url: "./delete_products.php",
      method: "POST",
      data: {
        product_id: productId,
      },
      success: function (data) {
        loadProducts();
      },
    });
  });

  $("#sort-asc").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      url: "./sort_products.php",
      method: "GET",
      data: {
        order: "asc",
      },
      success: function (data) {
        $(".products").html(data);
      },
    });
  });

  $("#sort-desc").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      url: "./sort_products.php",
      method: "GET",
      data: {
        order: "desc",
      },
      success: function (data) {
        $(".products").html(data);
      },
    });
  });

  loadProducts();
  loadCreators();
});
