<?php
namespace We\Crud\Admin;

/**
 * WP_List_Table check
 * 
 * @since 1.0.0
 * 
 * @return string
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH .'wp-admin/includes/class-wp-list-table.php';
}

/**
 * The Address List class
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
class Address_list extends \WP_List_Table {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        parent::__construct( [
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false,
        ] );
    }

    /**
     * Get Columns functi
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function get_columns() {
        return [
            'cb'         => '<input type="checkbox" />',
            'name'       => __( 'Name', 'we-crud' ),
            'address'    => __( 'Address', 'we-crud' ),
            'phone'      => __( 'Phone', 'we-crud' ),
            'created_at' => __( 'Date', 'we-crud' ),
        ];
    }

    /**
     * Column sortable function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = [
            'name'       => [ 'name', true ],
            'created_at' => [ 'created_at', true ],
        ];

        return $sortable_columns;
    }
    
    /**
     * Column_default function
     *
     * @since 1.0.0
     * 
     * @param object $item
     * @param string $column_name
     * 
     * @return void
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'value':
                # code...
                break;

            default:
            return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Column name show function
     * 
     * @since 1.0.0
     * 
     * @param object $item
     * 
     * @return string
     */
    public function column_name( $item ) {
        $actions = [];
        $actions['edit'] = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( "admin.php?page=we-crud&action=edit&id=" . $item->id ), $item->id, __( 'Edit', 'we-crud' ), __( 'Edit', 'we-crud' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-fp-delete-address&id=' . $item->id ), 'wd-fp-delete-address' ), $item->id, __( 'Delete', 'we-crud' ), __( 'Delete', 'we-crud' ) );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( "admin.php?page=we-crud&action=view&id" . $item->id ), $item->name, $this->row_actions( $actions)
        );
    }

    /**
     * Check box show function
     *
     * @since 1.0.0
     * 
     * @param object $item
     * 
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="address_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Prepare_items function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function prepare_items() {
        $column                = $this->get_columns();
        $hidden                = [];
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = [ $column, $hidden, $sortable ];

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ($current_page - 1 ) * $per_page ;

        $args                  =  [
            'number'=> $per_page,
            'offset'=> $offset,
        ];
        $this->items           = wp_fp_get_address( $args );

        /**
         * Check column name sortable 
         * 
         * @since 1.0.0 
         */
        if( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }

        /**
         * Pagination set list table
         * 
         * @since 1.0.0
         */
        $this->set_pagination_args( [
            'total_items' => wp_fp_count_address(),
            'per_page'    => $per_page,
        ] );
    }
}
