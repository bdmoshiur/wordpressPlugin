
<?php

/**
 * Plugin Name:       Posts View
 * Plugin URI:        https://posts-view.com
 * Description:       Handle the Posts view with this plugin.
 * Version:           1.0
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
 */ 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The main class of posts view plugin
 */

class Posts_View_Count {

    function __construct()
    {
        add_filter( 'the_content', [ $this , 'posts_view_count' ] );
    }

   /**
     * The main function post view count 
     *
     * @param string $content
     * @return array
     */
    public function posts_view_count( $content )
    {
        if ( is_single() ) {
            $post_id = get_the_ID();
            $post_view = get_post_meta( $post_id, 'view_post_single_page', true );
            $views = isset($post_view) ? (int) $post_view + 1 : 0;
            $count = update_post_meta( $post_id, 'view_post_single_page', $views );
            return $content . '<h2>View Post : ' .  apply_filters( 'modify_count_view', $views ) .'</h2>' ;
        }else{
            
            return $content;
        }
        
    }


}

/**
 * The main class instance
 *
 * @return object
 */
function posts_view(){
    return new Posts_View_Count();
}
/**
 * object calling function
 */
posts_view();