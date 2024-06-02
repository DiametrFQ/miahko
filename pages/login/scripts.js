$(document).ready(() => {
  $("#toggle-register").click((e) => {
    e.preventDefault();
    if ($("#register-fields").is(":visible")) {
      $("#register-fields").hide();
      $("#fullname").prop("required", false);
      $("#toggle-register").text("Вы здесь в первый раз?");
    } else {
      $("#register-fields").show();
      $("#fullname").prop("required", true);
      $("#toggle-register").text("Вы уже смешарик?");
    }
  });

  $("#loginForm").submit(function (e) {
    console.log("submit");
    e.preventDefault();
    let formData = $(this).serialize();
    let actionUrl = $("#register-fields").is(":visible")
      ? "./register.php"
      : "./login.php";

    $.ajax({
      url: actionUrl,
      method: "POST",
      data: formData,
      success: function (response) {
        console.log(response);

        response = JSON.parse(response);
        console.log(response);
        if (response.success === true) {
          window.location.href = response.redirect;
        } else {
          $("#error-message").text(response.message).show();
        }
      },
      error: () => {
        console.log("error");
        $("#error-message").text("Произошла ошибка. Попробуйте снова.").show();
      },
    });
  });

  $("#register-link a").click((e) => {
    e.preventDefault();
    $("#loginForm").submit();
  });
});
