<div class="wrap">
    <h1><?php echo esc_html__( 'Add General Referral Rules', 'woo-referral' ); ?></h1>

    <div class="woof-notice notice notice-success" style="display: none;">
        <p class="woof-response-message"></p>
    </div>
    <form id="woo-coupon-form"> 
        
        <input type="hidden" name="action" value="coupon-create">
        <?php wp_nonce_field( 'woo-referral' ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="ename"><?php echo esc_html__( 'Event Name', 'woo-referral' ); ?> * </label>
                    </th>
                    <td>
                        <input type="text" name="ename" id="ename" class="regular-text" required>
                        <a data-toggle="tooltip" title="Please give a event name">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ccode"><?php echo esc_html__( 'Coupon Code', 'woo-referral' ); ?> * </label>
                    </th>
                    <td>
                        <input type="text" name="ccode" id="ccode" class="regular-text" required>
                        <a data-toggle="tooltip" title="Please give a coupon code">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row>
                        <label for="camount"><?php echo esc_html__( 'Coupon Amount', 'woo-referral' ); ?> * </label>
                    </th>
                    <td>
                        <input type="number" name="camount" id="camount" class="regular-text" required>
                        <a data-toggle="tooltip" title="Please give a coupon amount">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row>
                        <label for="cpoint"><?php echo esc_html__( 'Coupon Points', 'woo-referral' ); ?> * </label>
                    </th>
                    <td>
                        <input type="number" name="cpoint" id="cpoint" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a coupon points">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ulimit"><?php echo esc_html__( 'Usage Limit Per Coupon', 'woo-referral' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="ulimit" id="ulimit" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a usage limit per coupon">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="edate"><?php echo esc_html__( 'Expity Date', 'woo-referral' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="edate" id="edate" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a expity date of referral">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mimspend"><?php echo esc_html__( 'Minimum Spend', 'woo-referral' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="mimspend" id="mimspend" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a minimum spend amount">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="maxspend"><?php echo esc_html__( 'Maximum Spend', 'woo-referral' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="maxspend" id="maxspend" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a maximum spend amount">?</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="description"><?php echo esc_html__( 'Description', 'woo-referral' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="description" id="description" class="regular-text">
                        <a data-toggle="tooltip" title="Please give a referral escription">?</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button( __( 'Add Referral', 'woo-referral' ), 'primary', 'submit_address' ); ?>

    </form>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>