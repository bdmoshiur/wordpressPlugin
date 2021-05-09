<?php
 /**
 * Plugin Name:       Jobs Search
 * Plugin URI:        https://contactform.com
 * Description:       Github Jobs Search this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur-rahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       github_jobs_earch
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
 * 
 * @since 1.0.0
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    return;
}
require_once __DIR__ . "/vendor/autoload.php";

/**
 * Main plugin class
 */
final class Mrm_Jobs_Search {
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
     * @return void
     */
    public function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        $this->init_plugin();
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0.0
     *
     * @return \Mrm_Jobs_Search
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
    public function define_constants() {
        define( 'MRM_JOBS_SEARCH_VERSION', self::VERSION );
        define( 'MRM_JOBS_SEARCH_FILE', __FILE__ );
        define( 'MRM_JOBS_SEARCH_PATH', __DIR__ );
        define( 'MRM_JOBS_SEARCH_URL', plugins_url( '', MRM_JOBS_SEARCH_FILE ) );
        define( 'MRM_JOBS_SEARCH_ASSETS', MRM_JOBS_SEARCH_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        new Jobs\Search\Shortcode();
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'mrm_jobs_search_installed' );

        if ( ! $installed ) {
            update_option( 'mrm_jobs_search_installed', time() );
        }
        update_option( 'mrm_jobs_search_version', MRM_JOBS_SEARCH_VERSION );
    }
}

/**
 * Initialize the main plugin
 * 
 * @since 1.0.0
 * 
 * @return \Mrm_Jobs_Search
 */
function mrm_jobs_search() {
    return Mrm_Jobs_Search::init();
}

/**
 * Kick-off the plugin
 * 
 * @since 1.0.0
 */
mrm_jobs_search();
