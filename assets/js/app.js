function showAlert(res) {
  $alert = $("#alert");
  $alert.attr("class", "alert alert-" + res.status + " alert-dismissible");
  $alert.removeClass("hidden");
  $("#alert_content").html(res.message);
}

$(document).ready(function() {
  $("#form").on("submit", function(e) {
    $("#load").button("loading");
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: "Controller.php",
      type: "post",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(res) {
        $("#load").button("reset");
        console.log(res);
        var result = JSON.parse(res);
        showAlert(result);
      }
    });
  });

  $(".delete").on("click", function(e) {
    e.preventDefault();
    if (confirm("Are you sure to delete?")) {
      window.location.href = this.href;
    }
  });

  // Login & Register
  $("#login-form, #register-form").on("submit", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      url: "Controller.php",
      type: "post",
      data: formData,
      success: function(res) {
        var data = JSON.parse(res);
        showAlert(data);
        if (data.status === "success") {
          setTimeout(() => {
            window.location.href = "index.php";
          }, 1000);
        }
      }
    });
  });
});
