<?php

namespace Woo\Referral;

/**
 * Plugin default assets install class
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
        $installed = get_option( 'woo_referral_time' );

        if ( ! $installed ) {
            update_option( 'woo_referral_time', time() );
        }

       update_option( 'woo_referral_version', WOO_REFERRAL_VERSION );
    }
    
    /**
     * Table create function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function create_tables() {

        /**
         * Create databae table
         */
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        /**
         * Create woo_coupon_conversion table
         */
        $woo_coupon_conversion     = $wpdb->prefix . 'woo_coupon_conversion';
        $woo_coupon_conversion_sql = "CREATE TABLE $woo_coupon_conversion (
            `id` INT(20) NOT NULL AUTO_INCREMENT, 
            `amount` INT(100) NOT NULL,
            `point` INT(100) NOT NULL,
            `expiry_date` DATE NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta( $woo_coupon_conversion_sql );

        /**
         * Create woo_visits table
         */
        $woo_visits     = $wpdb->prefix . 'woo_visits';
        $woo_visits_sql = "CREATE TABLE $woo_visits (
            `id` INT(20) NOT NULL AUTO_INCREMENT, 
            `user_id` INT(100) NOT NULL,
            `coupon_code` VARCHAR(100) NOT NULL,
            time int(10) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta( $woo_visits_sql );

        /**
         * Create woo_generate_coupon table
         */
        $woo_generate_coupon     = $wpdb->prefix . 'woo_generate_coupon';
        $woo_generate_coupon_sql = "CREATE TABLE $woo_generate_coupon (
            `id` INT(20) NOT NULL AUTO_INCREMENT, 
            `user_id` INT(100) NOT NULL,
            `amount` INT(100) NOT NULL,
            `point` INT(100) NOT NULL,
            `coupon_code` VARCHAR(100) NOT NULL,
            `purchase_date` DATE NOT NULL,
            `expiry_date` DATE NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta( $woo_generate_coupon_sql );

        /**
         * Create woo_transition table
         */
        $woo_transition     = $wpdb->prefix . 'woo_transition';
        $woo_transition_sql = "CREATE TABLE $woo_transition (
            `id` INT(20) NOT NULL AUTO_INCREMENT, 
            `event_name` VARCHAR(100) NOT NULL,
            `coupon_code` VARCHAR(100) NOT NULL,
            `user_id` INT(100) NOT NULL,
            `point` INT(100) NOT NULL,
            `type` VARCHAR(100) NOT NULL,
            `time` int(10) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta( $woo_transition_sql );
    }
}