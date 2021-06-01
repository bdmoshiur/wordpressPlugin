<?php
/**
 * Plugin Name:       Next Modify Email Notification
 * Plugin URI:        https://post-title-capitalize.com
 * Description:       Modify Post view with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       next-email-notification
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
class Nme_Posts_Email_Notification {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

        add_action( 'plugins_loaded', [ $this, 'admin_email_send'] );
        add_action( 'publish_post', [ $this, 'post_published_notification' ], 10, 2 );
    }

    /**
     * Activation function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
        if ( ! wp_next_scheduled( 'neh_cron_hook' ) ) {
            wp_schedule_event( time(), 'daily', 'neh_cron_hook' );
        }
    }

    /**
     * Deactivation function
     * 
     * @since 1.0.0
     * 
     * @return void 
     */
    public function deactivate() {
        $timestamp = wp_next_scheduled( 'neh_cron_hook' );
        wp_unschedule_event( $timestamp, 'neh_cron_hook' );
    }

    /**
     * Admin email send function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function admin_email_send() {
        add_action( 'neh_cron_hook', 'neh_cron_execution' );
    }
    
    /**
     * Cron execution function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function neh_cron_execution() {
        $day = getdate();

		$args = [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'date_query'  => [
				[
				    'year'  => $day['year'],
		            'month' => $day['mon'],
		            'day'   => $day['mday'],
			    ],
		    ],
        ];

		$query        = new \WP_Query( $args );
		$posts        = $query->posts;
		$post_titles  = '<ul>';
		$num_of_posts = count( $posts );

		foreach ( $posts as $post ) {
			$post_titles .= '<li>' . esc_html( $post->post_title ) . '</li>';
		}

		$post_titles  .= '</ul>';
		$admin_email   = get_option( 'admin_email' );
		$subject       = __( 'New post created', 'next-email-notification' );
		$emails        = apply_filters( 'cron_notification_emails', $admin_email );
		$message       = $num_of_posts . __( 'new posts created', 'next-email-notification' );
		$message      .= $post_titles;

		wp_mail( $emails, $subject, $message );

		wp_reset_query();
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
        $message = __( 'Test email sent Author Email', 'next-email-notification' ) . esc_html( $email ) . __( 'Author Name', 'next-email-notification' ) . esc_html( $name );
        $to      = apply_filters( 'modify_email', $to );

        wp_mail( $to, $subject, $message );
    }
}

/**
 * The main class instance
 *
 * @since 1.0.0
 * 
 * @return \Nme_Posts_Email_Notification
 */
function nme_post_mail() {
    return new Nme_Posts_Email_Notification();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
nme_post_mail();
