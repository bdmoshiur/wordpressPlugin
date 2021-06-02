<div class='wrap'>
    <h1><?php  esc_html_e( 'New Address', 'wedevs-academy' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="name"><?php esc_html_e( 'Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input class="regular-text" name="name" id="name" placeholder="<?php esc_html_e( 'Enter tha name', 'wedevs-acadeny' ) ?>">
                        <?php if( $this->has_error( 'name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('name') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'address' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="address"><?php esc_html_e( 'Address', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                       <textarea class="regular-text" name="address" id="address" placeholder="<?php esc_html_e( 'Enter the address', 'wedevs-acadeny' ) ?>"></textarea>
                       <?php if( $this->has_error('address') ) { ?>
                            <p class="description error"><?php echo $this->get_error('address') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'phone' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="phone"><?php esc_html_e( 'Phone', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input class="regular-text" name="phone" id="phone" placeholder="<?php esc_html_e( 'Enter tha phone', 'wedevs-acadeny' ) ?>">
                        <?php if( $this->has_error('phone') ) { ?>
                            <p class="description error"><?php echo $this->get_error('phone') ?></p>
                         <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php  wp_nonce_field( 'new-addres' ) ?>
        <?php submit_button( __( 'Save Addrtess', 'wedevs-acadeny' ), 'primary', 'submit_addres' ) ?>
    </form>
</div>