<?php
/**
 * Plugin Name:       Featured Posts 
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Featured Posts plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       featured-posts 
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) { 
      exit;
  }

/**
 * composer loaded
 * 
 * @since 1.0.0
 */
require_once  __DIR__ . '/vendor/autoload.php'; 

/**
 * The Main Plugin class
 * 
 * @since 1.0.0
 */
final class Featured_Posts {

    /**
     * plugin Version
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    const VERSION = '1.0.0';

    /**
     * class contructor
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__,  [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
     }

    /**
     * initialize a singleton instance 
     * 
     * @since 1.0.0
     * 
     * @return \Featured_Posts
     */
    public static function init() {
        static $instance = false;
        if( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Define the Required Plugin Constants
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function define_constants() {
        define( 'FEATURED_POSTS_VERSION', self::VERSION );
        define( 'FEATURED_POSTS_FILE', __FILE__ );
        define( 'FEATURED_POSTS_PATH', __DIR__ );
        define( 'FEATURED_POSTS_URL', plugins_url( '', FEATURED_POSTS_FILE ) );
        define( 'FEATURED_POSTS_ASSETS',  FEATURED_POSTS_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * return void
     */
    public function init_plugin() {
        if( is_admin() ){
            new Featured\Posts\Admin();
        }else{
            new Featured\Posts\Frontend();
        }
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
       $installed = get_option( 'featured_posts_time' );

       if ( ! $installed ) {
           update_option( 'featured_posts_time', time() );
       }
       update_option( 'featured_posts_version', FEATURED_POSTS_VERSION );
    }
}

 /**
  * initialize the main plugin
  *  
  * @since 1.0.0
  *
  * @return \Featured_Posts 
  */
 function mrm_featured_posts() {
     
     return Featured_Posts::init();
 }
 
 /**
  * Kick of The Plugin
  *
  * @since 1.0.0
  */
  mrm_featured_posts();


