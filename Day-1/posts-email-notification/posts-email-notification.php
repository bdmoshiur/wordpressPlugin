<?php
/**
 * Plugin Name:       Posts Email Notification
 * Plugin URI:        https://post-title-capitalize.com
 * Description:       Modify Post view with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       posts-email-notification
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 * 
 * @since 1.0.0
 */
if ( ! defined('ABSPATH' ) ) {
    exit;
}

/**
 * The main class Modify Posts View plugin
 */
class Pmn_Posts_Email_Notification {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'publish_post', [ $this, 'post_published_notification' ], 10, 2 );
    }

    /**
     * The main function Email sent notification
     *
     * @since 1.0.0
     * 
     * @param int $post_id
     * @param object $post
     * 
     * @return  array
     */
    public function post_published_notification( $post_id, $post ) {
        $author  = $post->post_author;
        $name    = get_the_author_meta( 'display_name', $author );
        $email   = get_the_author_meta( 'user_email', $author );
        $to      = [ get_option( 'admin_email' ) ];
        $subject = $post->post_title;
        $message = "Test email sent. Author Email .$email.'Author Name' . $name";
        $to      = apply_filters( 'modify_email', $to );

        wp_mail( $to, $subject, $message );
    }
}

/**
 * The main class instance
 *
 * @since 1.0.0
 * 
 * @return \Pmn_Posts_Email_Notification
 */
function pm_post_mail() {
    return new Pmn_Posts_Email_Notification();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
pm_post_mail();
