<?php

namespace Recent\Posts;

/**
 * Dashboard class
 */
class Dashboard {

    /**
     * Class constructor
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_dashboard_setup', [ $this, 'register_dashboard' ] );
    }

    /**
     * Register dashboard widget
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function register_dashboard() {
        wp_add_dashboard_widget( 
            'dashboard_mrm', 
            __( 'Display Recent Posts', 'recent-posts' ),
            [ $this, 'display_mrm_dashboard' ]
        );
    }

    /**
     * Display Dashboard
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function display_mrm_dashboard() {
        wp_enqueue_script( 'mrm-main' );

        $categories      = get_categories();
        $mrm_posts_no    = get_option( 'mrm_posts_no' );   
        $mrm_order       = get_option( 'mrm_order' );
        $mrm_category    = get_option( 'mrm_category_items' );

        $category_select = $mrm_category;
        $posts_no        = ( ! empty( $mrm_posts_no ) ) ? $mrm_posts_no: 5;
        $order           = ( ! empty( $mrm_order ) ) ? $mrm_order      : '';
        $category_name   = ( ! empty( $mrm_category ) ) ? implode( ',', $mrm_category ): '';

        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_no,
            'orderby'        => 'ID',
            'order'          => $order,
            'category_name'  => $category_name,
        ];

        $the_query = new \WP_Query( $args );

        include RECENT_POSTS_PATH . '/assets/templates/dashboard-template.php';
    }
}