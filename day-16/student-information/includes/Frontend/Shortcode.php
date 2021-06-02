<?php

namespace Student\Info\Frontend;

/**
 * Shortcode handle class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Shortcode {

    use \Student\Info\Traits\Form_Error;
    /**
     * initialize the class
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'si_student_insert', [ $this, 'render_student_info' ] );
        add_shortcode( 'si_student_show', [ $this, 'render_student_show' ] );

        add_action( 'init', [ $this, 'handle_form_submit'] );
    }
    
    /**
     * Shortcode handle class
     * 
     * @since 1.0.0
     * 
     * @param array $atts
     * @param string $content
     * 
     * @return string
     */
    public function render_student_info( $atts, $content = '' ) {
        $template = __DIR__ . '/views/register-student.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    public function handle_form_submit() {
        if ( ! isset( $_POST['std_info'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-info' ) ) {
            wp_die( __( 'Are you cheating?', 'student-info' ) );
        }

        $first_name     = isset( $_REQUEST['first_name'] ) ? sanitize_text_field( $_REQUEST['first_name'] )        : '';
        $last_name      = isset( $_REQUEST['last_name'] ) ? sanitize_text_field( $_REQUEST['last_name'] )          : '';
        $class          = isset( $_REQUEST['class'] ) ? sanitize_text_field( $_REQUEST['class'] )                  : '';
        $roll           = isset( $_REQUEST['roll'] ) ? sanitize_text_field( $_REQUEST['roll'] )                    : '';
        $reg_no         = isset( $_REQUEST['reg_no'] ) ? sanitize_text_field( $_REQUEST['reg_no'] )                : '';

        $bangla         = isset( $_REQUEST['bangla'] ) ? sanitize_text_field( $_REQUEST['bangla'] )                : '';
        $english        = isset( $_REQUEST['english'] ) ? sanitize_text_field( $_REQUEST['english'] )              : '';
        $math           = isset( $_REQUEST['math'] ) ? sanitize_text_field( $_REQUEST['math'] )                    : '';
        $data_structure = isset( $_REQUEST['data_structure'] ) ? sanitize_text_field( $_REQUEST['data_structure'] ): '';

        if ( empty( $first_name ) ) {
            $this->errors['first_name'] = __( 'Please provide a first Name', 'student-info' );
        }

        if ( empty( $last_name ) ) {
            $this->errors['last_name'] = __( 'Please provide a last name', 'student-info' );
        }

        if ( empty( $class ) ) {
            $this->errors['class'] = __( 'Please provide a class', 'student-info' );
        }

        if ( empty( $roll ) ) {
            $this->errors['roll'] = __( 'Please provide a roll', 'student-info' );
        }

        if ( empty( $reg_no ) ) {
            $this->errors['reg_no'] = __( 'Please provide a reg_no', 'student-info' );
        }

        if ( empty( $bangla ) ) {
            $this->errors['bangla'] = __( 'Please provide a bangla number', 'student-info' );
        }

        if ( empty( $english ) ) {
            $this->errors['english'] = __( 'Please provide a english number', 'student-info' );
        }

        if ( empty( $math ) ) {
            $this->errors['math'] = __( 'Please provide a math numder', 'student-info' );
        }

        if ( empty( $data_structure ) ) {
            $this->errors['data_structure'] = __( 'Please provide a data structure number', 'student-info' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'class'      => $class,
            'roll'       => $roll,
            'reg_no'     => $reg_no,
        ];
        
        $insert_id = insert_student_info( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        $data = [
            'bangla'         => $bangla,
            'english'        => $english, 
            'math'           => $math, 
            'data_structure' => $data_structure,
        ];

        $result = update_student_meta( $insert_id, 'sn_subject_num', $data  );

        if ( is_wp_error( $result ) ) {
            wp_die( $result->get_error_message() );
        }

        $_REQUEST = [];
    }

    /**
     * Render student show function
     * 
     * @since 1.0.0
     * 
     * @param array $atts
     * @param string $content
     * 
     * @return void
     */
    public function render_student_show( $atts, $content = '' ) {
        $paged      = ! empty( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $per_page   = 3;
        $total_page = ceil( si_student_count()/$per_page );
        $offset     = ( $paged - 1 ) * $per_page;

        $args = [
            'paged'  => $per_page,
            'offset' => $offset,
        ];
        $students = si_get_student_info( $args );

        $template = __DIR__ . '/views/list-student.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}
