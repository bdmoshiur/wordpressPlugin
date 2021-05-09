<?php
/**
 * Plugin Name:       Author Box
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Author box plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       author-box
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
 * composer loaded
 * 
 * @since 1.0.0
 */
require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The Main Plugin class
 */
final class Author_Box {
    /**
     * plugin Version
     * 
     * @return string
     */
    const VERSION = '1.0.0';

    /**
     * class contructor
     * 
     * @since 1.0.0
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__,  [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * initialize a singleton instance
     * 
     * @return \Author_Box
     */
    public static function init() {
        static $instance = false;
        
        if ( ! $instance ) {
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
        define( 'AUTHOR_BOX_VERSION', self::VERSION );
        define( 'AUTHOR_BOX_FILE', __FILE__ );
        define( 'AUTHOR_BOX_PATH', __DIR__ );
        define( 'AUTHOR_BOX_URL', plugins_url( '', AUTHOR_BOX_FILE ) );
        define( 'AUTHOR_BOX_ASSETS',  AUTHOR_BOX_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function init_plugin() {
        if ( is_admin() ){
            new Author\Box\Admin();
        } else {
            new Author\Box\Frontend();
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
        $installed = get_option( 'author_box_time' );

        if ( ! $installed ) {
           update_option( 'author_box_time', time() );
        }
        update_option( 'author_box_version', AUTHOR_BOX_VERSION );
    }
}

/**
 * initialize the main plugin
 * 
 * @since 1.0.0
 * 
 * @return \Author_Box 
 */
function mrm_author_box() {
     
    return Author_Box::init();
}

/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */
mrm_author_box();


