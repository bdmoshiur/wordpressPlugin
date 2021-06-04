<div class="wrap">
    <h1><?php _e( 'Edit Address', 'we-crud' ); ?> </h1>
    
    <?php if( isset( $_GET['address-updated']) ) { ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Address has been Updated successfully', 'we-crud' ) ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
               <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e('Name', 'we-crud'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="<?php echo esc_attr( $address->name ); ?>">
                        <?php if( $this->has_error( 'name' ) ) { ?>
                            <p class='description error'><?php echo $this->get_error( 'name' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="address"><?php _e('Address', 'we-crud'); ?></label>
                    </th>
                    <td>
                        <textarea name="address" class="regular-text" name="address" id="address"><?php echo esc_textarea( $address->address ); ?></textarea>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'phone' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="phone"><?php _e('Phone', 'we-crud'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr( $address->phone ); ?>">
                        <?php if( $this->has_error( 'phone' ) ) { ?>
                            <p class='description error'><?php echo $this->get_error( 'phone' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="id" value="<?php echo esc_textarea( $address->id ); ?>"/>
        <?php wp_nonce_field( 'new-addrss' ); ?>
        <?php submit_button( __( 'Update Address', 'we-crud' ), 'primary', 'submit_address' ); ?>
    </form>
</div>