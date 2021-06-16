<div class="" style="width:100%">
    <div class="dokan-panel dokan-panel-default">
        <div class="dokan-panel-heading"><strong><?php echo esc_html__( 'Customer Product Purchase Status', 'customer-total-purchase' ); ?></strong></div>
        <div class="dokan-panel-body general-details">
            <ul class="list-unstyled order-status">
                <?php if ( $data >= 10000  ) { ?>
                    <li>
                        <span><?php echo __( 'Total Purchase :', 'customer-total-purchase' ) . $data ?></span>
                        <br>
                        <label class="dokan-label dokan-label-success"><?php echo esc_html__( 'Dimmond', 'customer-total-purchase' ); ?></label>
                    </li>
                <?php } elseif ( $data > 5000 && $data < 10000 ) { ?>
                    <li>
                        <span><?php echo __( 'Total Purchase :', 'customer-total-purchase' ) . $data; ?></span>
                        <br>
                        <label class="dokan-label dokan-label-success"><?php echo esc_html__( 'Gold', 'customer-total-purchase' ); ?></label>
                    </li>
                <?php } elseif ( $data > 1000 && $data < 5000 ) { ?>
                    <li>
                        <span><?php echo __( 'Total Purchase :', 'customer-total-purchase' ) . $data; ?></span>
                        <br>
                        <label class="dokan-label dokan-label-success"><?php echo esc_html__( 'Silver', 'customer-total-purchase' ); ?></label>
                    </li>
                <?php }  ?>
            </ul>                                                    
        </div>
    </div>
</div>