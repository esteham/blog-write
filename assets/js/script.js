jQuery(document).ready(function ($) {
  // Frontend form validation
  $(".blog-write-form").on("submit", function (e) {
    var valid = true;
    var firstError = null;

    $(this)
      .find("[required]")
      .each(function () {
        if (!$(this).val()) {
          valid = false;
          $(this).addClass("error");
          if (!firstError) {
            firstError = this;
          }
        } else {
          $(this).removeClass("error");
        }
      });

    if (!valid) {
      e.preventDefault();
      alert("Please fill in all required fields.");
      if (firstError) {
        $(firstError).focus();
      }
    }
  });

  // Remove error class when user starts typing
  $(".blog-write-form [required]").on("input", function () {
    if ($(this).val()) {
      $(this).removeClass("error");
    }
  });
});
