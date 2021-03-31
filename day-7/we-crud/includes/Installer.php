<?php
namespace We\Crud;

/**
 * The installer Class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Installer {

    /**
     * The main class of installer class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Version set function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function add_version() {
        $installed = get_option( 'we_crud_install' );
        
        if ( ! $installed ) {
            update_option( 'we_crud_install', time() );
        }
        update_option( 'we_crud_version', WE_CRUD_VERSION );
    }

    /**
     * create necessary Database table
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}fp_addresses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `address` varchar(255) NOT NULL,
            `phone` varchar(30) NOT NULL,
            `created_by` bigint(20) NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";
        
        /**
         * dbDelta function set & check
         * 
         * @since 1.0.0
         * 
         * @return string
         */
        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
        
        dbDelta($schema);
    }
}
