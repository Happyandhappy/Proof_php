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
});

function showAlert(res) {
  $alert = $("#alert");
  $alert.attr("class", "alert alert-" + res.status + " alert-dismissible");
  $alert.removeClass("hidden");
  $("#alert_content").html(res.message);
}
