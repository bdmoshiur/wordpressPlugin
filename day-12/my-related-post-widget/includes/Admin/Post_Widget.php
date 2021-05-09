<?php
namespace Post\Widget\Admin;

/**
 * The min class of widget.
 */
class Post_Widget extends \WP_Widget {
    
    /**
     * Register widget with WordPress
     *
     * @since  1.0.0
     */
    function __construct() {
        parent::__construct(
            'related-post-widget',
            'Related Post Widget'
        );
        add_action( 'widgets_init', [ $this, 'related_post_widget_register' ] );
    }

    /**
     * Widget register function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function related_post_widget_register() {
        register_widget( 'Post\Widget\Admin\Post_Widget' );
    }

    /**
     * Front-end display of widget.
     *
     * @since 1.0.0
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     * 
     * @return mixed
     */
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div>'
    );
    public function widget( $args, $instance ) {
        if ( is_single() ) {
            
            echo $args['before_widget'];

            $title   = ! empty( $instance['title'] ) ? $instance['title']            : '';
            $limit   = ! empty( $instance['no-of-post'] ) ? $instance['no-of-post']  : 5;
            $image   = isset( $instance['show-image'] ) ? $instance['show-image']    : '';
            $excerpt = isset( $instance['show-excerpt'] ) ? $instance['show-excerpt']: '';

            echo $args['before_title'] . '<h2>' . apply_filters( 'widget_title', $title  ) . '</h2>' . $args['after_title'];

            $post_args = [
                'post_type'      => 'post',
                'category__in'   => wp_get_post_categories( get_the_ID() ),
                'post__not_in'   => array( get_the_ID() ),
                'posts_per_page' =>  $limit,
                'status'         => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];

            $the_query = new \WP_Query( $post_args );

            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    echo '<a href="'.get_the_permalink().'"><li>' . get_the_title() . '</li></a><br>';

                    if ( 1 == $excerpt ) {
                        echo '<h3>' . the_excerpt() . '</h3><br>';
                    }

                    if ( 1 == $image ) {
                        echo '<h3>' . get_the_post_thumbnail() . '</h3><br>';
                    }
                }
            }

            /* Restore original Post Data */
            wp_reset_postdata();

            echo $args['after_widget'];
        }
    }

    /**
     * Back-end widget form.
     *
     * @since 1.0.0
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     * 
     * @return void
     */
    public function form( $instance ) {
        $title        = ! empty( $instance['title'] ) ? $instance['title']              : '';
        $posts_no     = ! empty( $instance['no-of-post'] ) ? $instance['no-of-post']    : '';
        $show_image   = ! empty( $instance['show-image'] ) ? $instance['show-image']    : '';
        $show_excerpt = ! empty( $instance['show-excerpt'] ) ? $instance['show-excerpt']: '';

        $template = __DIR__ . '/views/view_post_widget.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     * @since 1.0.0
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                 = array();
        $instance['title']        = ( !empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] )              : '';
        $instance['no-of-post']   = ( !empty( $new_instance['no-of-post'] ) ) ? sanitize_text_field( $new_instance['no-of-post'] )    : '';
        $instance['show-image']   = ( !empty( $new_instance['show-image'] ) ) ? sanitize_text_field( $new_instance['show-image'] )    : '';
        $instance['show-excerpt'] = ( !empty( $new_instance['show-excerpt'] ) ) ? sanitize_text_field( $new_instance['show-excerpt'] ): '';

        return $instance;
    }
}