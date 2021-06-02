<div>
    <form id="myForm" name="myForm" action="" method="post">
        <fieldset>
        <div>
            <div>
                <label><?php esc_html_e( 'User Name', 'user-role-capability' ) ?></label>
                <input type="text" name="uname" class="regular-text" placeholder="<?php esc_attr_e( 'Enter your username', 'user-role-capability' ) ?>" required  >
            </div>
            <br>
            <div>
                <label><?php esc_html_e( 'Email Adress', 'user-role-capability' ) ?></label>
                <input type="email" name="email" class="regular-text" placeholder="<?php esc_attr_e( 'Enter email address', 'user-role-capability' ) ?>" required >
            </div>
            <br>
            <div>
                <label><?php esc_html_e( 'Password', 'user-role-capability' ) ?></label>
                <input type="password" name="password" class="regular-text" placeholder="<?php esc_attr_e( 'Enter your password', 'user-role-capability' ) ?>" required >
            </div>
            <br>
            <div>
                <label for=""><?php echo esc_html__( 'Capability', 'user-role-capability' ); ?></label>
                <select name="capability" class="regular-text" required>
                    <option ><?php esc_html_e('Select customer', 'user-role-capability') ?></option>
                    <option value="wholesale" ><?php esc_html_e( 'wholesale customer', 'user-role-capability' ) ?></option>
                    <option value="retail" ><?php esc_html_e( 'retail customer', 'user-role-capability' ) ?></option>
                    <option value="regular" ><?php esc_html_e( 'regular customer', 'user-role-capability' ) ?></option>
                </select>
            </div>
            <br>
            <div>
                <?php wp_nonce_field( 'nonce_from_shortcode' ) ?>
                <br>
                <input type="submit" name="send_shortcode" value="<?php esc_attr_e( 'Save', 'user-role-capability' ) ?>">
            </div>
        </div>
        </fieldset>
    </form>
</div>
