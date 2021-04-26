<?php

namespace Formsubmit\Ajax;

/**
 * Plugin default assets install class
 * 
 * @since 1.0.0
 */
class Installer {


    /**
     * Version/Table run function
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
     * version and install add function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function add_version() {
        $installed = get_option( 'ajax_form_time' );

        if ( ! $installed ) {
            update_option( 'ajax_form_time', time() );
        }
       update_option( 'ajax_form_version', FORM_AJAX_SUBMIT_VERSION );
    }
    

    /**
     * Table create function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function create_tables() {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `project`.`{$wpdb->prefix}af_address` ( 
        `id` INT(20) NOT NULL AUTO_INCREMENT , 
        `fname` VARCHAR(100) NOT NULL ,
        `lname` VARCHAR(100) NOT NULL ,
        `message` VARCHAR(250) NOT NULL , 
        `email` VARCHAR(30) NOT NULL , 
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