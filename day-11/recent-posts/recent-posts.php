<?php
/**
 * Plugin Name:       Recent Posts
 * Plugin URI:        https://example.com/
 * Description:       Display recent posts plugin on wordPress dashboard.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            Moshiur Rahman.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       recent-posts
 * Domain Path:       /languages/
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
require_once __DIR__ . '/vendor/autoload.php';


final class Recent_Posts {
    /**
     * Plugin version
     * 
     * @var string version
     */
    const version = '1.0.0';

    /**
     * Class constructor
     * 
     * @return void
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Run all necessary plugin functionalities
     * 
     * @return void
     */
    public function init_plugin() {
        new Recent\Posts\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Recent\Posts\Ajax();
        }
        
        new Recent\Posts\Dashboard();
    }

    /**
     * Define all necessary constants
     * 
     * @return void
     */
    public function define_constants() {
        define( 'RECENT_POSTS_VERSION', self::version );
        define( 'RECENT_POSTS_PATH', __DIR__ );
        define( 'RECENT_POSTS_FILE', __FILE__ );
        define( 'RECENT_POSTS_URL', plugins_url( '', RECENT_POSTS_FILE ) );
        define( 'RECENT_POSTS_ASSETS', RECENT_POSTS_URL . '/assets' );
    }

    /**
     * Add plugin version and time
     * 
     * @return void
     */
    public function activate() {
        $installed = get_option( 'recent_posts_time' );

        if ( ! $installed ) {
            update_option( 'recent_posts_time', time() );
        }

        update_option( 'recent_posts_version', RECENT_POSTS_VERSION );
    }

    /**
     * Initialize Singleton Instance
     * 
     * @return \Recent_Posts
     */
    public static function init() {
        $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }
}


/**
 * Initialize the plugin
 * 
 * @return \Recent_Posts
 */
function mrm_recent_posts_boot() {
    return Recent_Posts::init();
}

// Start the plugin
mrm_recent_posts_boot();