<div id="coupon-conversion-table">
    <fieldset>
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
        <legend>Logs Tracks</legend>
        <table>
            <thead>
                <tr>
                    <th><?php echo esc_html__( 'Event Name', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Coupon Code', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Referred To', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Points', 'woo-referral' ); ?></th>
                    <th><?php echo esc_html__( 'Type', 'woo-referral' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ( $transitions as $transition ) {
                    $user_info = get_userdata( get_current_user_id() );
                    $user_name = $user_info->display_name;
                    echo "<tr>
                        <td>{$transition->event_name}</td>
                        <td>{$transition->coupon_code}</td>
                        <td>{$user_name}</td>
                        <td>{$transition->point}</td>
                        <td>{$transition->type}</td> 
                    </tr>";
                }

                ?>
            </tbody>
        </table>
    </fieldset>
</div>