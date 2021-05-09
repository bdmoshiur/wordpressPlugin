<?php
namespace Formsubmit\Ajax\Admin;

/**
 * Check WP_list table exists or not.
 * 
 * @since 1.0.0
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * The main List table class
 * 
 * @since 1.0.0
 */
class Address_List extends \WP_List_Table {
    /**
     * Constructor function
     * 
     * @since 1.0.0
     */
    function __construct() {
        parent::__construct( [
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => 'ajax',
        ] );
    }

    /**
     * column get function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function get_columns() {
        return [
            'cb' => "<input type='checkbox'>",
            'fname' => __( 'First Name', 'form_submit_ajax' ),
            'lname' => __( 'Last Name', 'form_submit_ajax' ),
            'email' => __( 'Email', 'form_submit_ajax' ),
            'message' => __( 'Message', 'form_submit_ajax' ),
            'created_at' => __( 'Date', 'form_submit_ajax' ),
        ];
    }

    /**
     * Sortable column get function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    function get_sortable_columns() {
        $sortable_columns = [
            'fname'       => [ 'fname', true ],
            'created_at' => [ 'created_at', true ],
        ];

        return $sortable_columns;
    }

    /**
     * Default column set function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'value':
                # code...
                break;
            default:
            
                return isset( $item->$column_name ) ? $item->$column_name : '';
                break;
        }
    }

    /**
     * Column First name set function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function column_fname( $item ) {
        $actions = [];
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-af-delete-address&id=' . $item->id ), 'wd-af-delete-address' ), $item->id, __( 'Delete', 'form_submit_ajax' ), __( 'Delete', 'form_submit_ajax' ) );
        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=user-information&action=view&id' . $item->id ), $item->fname, $this->row_actions( $actions )
        );
    }

    /**
     * Column checkbox set function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="address_id[]" value="%d" >' , $item->id
        );
    }
    
    /**
     * Prepare item set function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $column, $hidden, $sortable ];

        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items = wp_af_get_address( $args );

        $this->set_pagination_args( [
            'total_items' => wp_af_count_address(),
            'per_page'    => $per_page
        ] );
    }
}