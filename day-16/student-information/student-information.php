<?php
/**
 * Plugin Name:       Student Information Plugin
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Handle the Student Information with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       student-info
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
final class Si_Student_Info {
    
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

        add_action('plugins_loaded', [ $this, 'student_integrate_wpdb' ] );
     }

    /**
    * initialize a singleton instance
    *
    * @since 1.0.0
    *
    * @return \Si_Student_Info
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
        define( 'SI_INFO_VERSION', self::version );
        define( 'SI_INFO_FILE', __FILE__ );
        define( 'SI_INFO_PATH', __DIR__ );
        define( 'SI_INFO_URL', plugins_url( '', SI_INFO_FILE ) );
        define( 'SI_INFO_ASSETS',  SI_INFO_URL . '/assetes' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * @return void
    */
    public function init_plugin() {
        new Student\Info\Frontend();
    }

    public function student_integrate_wpdb() {
        global $wpdb;
         
        $wpdb->studentmeta = $wpdb->prefix . 'studentmeta';
    }



    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
    */
    public function activate() {
        $installer= new Student\Info\Installer();
        $installer->run();
    }
}

/**
 * initialize the main plugin
*
* @since 1.0.0
* 
* @return \Si_Student_Info
*/
function si_student_info() {
    return Si_Student_Info::init();
}
 
/**
 * Kick of The Plugin
*
* @since 1.0.0
*
* @return object
*/
si_student_info();
