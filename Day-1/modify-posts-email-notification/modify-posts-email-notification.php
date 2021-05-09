<?php
/**
 * Plugin Name:       Modify Posts Email Notification
 * Plugin URI:        https://post-title-capitalize.com
 * Description:       Modify Post view with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       modify-posts-email-notification
 * Domain Path:       /languages
 */

 /**
 * Exit if accessed directly
 * 
 * @since 1.0.0
 */ 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The main class Modify Posts Email plugin
 */
class Modify_Posts_Email_Notification {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_filter( 'modify_email', [ $this,'modify_post_published_notification' ] );
    }

    /**
     * The main function Email sent
     *
     * @since 1.0.0
     * 
     * @param string $to
     * 
     * @return array
     */
    function modify_post_published_notification( $to ) {
        $to = [
            get_option( 'admin_email' ),
            'test@gmail.com',
            'hello@gmail.com'
        ];

        return  $to;
    }
}

/**
 * The main class instance
 *
 * @since 1.0.0
 * 
 * @return object
 */
function mrm_modify_post_mail() {

    return new Modify_Posts_Email_Notification();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
mrm_modify_post_mail();