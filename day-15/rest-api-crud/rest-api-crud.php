<?php
/**
 * Plugin Name:       Rest Api CRUD Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Wedevs
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wedevs-academy
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
 * Include the autoloader
 * 
 * @since 1.0.0
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    return;
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main class of plugin
 */
final class Wedevs_Academy {

    /**
     * Plugin version
     *
     * @since 1.0.0
     * 
     * @var string
     */
    const version = '1.0.0';

    /**
     * Constructor Function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function __construct() {
        $this->define_constant();
        register_activation_hook( __FILE__ , [ $this, 'activeted' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0.0
     *
     * @return \Wedevs_Academy
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the plugin constants
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function define_constant() {
        define( 'WD_ACADEMY_VERSION', self::version );
        define( 'WD_ACADEMY_FILE', __FILE__ );
        define( 'WD_ACADEMY_PATH', __DIR__ );
        define( 'WD_ACADEMY_URL', plugins_url( '', WD_ACADEMY_FILE ) );
        define( 'WD_ACADEMY_ASSETS', WD_ACADEMY_URL . 'assets/'  );
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function activeted() {
        $installer = new Wedevs\Academy\Installer();
        $installer->run();
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new Wedevs\Academy\Admin();
        } else {
            new Wedevs\Academy\Frontend();
        }
        new Wedevs\Academy\API();
    }
}

/**
 * The main class instance
 *
 * @since 1.0.0
 * 
 * @return object
 */
function wd_wedevs_academy() {
    
    return Wedevs_Academy::init();
}

/**
 * object calling function
 * 
 * @since 1.0.0
 */
wd_wedevs_academy();