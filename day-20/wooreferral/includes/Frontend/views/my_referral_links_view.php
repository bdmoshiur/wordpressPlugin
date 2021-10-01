<div id="coupon-conversion-table">
    <?php
        $available_points = 0;
        foreach($referrals as $coupon) {
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
                <th><?php echo esc_html__( 'Event Name', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Coupon Code', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Amount($)', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Coupon Point(pts)', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Expiry Date', 'woo-referral' ); ?></th>
                <th><?php echo esc_html__( 'Ref Link', 'woo-referral' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ( $referrals as $referral ) {
                $ccode = $referral->post_title;
                $ename   = get_post_meta( $referral->ID, 'ename', true );
                $camount = get_post_meta( $referral->ID, 'coupon_amount', true );
                $cpoint  = get_post_meta( $referral->ID, 'cpoint', true );
                $edate   = get_post_meta( $referral->ID, 'date_expires', true );

                $ref_url = add_query_arg( [ 'user_id' => get_current_user_id(), 'coupon' => $ccode ], $home_url );
                echo "<tr>
                    <td>{$ename}</td>
                    <td>{$ccode}</td>
                    <td>{$camount}</td>
                    <td>{$cpoint}</td>
                    <td>{$edate}</td>
                    <td>
                        <div class='woo-copy-ref-panel'>
                            <input type='text' class='woo-copy-ref' value='{$ref_url}' readonly>
                            <button id='woo-copy-ref-btn'>Copy</button>
                        </div>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>