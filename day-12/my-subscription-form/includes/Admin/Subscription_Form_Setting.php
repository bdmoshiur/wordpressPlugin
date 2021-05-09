<?php
namespace Subscription\Form\Admin;

/**
 * The Setting Section Handale Class
 */
class Subscription_Form_Setting {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'admin_init', [ $this,'render_subscrip_setting'] );
    }

    /**
     * Setting section/field register function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function render_subscrip_setting () {
        add_settings_section( 'mailchimp_section', __( 'Mailchimp', 'my-subscription-form' ), [ $this, 'render_api_section'], 'general' );
        add_settings_field( 'mailchimp_link', __( 'Mailchimp Api Link', 'my-subscription-form' ), [ $this, 'render_api_field'], 'general', 'mailchimp_section' );
        register_setting( 'general', 'mailchimp_link' );
    }

    /**
     * Setting section callback function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function render_api_section() {
        echo __( 'Meilchimp api setting section', 'my-subscription-form' );
    }

    /**
     * Setting field callback function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function render_api_field( ) {
        $mailchimp_link = get_option( 'mailchimp_link' );
        echo '<input type="text" class="widefat" name="mailchimp_link" value="'. $mailchimp_link.'" placeholder="' . __( 'Enter your api key', 'my-subscription-form' ) . ">';
    }
}
