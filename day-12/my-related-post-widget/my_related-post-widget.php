<?php
/**
 * Plugin Name:       My Related Post Widget
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Related Post Widget plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my_related-post-widget
 * Domain Path:       /languages
 */

/**
 * Don't call the file directly
 * 
 * @since 1.0.0
 */ 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Include the autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    return;
}

require_once __DIR__ . "/vendor/autoload.php";

/**
 * Main plugin class
 *
 * @class Related_Post_Widget
 *
 * The class that holds the entire plugin
 */
final class Rpw_Related_Post_Widget {

    /**
     * Plugin version
     *
     * @since 1.0.0
     * 
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * Class constructor
     *
     * @since  1.0.0
     * 
     * @return mixed
     */
    private function __construct() {
        $this->define_constant();

        register_activation_hook( __FILE__,  [ $this, 'activate' ] );

        add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0.0
     *
     * @return \Rpw_Related_Post_Widget
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
        define( 'RPW_Widget_VERSION', self::VERSION );
        define( 'RPW_Widget_FILE', __FILE__ );
        define( 'RPW_Widget_PATH', __DIR__ );
        define( 'RPW_Widget_URL', plugins_url( '', RPW_Widget_FILE ) );
        define( 'RPW_Widget_ASSETS', RPW_Widget_URL . '/assets' );
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function activate() {
        $installer = get_option( 'rpw_widget_install' );

        if ( ! $installer ) {
            update_option( 'rpw_widget_install', time() );
        }

        update_option( 'rpw_widget_version', RPW_Widget_VERSION );
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        new Post\Widget\Admin();
    }
}

/**
 * Initialize the main plugin
 *
 * @since 1.0.0
 * 
 * @return \Rpw_Related_Post_Widget
 */
function rpw_related_post_widget() {
    return Rpw_Related_Post_Widget::init();
} 

/**
 * Kick-off the plugin
 * 
 * @since 1.0.0
 */
rpw_related_post_widget();