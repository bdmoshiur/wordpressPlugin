<?php
/**
 * Plugin Name:       Posts View
 * Plugin URI:        https://posts-view.com
 * Description:       Posts view with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur-rahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       posts-view
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 * 
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The main class of posts view plugin
 */
class Posts_View_Count {

    /**
     * Constructor Function
     * 
     * @since 1.0.0
     */
    public function __construct() {
        add_filter( 'the_content', [ $this, 'posts_view_count' ] );
        add_shortcode( 'post_count_view', [ $this, 'mrm_post_count_view' ] );
    }

    /**
     * The main function post view count
     *
     * @since 1.0.0
     * @param string $content
     * 
     * @return array
     */
    public function posts_view_count( $content ) {
        if ( is_single() ) {
            $post_id   = get_the_ID();
            $post_view = get_post_meta( $post_id, 'view_post_single_page', true );
            $views     = isset( $post_view ) ? ( int ) $post_view + 1: 0;
            $count     = update_post_meta( $post_id, 'view_post_single_page', $views );

            return $content . '<h2>View Post : ' . apply_filters( 'modify_count_view', $views ) . '</h2>';
        } else {

            return $content;
        }
    }

    /**
     * Undocumented function
     *
     * @param array $atts
     * 
     * @return string
     */
    public function mrm_post_count_view( $atts, $content ) {
        $atts = shortcode_atts(
            [
                'id'       => '',
                'category' => '',
                'post_no'  => '10',
                'order'    => 'DESC',
            ],
            $atts
        );

        /* Wp query argument set */
        $args = [
            'post_type'      => 'post', 
            'meta_key'       => 'view_post_single_page', 
            'posts_per_page' => $atts['post_no'],
            'order'          => $atts['order'],
            'orderby'        => 'meta_value_num',
            'post_status'    => 'publish'
        ];

        /* Check category Name*/
        if ( $atts['category'] != '' ) {
            $args['category_name'] = $atts['category'];
        }

        /* Check post id */
        if ( $atts['id']  != '' ) {
            $post_id = explode( ',', $atts['id'] );
            $args['post__in'] = $post_id;
            unset( $args['category_name'] );
        }

        /* Main Query */
        $query = new \WP_Query( $args );
        
        while ( $query->have_posts() ) {
            $query->the_post();
            echo '<li>' . get_the_title() . ' ( ' . $query->post->view_post_single_page . ' ) ' . '</li>';
        }

        /* Restore original Post Data */
        wp_reset_postdata();

        return $content;
    }
}

/**
 * The main class instance
 *
 * @return object
 */
function mrm_posts_view() {
    return new Posts_View_Count();
}

/**
 * object calling function
 */
mrm_posts_view();