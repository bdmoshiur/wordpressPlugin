<?php

namespace Cat\Facts\Admin;

/**
 * The Menu Handale Class
 */
class Cat_Widget {
    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'wp_dashboard_setup', [ $this,'cat_facts_add_dashboard_widgets'] );
    }

    /**
     * handle the setting class
     */
    public function cat_facts_add_dashboard_widgets()
    {
        if( current_user_can('manage_options') ) {
            wp_add_dashboard_widget(
                'cat_facts_dashboard_widget',                          
                esc_html__( 'Display Cat Facts', 'cat-facts' ),
                [ $this, 'cat_facts_dashboard_widget_render' ]
            ); 
        }
    }

    public function cat_facts_dashboard_widget_render() {
    
        $results = get_transient( 'cat_facts_transient' );
        if( false == $results ) {
          $url = 'https://cat-fact.herokuapp.com/facts/random?animal_type=cat&amount=5';
          $args = array( 
             'timeout' => 120,
            );
          $response = wp_remote_get( $url, $args );
          $results = json_decode( wp_remote_retrieve_body( $response ) );
          set_transient( 'cat_facts_transient', $results, DAY_IN_SECONDS );
        }
            $i = 1;
        foreach ($results as $result ) {
            echo '<div>';
            echo '<a href="">' . $i++ . ' ' . $result->text . '</a>'.'<br>';
            echo '</div>';
            
        }

        delete_transient( 'cat_facts_transient' );

    }
}