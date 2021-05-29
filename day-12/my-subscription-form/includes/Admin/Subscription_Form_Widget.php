<?php

namespace Subscription\Form\Admin;

/**
 * The min class of widget.
 */
class Subscription_Form_Widget extends \WP_Widget {
    
    /**
     * Register widget with WordPress
     *
     * @since  1.0.0
     */
    function __construct() {
        parent::__construct(
            'subscription-form-widget',
            'Subscription Form Widget'
        );

        add_action( 'widgets_init', [ $this, 'subscription_form_register' ] );
    }

    /**
     * Widget register callback render function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function subscription_form_register() {
        register_widget( 'Subscription\Form\Admin\Subscription_Form_Widget' );
    }

    /**
     * Set Argument
     *
     * @var array
     */
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div>'
    );

    /**
     * Front-end display of widget.
     *
     * @since 1.0.0
     * 
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     * 
     * @return void
     */
    public function widget( $args, $instance ) {
        wp_enqueue_script( 'form-script' );
        echo $args['before_widget'];
        
        $title          = ! empty( $instance['title'] ) ? $instance['title']                  : '';
        $mailchimp_list = ! empty( $instance['mailchimp_list'] ) ? $instance['mailchimp_list']: '';

        echo $args['before_title'] . '<h2>' . apply_filters( 'widget_title', $title  ) . '</h2>' . $args['after_title'];
        
        $template = __DIR__ . '/views/view_subscription_widget.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }

        echo $args['after_widget'];
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
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '';

        $api_key = get_option( 'mailchimp_link' );
        $dc      = substr($api_key,strpos($api_key,'-')+1);
        $args    = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( 'user:'. $api_key )
            )
        );
        $response = wp_remote_get( 'https: //'.$dc.'.api.mailchimp.com/3.0/lists/', $args );
        $body     = json_decode( wp_remote_retrieve_body( $response ) );
        
        if ( wp_remote_retrieve_response_code( $response ) == 200 ) {
            
            foreach ( $body->lists as $list ) {
                $audience_list_name = $list->name;
                $list_id            = $list->id;
            }

        } else {
            echo '<b>' . wp_remote_retrieve_response_code( $response ) . wp_remote_retrieve_response_message( $response ) . ':</b> ' . $body->detail;
        }

        $template = __DIR__ . '/views/view_subscription_form.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     * 
     * @since 1.0.0
     * 
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                   = array();
        $instance['title']          = ( !empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] )                  : '';
        $instance['mailchimp_list'] = ( !empty( $new_instance['mailchimp_list'] ) ) ? sanitize_text_field( $new_instance['mailchimp_list'] ): '';
        
        return $instance;
    }
}