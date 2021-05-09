<?php
/**
 * Plugin Name:       Cat Facts
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Cat Facts plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cat-facts
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
 */
require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The Main Plugin class
 */
final class Cat_Facts {
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
     * @return \Cat_Facts
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
        define( 'CAT_FACTS_VERSION', self::VERSION );
        define( 'CAT_FACTS_FILE', __FILE__ );
        define( 'CAT_FACTS_PATH', __DIR__ );
        define( 'CAT_FACTS_URL', plugins_url( '', CAT_FACTS_FILE ) );
        define( 'CAT_FACTS_ASSETS',  CAT_FACTS_URL . '/assets' );
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
            new Cat\Facts\Admin();
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
        $installed = get_option( 'cat-facts_time' );

        if ( ! $installed ) {
           update_option( 'cat-facts_time', time() );
        }
        update_option( 'cat-facts_version', CAT_FACTS_VERSION );
    }
}

/**
 * initialize the main plugin
 * 
 * @since 1.0.0
 *  
 * @return \Cat_Facts 
 */
function mrm_cat_acts() {
     
    return Cat_Facts::init();
}
 
/**
 * Kick of The Plugin
 */
mrm_cat_acts();


