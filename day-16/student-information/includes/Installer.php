<?php

namespace Student\Info;

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
        $installed = get_option( 'si_info_install' );
        
        if ( ! $installed ) {
            update_option( 'si_info_install', time() );
        }

        update_option( 'si_info_version', SI_INFO_VERSION );
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

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}students` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `first_name` varchar(100) NOT NULL,
            `last_name` varchar(255) NOT NULL,
            `class` varchar(30) NOT NULL,
            `roll` varchar(30) NOT NULL,
            `reg_no` varchar(30) NOT NULL,
            `created_by` bigint(20) NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";
        
        $schemameta = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}studentmeta` (
            meta_id bigint(20) unsigned NOT NULL auto_increment,
            student_id bigint(20) unsigned NOT NULL default '0',
            meta_key varchar(255) default NULL,
            meta_value longtext,
            PRIMARY KEY  (meta_id),
            KEY student_id (student_id),
            KEY meta_key (meta_key)
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
        dbDelta($schemameta);
    }
}