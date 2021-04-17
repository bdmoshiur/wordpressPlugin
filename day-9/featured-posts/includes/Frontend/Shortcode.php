<?php
namespace Featured\Posts\Frontend;

/**
 * Shortcode main class function
 * 
 * @since 1.0.0
 * 
 * @return void
 */
class Shortcode {

   /**
     * Construct function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
   function __construct() {
      add_shortcode( 'setting-field', [ $this, 'add_setting_field' ] );
   }

   /**
     * Shortcode main function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
   public function add_setting_field( $atts ) {
      $no_of_posts       = get_option[ 'no_of_post' ];
      $order_of_posts    = get_option[ 'posts_order' ];
      $selected_category = isset( get_option[ 'posts_category' ] ) ? implode( ",", get_option[ 'posts_category' ] ) : '';
   
      $default = shortcode_atts( array(
         'posts'  => $no_of_posts,
         'order'  => $order_of_posts,
         'select' => $selected_category 
      ), $atts );

      $args = array(
         'post_type'        => 'post',
         'posts_per_page'   => $default[ 'posts' ],
         'order'            => $default[ 'order' ],
         'category_name'    => $default[ 'select' ],
      );

      $the_query = get_transient( 'feature_post_transient_data' );
      if( false == $the_query ) {
         $the_query = new \WP_Query( $args );
         set_transient( 'feature_post_transient_data', $the_query, MINUTE_IN_SECONDS );
      }
      
      /**
       * Removes transient in case of form update
       */
      if ( isset( $_POST['featured-posts-setting'] ) ) {
         delete_transient( 'feature_post_transient_data' );
        }

      if ( $the_query->have_posts() ) {
         $posts = $the_query->posts;
         echo '<ul>';
         foreach ($posts as $post) {
            echo '<h2>' . $post->post_title . '</h2>';
         }
         echo '</ul>';
      }
      wp_reset_postdata();
   }
}
