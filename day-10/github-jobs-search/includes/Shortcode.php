<?php
namespace Jobs\Search;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initialize the class
     *
     * @since  1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_shortcode( 'search-jobs', [ $this, 'jobs_search_form_render' ] );
    }

    /**
     * Jobs searching form renderer function
     *
     * @since  1.0.0
     *
     * @param array $atts
     *
     * @return void
     */
    public function jobs_search_form_render( $atts ) {
        $atts = shortcode_atts( apply_filters( 'mrm-jobs-search-fields',
                [
                    'keyword'  => '',
                    'location' => '',
                    'fulltime' => '',
                ] 
            ),
            $atts
        );

        ob_start();
        include MRM_JOBS_SEARCH_PATH . '/templates/jobs_search_page.php';
        echo ob_get_clean();

        $job_search_keyword  = isset( $_REQUEST['search-keyword'] ) ? sanitize_text_field( $_REQUEST['search-keyword'] ) : $atts['keyword'];
        $job_search_location = isset( $_REQUEST['search-location'] ) ? sanitize_text_field( $_REQUEST['search-location'] ) :  $atts['location'];
        $job_search_fulltime = isset( $_REQUEST['search-fulltime'] ) ? sanitize_text_field( $_REQUEST['search-fulltime'] ) : $atts['fulltime'];

        $job_search_url      = 'https://jobs.github.com/positions.json?';
        $job_search_args     = [
            'timeout' => 120,
        ];

        if ( ! empty( $job_search_keyword ) ) {
            $job_search_url .= '&description=' . $job_search_keyword;
        }

        if ( ! empty( $job_search_location ) ) {
            $job_search_url .= '&location=' . $job_search_location;
        }

        if ( ! empty( $job_search_fulltime ) ) {
            $job_search_url .= '&full_time=' . $job_search_fulltime;
        }

        if ( isset( $_REQUEST['search-id'] ) ) {
            $job_search_url = 'https://jobs.github.com/positions/' . $_REQUEST['search-id'] . '.json';
        }

        $job_search_response = wp_remote_get( $job_search_url , $job_search_args );
        $job_search_body     = wp_remote_retrieve_body( $job_search_response );
        $job_search_result   = json_decode( $job_search_body );

        if ( empty( $job_search_result ) ) {
            echo 'search jobs not found!';
        }

        if ( is_array( $job_search_result ) ) {
            foreach ( $job_search_result as $single_job_search ) {
                include MRM_JOBS_SEARCH_PATH . '/templates/job_view_list_page.php';
            }
        }

        if ( is_object( $job_search_result ) ) {
            include MRM_JOBS_SEARCH_PATH . '/templates/view_single_job_page.php';
        }
    }
}
