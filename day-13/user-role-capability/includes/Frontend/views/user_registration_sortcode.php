<div>
    <form id="myForm" name="myForm" action="" method="post">
        <fieldset>
        <div>
            <div>
                <label><?php _e('User Name', 'user-role-capability') ?></label>
                <input type="text" name="uname" class="regular-text" value="" placeholder="Enter your username" required  >
            </div>
            <br>
            <div>
                <label><?php _e('Email Adress', 'user-role-capability') ?></label>
                <input type="email" name="email" class="regular-text" value="" placeholder="Enter email address" required >
            </div>
            <br>
            <div>
                <label><?php _e('Password', 'user-role-capability') ?></label>
                <input type="password" name="password" class="regular-text" value="" placeholder="Enter your password" required >
            </div>
            <br>
            <div>
                <label for=""><?php echo esc_html__( 'Capability', 'user-role-capability' ); ?></label>
                <select name="capability" class="regular-text" required>
                    <option value="" >Select customer</option>
                    <option value="wholesale" >wholesale customer</option>
                    <option value="retail" >retail customer</option>
                    <option value="regular" >regular customer</option>
                </select>
            </div>
            <br>
            <div>
                <?php wp_nonce_field( 'nonce_from_shortcode' ) ?>
                <br>
                <input type="submit" name="send_shortcode" value="<?php _e('Save', 'user-role-capability') ?>">
            </div>
        </div>
        </fieldset>
    </form>
</div>
