<?php
/**
 * Plugin Name:       Book Review rewrite
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the Next Book Reviews plugin..
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nrr-book-review
 * Domain Path:       /languages
 */

/**
 * Don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Include the autoloader
 */
require_once __DIR__ . "/vendor/autoload.php";

/**
 * Main plugin class
 */
final class Brr_Book_Review {

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
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0.0
     *
     * @return \Brr_Book_Review
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
        define( 'BRR_BOOK_REVIEW_VERSION', self::VERSION );
        define( 'BRR_BOOK_REVIEW_FILE', __FILE__ );
        define( 'BRR_BOOK_REVIEW_PATH', __DIR__ );
        define( 'BRR_BOOK_REVIEW_URL', plugins_url( '', BRR_BOOK_REVIEW_FILE ) );
        define( 'BRR_BOOK_REVIEW_ASSETS', BRR_BOOK_REVIEW_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        new Book\Review\Rewrite\Admin();
        new Book\Review\Rewrite\Frontend();
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function activate() {
        $installer = new Book\Review\Rewrite\Admin\Installer();
        $installer->run();
    }
}

/**
 * Initialize the main plugin.
 *
 * @since 1.0.0
 * 
 * @return \Brr_Book_Review
 */
function brr_book_review() {
    return Brr_Book_Review::init();
}

/**
 * Kick-off the plugin
 * 
 * @since 1.0.0
 */
brr_book_review();
