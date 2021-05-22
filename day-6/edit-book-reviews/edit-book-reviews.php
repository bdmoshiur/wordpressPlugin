<?php
/**
 * Plugin Name:       Edit Book Reviews
 * Plugin URI:        https://moshiur.com/plugins/
 * Description:       Edit Book Reviews plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       edit-book-reviews
 * Domain Path:       /languages
*/

/**
 * The Main Plugin class
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
*/
require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The main class of plugin
*/
final class Ubrp_Book_Review {

    /**
     * plugin Version
     * 
     * @since 1.0.0
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
     * @return \Ubrp_Book_Review
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
        define( 'UBRP_BOOK_REVIEW_VERSION', self::VERSION );
        define( 'UBRP_BOOK_REVIEW_FILE', __FILE__  );
        define( 'UBRP_BOOK_REVIEW_PATH', __DIR__  );
        define( 'UBRP_BOOK_REVIEW_URL', plugins_url('', UBRP_BOOK_REVIEW_FILE ) );
        define( 'UBRP_BOOK_REVIEW_ASSETS',  UBRP_BOOK_REVIEW_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     * 
     * @since 1.0.0
     * 
     * return void
    */
    public function init_plugin() {
        new Ubrp\Book\Review\Admin();
    }

    /**
     * Do Staff Upon Plugin Activation
     * 
     * @since 1.0.0
     * 
     * @return void
    */
    public function activate() {
        $installed = get_option( 'demo_test_time' );

        if ( ! $installed ) {
           update_option( 'demo_test_time', time() );
        }
        update_option( 'demo_test_version', UBRP_BOOK_REVIEW_VERSION );
    }
}

/**
 * initialize the main plugin
 *
 * @since 1.0.0
 *
 * @return \Ubrp_Book_Review 
*/
function ubrp_book_review() {

    return Ubrp_Book_Review::init();
}
 
/**
 * Kick of The Plugin
 *
 * @since 1.0.0
*/
ubrp_book_review();


