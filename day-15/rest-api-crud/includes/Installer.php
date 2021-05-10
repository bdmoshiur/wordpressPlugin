<?php
namespace Wedevs\Academy;

/**
 * Plugin install class
 */
class Installer {

    /**
     * function calling
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Version add function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function add_version() {
        $install = get_option( 'mrm_academy_install' );

        if ( ! $install ) {
            update_option( 'mrm_academy_install', time() );
        }
        update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
    }
    
    /**
     * Table create function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function create_tables() {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `project`.`{$wpdb->prefix}ac_address` ( 
        `id` INT(20) NOT NULL AUTO_INCREMENT , 
        `name` VARCHAR(100) NOT NULL , 
        `address` VARCHAR(250) NOT NULL , 
        `phone` VARCHAR(30) NOT NULL , 
        `created_by` BIGINT(20) NOT NULL , 
        `created_at` DATETIME NOT NULL , 
        PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
        dbDelta( $schema );
    }
}