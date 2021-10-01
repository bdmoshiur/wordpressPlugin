<?php 
	$conversions = woo_coupon_conversion();
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Coupon Conversion', 'woo-referral' ); ?></h1>
	<div class="woof-notice notice notice-success" style="display: none;">
        <p class="woof-response-message"></p>
    </div>
    
	<div id="coupon-conversion-area">
		<form class="form-table" action="" id="coupon-conversion-form">
			<input type="hidden" name="action" value="coupon-conversion">
        	<?php wp_nonce_field( 'woo-referral' ); ?>

        	<p>
				<label for="amount"><?php echo esc_html__( 'Amount', 'woo-referral' ) ?></label>
				<input class="regular-text" type="number" id="amount" name="amount" required>
			</p>

        	<p>
				<label for="point"><?php echo esc_html__( 'Point', 'woo-referral' ) ?></label>
				<input class="regular-text" type="number" id="point" name="point" required>
			</p>

        	<p>
				<label for="expiry_date"><?php echo esc_html__( 'Expiry Date', 'woo-referral' ) ?></label>
				<input class="regular-text" type="date" id="expiry_date" name="expiry_date">
			</p>

			<input type="submit" value="<?php echo esc_html__( 'Add', 'woo-referral' ) ?>">
		</form>
	</div>

	<?php if ( ! empty( $conversions ) ) { ?>
		<div id="coupon-conversion-table">
			<table>
				<thead>
					<tr>
						<th><?php echo esc_html__( 'No', 'woo-referral' ); ?></th>
						<th><?php echo esc_html__( 'Amount', 'woo-referral' ); ?></th>
						<th><?php echo esc_html__( 'Point', 'woo-referral' ); ?></th>
						<th><?php echo esc_html__( 'Expiry Date', 'woo-referral' ); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ( $conversions as $conversion ) { ?>
						<tr>
							<td><?php echo esc_html( $conversion->id ) ?></td>
							<td><?php echo esc_html( $conversion->amount ) ?></td>
							<td><?php echo esc_html( $conversion->point ) ?></td>
							<td><?php
								
								if ( $conversion->expiry_date ) {
									echo esc_html( $conversion->expiry_date ); 
								} else { 
									echo 'Lifetime';
								} 

								?></td>
					    </tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	<?php } ?>
</div>