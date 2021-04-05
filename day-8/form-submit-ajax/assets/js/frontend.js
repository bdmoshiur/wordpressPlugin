;(function ($){
    $('#from_shortcode_ajax form').on('submit',function(e){
        e.preventDefault();

        var data = $(this).serialize();

        $.post(obj.ajax_url, data).done(function (message){
            alert(JSON.stringify(message));
        }).fail(function (error){
           alert(JSON.stringify(error));
        });
    });
})(jQuery);