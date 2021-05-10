<div class='wrap'>
    <h1><?php  esc_html_e( 'Edit Address', 'wedevs-academy' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="name"><?php esc_html_e( 'Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input class="regular-text" name="name" id="name" value="<?php esc_attr_e( $address->name ) ?>" placeholder="Enter tha name">
                        <?php if( $this->has_error( 'name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('name') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'address' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="address"><?php esc_html_e( 'Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                       <textarea class="regular-text" name="address" id="address" placeholder="Enter the address"><?php esc_attr_e( $address->address ) ?></textarea>
                       <?php if( $this->has_error('address') ) { ?>
                            <p class="description error"><?php echo $this->get_error('address') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'phone' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="phone"><?php esc_html_e( 'Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input class="regular-text" name="phone" id="phone" value="<?php esc_attr_e( $address->phone ) ?>" placeholder="Enter tha phone">
                        <?php if( $this->has_error('phone') ) { ?>
                            <p class="description error"><?php echo $this->get_error('phone') ?></p>
                         <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php  wp_nonce_field( 'new-address' ) ?>
        <?php submit_button( 'Save Addrtess', 'primary', 'submit_address' ) ?>
    </form>
    
</div>