<?php
namespace Featured\Posts\Admin;

/**
 * The Menu Handale Class
 * 
 * @since 1.0.0
 */
class Featured_Post_Settings {
   
    /**
     * Construct function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'fps_add_options_menu' ] );
        add_action( 'admin_init', [ $this, 'fps_featured_posts_field_register' ] );
    }

    /**
     * Menu added  function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function fps_add_options_menu() {
        add_options_page( 'Featured posts setting', 'Featured Posts', 'manage_options', 'post_options', [ $this, 'fps_display_options_menu' ] );
    }

    /**
     * Menu field display function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function fps_display_options_menu() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        settings_errors( 'wporg_messages' );
        ?>
            <form action="options.php" method="post">
                <?php 
                    do_settings_sections( 'post_options' );
                    settings_fields( 'post_sections' );
                    submit_button( __( 'Save Changes', 'featured-posts' ), 'primary', 'featured-posts-setting' );
                ?>
            </form>
        <?php
    }

    /**
     * Option menu page/section/field register function
     * 
     * @since 1.0.0
     * 
     * @return void
     */

    public function fps_featured_posts_field_register() {
        add_settings_section( 'post_sections', __( 'Featured Posts Setting', 'featured-posts' ), [ $this,'fps_add_field' ], 'post_options' );

        add_settings_field( 'no_of_post', __( 'No fo Posts', 'featured-posts' ), [ $this, 'no_of_post_display' ], 'post_options', 'post_sections' );
        add_settings_field( 'posts_order', __( 'Posts Order', 'featured-posts' ), [ $this, 'post_order_display' ], 'post_options', 'post_sections' );
        add_settings_field( 'posts_category', __( 'Posts Categoory', 'featured-posts' ), [ $this, 'post_category_display' ], 'post_options', 'post_sections' );

        register_setting( 'post_sections', 'no_of_post' );
        register_setting( 'post_sections', 'posts_order' );
        register_setting( 'post_sections', 'posts_category' );
    }

    /**
     * Section para display function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function fps_add_field() {
        return;
    }

     /**
     * Post no field display function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function no_of_post_display() {
        $options = get_option( 'no_of_post' );
        printf( "<input class='regular-text' type='text' id='%s' name='%s' value='%s'>", 'no_of_post', 'no_of_post', $options );   
    }

    /**
     * Post order field display function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function post_order_display() {
        $option = get_option( 'posts_order' );
        $orders = array(
            __( 'Random', 'featured-posts' ),
            __( 'ASE', 'featured-posts' ),
            __( 'DESC', 'featured-posts' ),
        );
        printf( "<select class='regular-text' id='%s' name='%s' >", 'posts_order', 'posts_order' );
        foreach( $orders as $order ){
            $selected = '';
            if( $option == $order ) {
                $selected = "Selected";
            }
            printf( "<option value='%s' %s >%s</option>", $order, $selected, $order );
        }
        echo "</select>";
    }

    /**
     * Post category field display function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function post_category_display() {
        $option = get_option( 'posts_category' );
        $categories = get_categories();
        foreach( $categories as $category ){
            echo '<input type="checkbox" id="'.$category->cat_ID.'" name="posts_category['. $category->slug .']" value="'. $category->slug .'"'.checked( $category->slug, $option, false ).'>';
            echo '<label for="'. $category->slug .'">'. $category->name .'</label><br>';
        }
    }
}
