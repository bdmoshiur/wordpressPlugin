<?php
/**
 * Plugin Name:       Post Title Capitalize
 * Plugin URI:        https://post-title-capitalize.com
 * Description:       Post Title Capitalize with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-title-Capitalize
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
 * The main class of title capitalize plugin 
 */
class Tc_Title_capitalize {
    
    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_filter( 'wp_insert_post_data', [ $this, 'post_title_capitalize' ], 10, 1 );
    }
    
    /**
     * Post Title Capitalize function
     *
     * @since 1.0.0
     * 
     * @param strig $title
     * 
     * @return string
     */
    public function post_title_capitalize( $data ) {

        if ( 'post' != $data ['post_type'] ) {
            return $data;
        }

        $data['post_title'] = ucwords( $data['post_title'] );

        return apply_filters( 'modify_post_title', $data );
    }
}

/**
 * The main class instance create function
 * 
 * @since 1.0.0
 * 
 * @return \Tc_Title_capitalize
 */
function tc_title_capitalize() {
    return new Tc_Title_capitalize();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
tc_title_capitalize();