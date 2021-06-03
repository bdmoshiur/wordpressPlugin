;(function($) {

    $(document).ready(function() {
        // Rating Options
        var options = {
            max_value: 5,
            step_size: 0.3,
            cursor: 'pointer',
        }
        // Activate book review rating plugin
        $(".rating").rate(options);

        // Book review rating ajax handler
        $(".book-rating").on("click", function (e) {
            let userData = {
                _ajax_nonce: objRating.nonce,
                action:      objRating.action,
                post_id:     $(this).attr("data-post-id"),
                rating:      $(this).attr("data-rate-value"),
                rating_id:   $(this).attr("data-rating-id"),
            }

            // Book review ajax request handler
            $.post(objRating.ajaxurl, userData, function (response) {
                if(true === response.success) {
                    $(".book-rating").attr("data-rating-id", response.data.rating_id);
                    $(".rating-status").removeClass("status-error").addClass("status-success");
                } else {
                    $(".rating-status").removeClass("status-success").addClass("status-error");
                }
                $(".rating-status").html(response.data.message);
            })
            .fail(function () {
                alert(objRating.error);
            });
        });
    });

})(jQuery);
