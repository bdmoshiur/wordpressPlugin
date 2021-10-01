;(function ($){
    $(document).on( 'click', '#woo-copy-ref-btn', function(e) {
    	$('#woo-copy-ref-btn').text( 'Copy' );

    	$('.woo-copy-ref', $(this).closest( '.woo-copy-ref-panel' ) ).select();
		document.execCommand("copy");


		$('#woo-copy-ref-btn', $(this).closest( '.woo-copy-ref-panel' ) ).text( 'Copied' );
    } )

    $(document).on("click","#woo-generate-coupon-btn",function(e){
		e.preventDefault()
		
		var amount 		= $(this).data('amount');
		var point 		= $(this).data('point');
		var expiry_date = $(this).data('expiry_date');


		$.ajax({
			url: WOOF.ajaxurl,
			data: { 'action':'coupon-generate', 'amount' : amount, 'point' : point, 'expiry_date' : expiry_date, 'nonce' : WOOF.nonce },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				if ( resp.status == 1 ) {
					location.reload()
				}
			}
		});
	})
})(jQuery);