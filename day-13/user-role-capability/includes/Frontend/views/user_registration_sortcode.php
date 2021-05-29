<div>
    <form id="myForm" name="myForm" action="" method="post">
        <fieldset>
        <div>
            <div>
                <label><?php _e( 'User Name', 'user-role-capability' ) ?></label>
                <input type="text" name="uname" class="regular-text" value="" placeholder="<?php _e( 'Enter your username', 'user-role-capability' ) ?>" required  >
            </div>
            <br>
            <div>
                <label><?php _e( 'Email Adress', 'user-role-capability' ) ?></label>
                <input type="email" name="email" class="regular-text" value="" placeholder="<?php _e( 'Enter email address', 'user-role-capability' ) ?>" required >
            </div>
            <br>
            <div>
                <label><?php _e( 'Password', 'user-role-capability' ) ?></label>
                <input type="password" name="password" class="regular-text" value="" placeholder="<?php _e( 'Enter your password', 'user-role-capability' ) ?>" required >
            </div>
            <br>
            <div>
                <label for=""><?php echo esc_html__( 'Capability', 'user-role-capability' ); ?></label>
                <select name="capability" class="regular-text" required>
                    <option value="" ><?php _e('Select customer', 'user-role-capability') ?></option>
                    <option value="wholesale" ><?php _e( 'wholesale customer', 'user-role-capability' ) ?></option>
                    <option value="retail" ><?php _e( 'retail customer', 'user-role-capability' ) ?></option>
                    <option value="regular" ><?php _e( 'regular customer', 'user-role-capability' ) ?></option>
                </select>
            </div>
            <br>
            <div>
                <?php wp_nonce_field( 'nonce_from_shortcode' ) ?>
                <br>
                <input type="submit" name="send_shortcode" value="<?php _e( 'Save', 'user-role-capability' ) ?>">
            </div>
        </div>
        </fieldset>
    </form>
</div>
