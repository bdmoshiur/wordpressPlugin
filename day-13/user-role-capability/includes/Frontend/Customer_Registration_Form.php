<?php
namespace Userrole\Capability\Frontend;

/**
 * The Menu Handale Class
 */
class Customer_Registration_Form {
    /**
     * Initialize the class
     * 
     * @since 1.0.0
     */
    function __construct() {
        add_shortcode( 'user_registration_form', [ $this, 'render_user_registration_form' ] );
    }

    /**
     * Shortcode render function
     *
     * @since 1.0.0
     * 
     * @param [type] $atts
     * @param string $content
     * 
     * @return void
     */
    public function render_user_registration_form( $atts , $content ='' ) {
        if (  isset( $_POST['send_shortcode'] ) ) {

            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'nonce_from_shortcode' ) ) {
                wp_die( 'Aru you Cheating nonce' );
            }

            $uname      = isset( $_REQUEST['uname'] ) ?  sanitize_text_field( $_REQUEST['uname'] ): '';
            $email      = isset( $_REQUEST['email'] ) ?  sanitize_email( $_REQUEST['email'] )     : '';
            $password   = isset( $_REQUEST['password'] ) ? $_REQUEST['password']                  : '';
            $capability = isset( $_REQUEST['capability'] ) ? $_REQUEST['capability']              : '';
    
            $userdata   =  array(
                'user_login'    => $uname,
                'user_email'    => $email,
                'user_pass'     => $password,
                'first_name'    => $uname,
                'role'          => 'customer_role',
            );
            
            $user_id = wp_insert_user( $userdata );
    
            if ( is_wp_error( $user_id ) ) {
                echo __( 'Sorry, Something went wrong !', 'user-role-capability' );
            } else {
                $user = get_user_by( 'ID', $user_id );
                
                switch ( $capability ) {
                    case 'wholesale':
                        $data = [
                            'edit_posts'        => true,
                            'edit_users'        => true,
                            'upload_plugins'    => true,
                            'edit_others_posts' => true,
                            'publish_posts'     => true,
                            'read'              => true,
                        ];
    
                        foreach ( $data as $key => $value ) {
                            $user->add_cap( $key, $value );
                        }
                        break;
    
                    case 'retail':
                        $data = [
                            'edit_posts'        => true,
                            'edit_others_posts' => true,
                            'publish_posts'     => true,
                            'read'              => true,
                        ];
    
                        foreach ( $data as $key => $value ) {
                            $user->add_cap( $key, $value );
                        }
                        break;
                    
                    default:
                        $data = [
                            'publish_posts' => true,
                            'read'          => true,
                        ];
    
                        foreach ( $data as $key => $value ) {
                            $user->add_cap( $key, $value );
                        }
                        break;
                }
                echo __( 'Data inserted successfull', 'user-role-capability' );
            }
        }
        
        // Template loaded
        $template = __DIR__ . '/views/user_registration_sortcode.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}
