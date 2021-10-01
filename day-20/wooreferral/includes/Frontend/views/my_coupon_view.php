<div class="woo-my-coupons-panel">
    <div id="woo-coupons-content-panel">
        <?php
        $available_points = 0;
        foreach($coupon_codes as $coupon) {
            $cpoint =  get_post_meta( $coupon->ID, 'cpoint', true );
            $available_points += (int)$cpoint;

            $ccode = $coupon->post_title;
            $description = $coupon->post_excerpt;
            $camount = get_post_meta( $coupon->ID, 'coupon_amount', true );
            $edate   = get_post_meta( $coupon->ID, 'date_expires', true );

            $html = '';
            echo $html = "<div class='woo-single-coupon-content'>
                <p>Coupon Code : {$ccode}</p>
                <p>Coupon Description : {$description}</p>
                <p>Coupon Value : {$camount}</p>
                <p>Expiry Date : {$edate}</p>
            </div>";

        }

        ?>
    </div>
    <div>
        <h4><?php echo esc_html__( 'Available Point: ', 'woo-referral' ) ?><?php echo $available_points; ?></h4>
    </div>
</div>