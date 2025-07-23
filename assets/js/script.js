jQuery(document).ready(function ($) {
  // Frontend form validation
  $(".blog-write-form").on("submit", function (e) {
    var valid = true;

    $(this)
      .find("[required]")
      .each(function () {
        if (!$(this).val()) {
          valid = false;
          $(this).addClass("error");
        } else {
          $(this).removeClass("error");
        }
      });

    if (!valid) {
      e.preventDefault();
      alert("Please fill in all required fields.");
    }
  });
});
