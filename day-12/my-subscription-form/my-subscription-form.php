<?php
/**
 * Plugin Name:       My Subscription Form
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       My subscription form test plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-subscription-form
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) { 
      exit;
  }

/**
 * composer file loaded
 */
require_once  __DIR__ . '/vendor/autoload.php'; 

/**
 * The Main Plugin class
 */
final class Mrm_Subscription_Form {
    /**
     * plugin Version
     * 
     * @return string
     */
    const VERSION = '1.0.0';

    /**
     * class contructor 
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__,  [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
     }

    /**
     * initialize a singleton instance 
     * 
     * @return \Mrm_Subscription_Form
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
     * @return void
     */
    public function define_constants() {
        define( 'SUBSCRIP_FORM_VERSION', self::VERSION );
        define( 'SUBSCRIP_FORM_FILE', __FILE__ );
        define( 'SUBSCRIP_FORM_PATH', __DIR__ );
        define( 'SUBSCRIP_FORM_URL', plugins_url( '', SUBSCRIP_FORM_FILE ) );
        define( 'SUBSCRIP_FORM_ASSETS',  SUBSCRIP_FORM_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * return void
     */
    public function init_plugin() {
        new Subscription\Form\Mrm_Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Subscription\Form\Mrm_Ajax();
        }
        new Subscription\Form\Admin();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @return void
     */
    public function activate() {
       $installed = get_option( 'subscribtion_form_time' );

       if ( ! $installed ) {
           update_option( 'subscribtion_form_time', time() );
       }
       update_option( 'subscribtion_form_version', SUBSCRIP_FORM_VERSION );
    }
}

 /**
  * initialize the main plugin
  *  
  * @return \Mrm_Subscription_Form 
  */
 function mrm_subscription_form() {
     
     return Mrm_Subscription_Form::init();
 }
 
 /**
  * Kick of The Plugin
  */
  mrm_subscription_form();


