;(function ($){

    $('#woo-coupon-form').submit(function(e){
		e.preventDefault()

		var $form = $(this);
		var $data = $form.serialize();

		$.ajax({
			url: WOOF.ajaxurl,
			data: $data,
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				$('.woof-response-message').html( resp.message )
				$('.woof-notice').show()
				if( resp.status == 1 ) {
					$("#woo-coupon-form")[0].reset();
				}
			}
		})
	})

    $('#coupon-conversion-form').submit(function(e){
		e.preventDefault()

		var $form = $(this);
		var $data = $form.serialize();

		$.ajax({
			url: WOOF.ajaxurl,
			data: $data,
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				$('.woof-response-message').html( resp.message )
				$('.woof-notice').show()
				if( resp.status == 1 ) {
					$("#coupon-conversion-form")[0].reset();
					location.reload()
				}
			}
		})
	})
	
})(jQuery);
