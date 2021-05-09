;(function ($) {
  $(document).ready(function () {
    let save_button = $("#mrm_save");

    $("#mrm_dashboard_form").on("submit", function (e) {
      e.preventDefault();
      save_button.prop("disabled", true);

      let data = $(this).serialize();
  
      $.post(mrmobj.ajax_url, {
        action: "dashboard_form_handle",
        nonce: mrmobj.nonce,
        data: data,
      })
        .done(function (response) {
          save_button.prop("disabled", false);
          location.reload();
        })
        .fail(function (error) {
          console.log(error);
        });
    });
  });
})(jQuery);
