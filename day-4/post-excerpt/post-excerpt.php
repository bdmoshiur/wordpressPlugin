<?php
/**
 * Plugin Name:       Post Excerpt
 * Plugin URI:        https://post-xcerpt.com
 * Description:       Post Excerpt with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiurrahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-excerpt
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 */ 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The main class of title capitalize plugin 
 */
class Mrm_Post_Excerpt {

    /**
     * Constructor function
     *
     * @return void
     */
    function __construct() {
        add_action( 'add_meta_boxes', [ $this , 'mrm_add_metabox' ] );
        add_action( 'save_post', [ $this, 'mrm_save_post_meta' ] );
        /**
         * Post count excerpt shortcode
         */
        add_shortcode( 'mrm-post-count', [ $this, 'mrm_latest_post_count' ] );
    }
    
    /**
     * Meta box add function
     *
     * @param string $post_type
     * 
     * @return void
     */
    public function mrm_add_metabox( $post_type ) {
        add_meta_box( 
            'textarea_excerpt_metabox',
            'Excerpt Under Post',
            [ $this, 'mrm_textarea_excerpt_metabox' ],
            'post'
        );
    }
    
    /**
     * Show meta box function
     *
     * @param int $post
     * 
     * @return void
     */
    public function mrm_textarea_excerpt_metabox( $posts ) {
        $post_excerpt = get_post_meta( $posts->ID, 'excerpt_under_post', true );
        $description  = ! empty( $post_excerpt['description'] ) ?  $post_excerpt['description']: '';
        ?>
        <?php wp_nonce_field( 'mrm_textarea_excerpt_metabox', 'textarea_excerpt_metabox_nonce' ); ?>
            <div class="form-group">
                <label for="Textarea1"><?php esc_html_e( 'Excerpt Post', 'post-excerpt' ) ?></label>
                <textarea class="form-control widefat id="Textarea1" name="description" rows="3"><?php echo esc_html_e( $description ); ?></textarea>
            </div>
        <?php
    }

    /**
     * Save post Meta function
     *
     * @param int $post_id
     * 
     * @return object
     */
    public function mrm_save_post_meta( $post_id ) {
        $nonce       = isset( $_POST['textarea_excerpt_metabox_nonce'] ) ? $_POST['textarea_excerpt_metabox_nonce']: '';
        $description = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] )                   : '';

        if ( ! wp_verify_nonce( $nonce, 'mrm_textarea_excerpt_metabox' ) ) {
            return;
        }

        $post_excerpt_update = [
            'description'   => $description
        ];
        update_post_meta( $post_id, 'excerpt_under_post', $post_excerpt_update );
    }

    /**
     * Post Count sortcode function
     *
     * @param array $atts
     * 
     * @return string
     */
    public function mrm_latest_post_count( $atts, $content ) {
         $atts = shortcode_atts( 
            [
                'id'       => '',
                'category' => '',
                'post_no'  => '10',
            ],
            $atts
        );

        /* Wp query argument set */
        $args = [
            'post_type'      => 'post', 
            'meta_key'       => 'excerpt_under_post', 
            'posts_per_page' => $atts['post_no'],
            'order'          => 'DESC',
            'orderby'        => 'excerpt_under_post',
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
            echo '<li>' . $query->post->excerpt_under_post['description'] . '</li>';
        }

        /* Restore original Post Data */
        wp_reset_postdata();

        return $content;
    }
}

/**
 * The main class instance create function
 *
 * @return object
 */
function mrm_post_excerpt() {
    return new Mrm_Post_Excerpt();
}

/**
 * object calling function
 */
mrm_post_excerpt();