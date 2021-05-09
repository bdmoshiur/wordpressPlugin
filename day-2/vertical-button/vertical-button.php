<?php
/**
 * Plugin Name:       Vertical Button
 * Plugin URI:        https://seo-meta-information.com
 * Description:       Handle Vertical Button with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       vertical-button
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
 * The main class Vertical Button plugin
 */
class Vertical_Button {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_action( 'wp_head', [ $this,  'vertical_button_front_site' ] );
        add_filter( 'modify_title', [ $this,  'modify_title_text' ] );
        add_filter( 'help_description', [ $this,  'description_text' ] );
        add_action( 'wp_enqueue_scripts', [ $this,  'enqueue_script_site' ] );
    }

    /**
     * The main function Vertical Button
     *
     * @return void
     */
    public function vertical_button_front_site() {
        $title                  = '<button id = "btn-coupon">'. esc_html_e( 'Coupons', 'vertical-button' ) . '</button>';
        echo $change_title      = apply_filters( 'modify_title',  $title );

        $help_description       = '<div id    = "btn-description">' . esc_html_e( ' Dokan saves you hundreds of work hours while creating an online marketplace. See some of the many reasons that make it the #1 Open-source Multi Vendor Solution' , 'vertical-button' ) . '</div>';
        echo  $help_description = apply_filters('help_description',  $help_description );
    }

    /**
     * Button Title change function 
     *
     * @since 1.0.0
     * 
     * @param string
     * 
     * @return string
     */
    public function modify_title_text( $test ) {
        $test =  '<button id="btn-coupon">' . esc_html_e( 'Click me', 'vertical-button' ) . '</button>';

        return $test;
    }

    public function description_text( $modify_help_description ) {
        $modify_help_description = '<div id="btn-description">' . esc_html_e('weDevs is the maker of Dokan Multivendor, WP Project Manager, WP User Frontend, WP ERP and many more', 'vertical-button' ) . '</div>';

        return $modify_help_description;
    }

    /**
     * CSS & JS file loaded function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function enqueue_script_site() {
        wp_enqueue_style( 'Vertical-button', plugin_dir_url( __FILE__ ) . '/assets/css/frontend.css' );
        wp_enqueue_script( 'Vertical-button', plugin_dir_url( __FILE__ ) . '/assets/js/frontend.js', array( 'jquery' ), '1.0.0', true );
    }
}

/**
 * The main class instance
 *
 * @since 1.0.0
 * 
 * @return object
 */
function mrm_vertical_button() {
    return new Vertical_Button();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
mrm_vertical_button();
