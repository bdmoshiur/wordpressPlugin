<?php
/**
 * Plugin Name:       User Role Capability
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       User Role Capability plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-role-capability
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
final class User_Role_Capability {
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
     * @return \User_Role_Capability
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
        define( 'ROLE_CAPABILITY_VERSION', self::VERSION );
        define( 'ROLE_CAPABILITY_FILE', __FILE__ );
        define( 'ROLE_CAPABILITY_PATH', __DIR__ );
        define( 'ROLE_CAPABILITY_URL', plugins_url( '', ROLE_CAPABILITY_FILE ) );
        define( 'ROLE_CAPABILITY_ASSETS',  ROLE_CAPABILITY_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function init_plugin() {
        new Userrole\Capability\Frontend();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function activate() {
        $installed = get_option( 'role_capability_time' );

        if ( ! $installed ) {
           update_option( 'role_capability_time', time() );
        }
        update_option( 'role_capability_version', ROLE_CAPABILITY_VERSION );

        add_role( 'customer_role', 'Customer Role' );
    }
}

/**
 * initialize the main plugin
 * 
 * @since 1.0.0
 * 
 * @return \User_Role_Capability
 */
function mrm_user_role_capability() {
     
    return User_Role_Capability::init();
}

/**
 * Kick of The Plugin
 * 
 * @since 1.0.0
 */ 
mrm_user_role_capability();


