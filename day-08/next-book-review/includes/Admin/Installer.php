<?php

namespace Nbr\Book\Review\Admin;

/**
 * Handle Installer class
 */
class Installer {

    /**
     * Run installer function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run() {
        $this->nbr_version();
        $this->create_tables();
    }

    /**
     * Version added function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function nbr_version() {
        $installed = get_option( 'nbr_book_review_installed' );

        if ( ! $installed ) {
            update_option( 'nbr_book_review_installed', time() );
        }

        update_option( 'nbr_book_review_version', NBR_BOOK_REVIEW_VERSION );
    }

    /**
     * Create table function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}wedevs_book_review_rating` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `post_id` bigint unsigned NOT NULL,
            `user_id` bigint unsigned NOT NULL,
            `ip` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
            `rating` float unsigned NOT NULL DEFAULT '0',
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}
