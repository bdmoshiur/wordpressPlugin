;(function ($){
    let output = $("#output");
    $('#Ajax-myForm form').on('submit',function(e){
        e.preventDefault();
        let self = $(this);
        var data = self.serialize();

        $.post(obj.ajax_url, data)
        .done(function (message){
            output.html(message.data.message);
            self.trigger("reset");
        }).fail(function (error){
           alert(JSON.stringify(error));
        });
    });
})(jQuery);

$(function () {
        $('#myForm').validate({
            rules: {
                fname : {
                    required: true,
                },
                lname : {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                },
            },

            messages: {


            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
