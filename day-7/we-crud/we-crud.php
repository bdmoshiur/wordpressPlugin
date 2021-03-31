<?php
/**
 * Plugin Name:       We Crud Plugin
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Handle the crud with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-crud
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
* composer file loaded
* 
* @since 1.0.0
* 
* @return void
*/
require_once  __DIR__ . '/vendor/autoload.php'; 

/**
* The main class of we crud plugin
* 
* @since 1.0.0
*
* @return mixed
*/
final class We_Crud {

    /**
    * plugin Version
    *
    * @return string
    */
    const version = '1.0.0';

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
    * @return \We_Crud
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
        define( 'WE_CRUD_VERSION', self::version );
        define( 'WE_CRUD_FILE', __FILE__ );
        define( 'WE_CRUD_PATH', __DIR__ );
        define( 'WE_CRUD_URL', plugins_url( '', WE_CRUD_FILE ) );
        define( 'WE_CRUD_ASSETS',  WE_CRUD_URL . '/assetes' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
    */
    public function init_plugin() {
        if( is_admin() ){
            new We\Crud\Admin();
        }else{
            new We\Crud\Frontend();
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
        $installer= new We\Crud\Installer();
        $installer->run();
    }
}

/**
 * initialize the main plugin
*
* @since 1.0.0
* 
* @return \We_Crud
*/
function mrm_we_crud() {
    return We_Crud::init();
}
 
/**
 * Kick of The Plugin
*
* @since 1.0.0
*
* @return object
*/
mrm_we_crud();
