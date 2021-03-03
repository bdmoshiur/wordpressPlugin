<?php

/**
 * Plugin Name:       SEO Meta Information
 * Plugin URI:        https://seo-meta-information.com
 * Description:       Handle the SEO Meta Information with this plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       seo-meta-nformation
 * Domain Path:       /languages
 */

 /**
 * Exit if accessed directly
 */ 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
 * The main class SEO Meta Information plugin
 */
class Seo_Meta_information {
    /**
     * constructor
     */
    function __construct()
    {
        add_action('wp_head', [ $this, 'seo_meta_information'] );
    }

    /**
     * The main function SEO Meta Information
     *
     * @return void
     */
    public function seo_meta_information()
    {
        ?>

        <meta name="description" content="web Ddesign and development materials">
        <meta name="keywords" content="HTML, CSS, JavaScript, php, wordpress, laravel">
        <meta name="author" content="moshiur rahman">
        
        <?php
    }

}

/**
 * The main class instance
 *
 * @return object
 */
function meta_information(){
    return new Seo_Meta_information();
}

/**
 * object calling function
 */
meta_information();
