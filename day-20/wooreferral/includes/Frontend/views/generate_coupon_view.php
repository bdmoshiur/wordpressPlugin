<div id="coupon-conversion-table">
    <?php
        $available_points = 0;
        foreach($coupon_codes as $coupon) {
            $cpoint =  get_post_meta( $coupon->ID, 'cpoint', true );
            $available_points += (int)$cpoint;
        }
    ?>
    <div style="float: right;">
        <h4><?php echo esc_html__( 'Available Point: ', 'woo-referral' ) ?><?php echo $available_points; ?></h4>
    </div>
    <table>
        <thead>
            <tr>
                <th><?php echo esc_html__( 'No', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Amount', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Point', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Expiry Date', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Buy', 'woo-referral' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;

            foreach ( $conversions as $conversion ) {
                echo "<tr>
                    <td>{$count}</td>
                    <td>{$conversion->amount}</td>
                    <td>{$conversion->point}</td>
                    <td>{$conversion->expiry_date}</td>
                    <td><button id='woo-generate-coupon-btn' data-amount='{$conversion->amount}' data-point='{$conversion->point}' data-expiry_date='{$conversion->expiry_date}'>Buy</button></td>
                </tr>";
                $count++; 
            }
            
            ?>
        </tbody>
    </table>
</div>

<div id="coupon-conversion-table">
    <fieldset>
        <legend>Information</legend>
        <table>
            <thead>
                <tr>
                    <th><?php echo esc_html__( 'No', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Amount', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Point', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Code', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Puechase Date', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Expiry Date', 'woo-referral' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
                foreach ( $generate_coupons as $generate_coupon ) {
                    $purchase_date = date( get_option( 'date_format' ), strtotime($generate_coupon->purchase_date) );
                    echo "<tr>
                        <td>{$count}</td>
                        <td>{$generate_coupon->amount}</td>
                        <td>{$generate_coupon->point}</td>
                        <td>{$generate_coupon->coupon_code}</td>
                        <td>{$purchase_date}</td>
                        <td>{$generate_coupon->expiry_date}</td>
                    </tr>";
                    $count++;
                } 
                ?>
            </tbody>
        </table>
    </fieldset>
</div>