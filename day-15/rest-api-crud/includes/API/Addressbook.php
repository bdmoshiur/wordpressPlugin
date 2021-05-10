<?php
namespace Wedevs\Academy\API;

use WP_REST_Controller;
use WP_REST_Server;
use WP_Error;

/**
 * The Rest Api main class
 */
class Addressbook extends WP_REST_Controller {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        $this->namespace = 'academy/v1';
        $this->rest_base = 'contacts';
    }

    /**
     * All register function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function register_routes() {
        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_items' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_colection_params(),
                ],
                [
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'create_item' ],
                    'permission_callback' => [ $this, 'create_item_permissions_check' ],
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                ],
                'schema' => [ $this, 'get_item_schema' ],
            ]
        );

        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base . '/(?p<id>[\id]+)',
            [
                'args' => [
                    'id' => [
                        'description' => 'Unique identifier for the object',
                        'type' => 'integer',
                    ],
                ],
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_item' ],
                    'permission_callback' => [ $this, 'get_item_permissions_check' ],
                    'args'                => [
                        'context' => $this->get_context_param( ['default', 'view'] ),
                    ],
                ],
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_item' ],
                    'permission_callback' => [ $this, 'update_item_permissions_check' ],
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                ],
                [
                    'methods'             => WP_REST_Server::DELETABLE,
                    'callback'            => [ $this, 'delete_item' ],
                    'permission_callback' => [ $this, 'delete_item_permissions_check' ],
                ],
                'schema' => [ $this, 'get_item_schema' ],
            ]
        );
    }

    /**
     * Permission check function
     * 
     * @since 1.0.0
     * 
     * @return boolean
     */
    public function get_items_permissions_check( $request ) {
        
        if ( current_user_can( 'manage_options' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Data get function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function get_items( $request ) {
        $args   = [];
        $params = $this->get_colection_params();
        foreach ($params as $key => $value) {

            if ( isset( $request[ $key ] ) ) {
                $args[ $key ] = $request[ $key ];
            }
        }

        $args['number'] = $args['per_page'];
        $args['offset'] = $args['number'] * ( $args['page'] - 1 );

        unset( $args['per_page'] );
        unset( $args['page'] );
        
        $data = [];
        $contacts = wp_ac_get_address( $args );

        foreach ($contacts as $contact ) {
            $response = $this->prepare_item_for_response( $contact, $request );
            $data[]   = $this->prepare_response_for_colection( $response );
        }

        $total = wp_ac_count_address();
        $max_pages = ceil( $total / (int)$args['number'] );

        $response = rest_ensure_response( $data );

        $response->header('x-WP-Total', (int) $total );
        $response->header('x-WP-TotalPages', (int) $max_pages );

        return $response;
    }

    /**
     * single contact get function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    protected function get_contact( $id ) {
        $contact = wp_ac_get_address( $id );

        if ( ! $contact ) {
            return new WP_Error(
                'rest_contact_invalid_id',
                'Invalid Contact ID',
                ['status' => 404]
            );
        }

        return $contact;
    }

    /**
     * permission check function
     *
     * @since 1.0.0
     * 
     * @param [type] $request
     * 
     * @return void
     */
    public function get_item_permissions_check( $request ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }
        $contact = $this->get_contact( $request['id'] );

        if ( is_wp_error( $contact ) ) {
            return $contact;
        }
        
        return true;
    }

    /**
     * Data get function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function get_item() {
        $contact = $this->get_contact( $request['id'] );
        $response = $this->prepare_item_for_response( $contact, $request );
        $response = rest_ensure_response( $response );

        return $response;
    }

    /**
     * create item
     * 
     * @since 1.0.0
     * 
     * @return int
     */
    public function create_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    /**
     * item create functon
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function create_item( $request ) {

        $contact = $this->prepare_item_for_database( $request );
        if ( is_wp_error( $contact ) ) {
            return $contact;
        }

        $contact_id = wp_ac_insert_address( $contact );
        if ( is_wp_error( $contact_id ) ) {
            $contact_id->add_data( ['status' => 400] );

            return $contact_id;
        }

        $contact = $this->get_contact( $contact_id );
        $response = $this->prepare_item_for_response( $contact, $request );
        
        $response->get_status( 201 );
        $response->header('location', rest_url( sprintf('%s$s%d', $this->namespace, $this->rest_base, $contact_id ) ) );

        return rest_ensure_response( $response );
    }

    /**
     * update idem function
     * 
     * @since 1.0.0
     * 
     * @return int
     */
    public function update_item_permissions_check() {
        return $this->get_item_permissions_check( $request );
        
    }

    /**
     * item update function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function update_item( $request ) {
        $contact  = $this->get_contact( $request['id'] );
        $prepared = $this->prepare_item_for_database( $request );

        $prepared = array_marge( (array) $contact, $prepared );

        $updated  = wp_ac_insert_address( $prepared );

        if ( ! $updated ) {
            return new WP_Error(
                'rest_not_updated',
                'Sorry, The address could not be updated !',
                ['status' => 400 ]
            );
        }

        $contact  = $this->get_contact( $request['id'] );
        $response = $this->prepare_item_for_response( $contact, $request );

        return rest_ensure_response($response);
    }

    /**
     * Delete item permission check
     * 
     * @since 1.0.0
     * 
     * @return int
     */
    public function delete_item_permissions_check( $request ) {
        return $this->get_item_permissions_check( $request );
    }

    /**
     * Item delete function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function delete_item( $request ) {
        $contact = $this->get_contact( $request['id'] );
        $previous = $this->prepare_item_for_response( $contact, $request );
        $delete = wp_ac_delete_address( $request['id'] );

        if ( ! $delete ) {
            return new WP_Error(
                'rest_not_deleted',
                'Sorry, The address could not be deleted !',
                ['status' => 400]
            );
        }

        $data = [
            'deleted' => true,
            'previous' => $previous->get_data(),
        ];

        $response = rest_ensure_response( $data );
        return $data;
    }

    /**
     * Prepare item for database function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function prepare_item_for_database( $request ) {
        $prepared = [];

        if ( isset( $request['name'] ) ) {
            $prepared['name'] = $request['name'];
        }

        if ( isset( $request['address'] ) ) {
            $prepared['address'] = $request['address'];
        }

        if ( isset( $request['phone'] ) ) {
            $prepared['phone'] = $request['phone'];
        }

        return $prepared;
    }

    /**
     * Prepares the item for the REST response.
     *
     * @since 4.7.0
     *
     * @param mixed  $item    WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function prepare_item_for_response( $item, $request ) {
        $data   = [];
        $fields = $this->get_fields_for_response( $request );

        if ( in_array( 'id', $fields, true ) ) {
            $data['id'] = (int) $item->id;
        }

        if( in_array( 'name', $fields, true ) ) {
            $data['name'] = (int) $item->name;
        }

        if ( in_array( 'address', $fields, true ) ) {
            $data['address'] = $item->address;
        }

        if ( in_array( 'phone', $fields, true ) ) {
            $data['phone'] = $item->phone;
        }

        if ( in_array( 'date', $fields, true ) ) {
            $data['date'] = mysql_to_rfc3339( $item->created_at );
        }

        $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
        $data = filter_response_by_contex( $data, $context );

        $response = rest_ensure_response( $data );
        $response->add_links( $this->prepare_links( $item ) );
        
        return $response;
    }

    /**
     * prepare link function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    protected function prepare_links( $item ) {
        $base = sprintf( '%s/%s', $this->namespace, $this->rest_base );
     
        $links = array(
            'self'       => array(
                'href' => rest_url( trailingslashit( $base ) . $item->ID ),
            ),
            'collection' => array(
                'href' => rest_url( $base ),
            ),
        );
     
        return $links;
    }

    /**
     * Schema setup function
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function get_item_schema() {

        if ( $this->schema ) {
            return $this->add_additional_fields_schema( $this->schema );
        }

        $schema = [
            "$schema"   => "https: //json-schema.org/draft/2020-12/schema",
            "title"     => "contact",
            "type"      => "object",
            "propertis" => [

                "id" => [
                    "description" => "The unique identifier for a contact",
                    "type"        => "integer",
                    "contex"      => [ 'view', 'edit' ],
                    "readonly"    => true,
                ],

                "name" => [
                    "description" => "Name of the contact",
                    "type"        => "string",
                    "contex"      => [ "view", "edit" ],
                    "required"    => true,
                    "arg_options" => [
                        "sanitize_callback" => "sanitize_textarea_field",
                    ],
                ],

                "address" => [
                    "description" => "Name of the address",
                    "type"        => "string",
                    "contex"      => [ "view", "edit" ],
                    "arg_options" => [
                        "sanitize_callback" => "sanitize_textarea_field",
                    ],
                ],

                "phone" => [
                    "description" => "Name of the phone",
                    "type"        => "string",
                    "contex"      => [ "view", "edit" ],
                    "required"    => true,
                    "arg_options" => [
                        "sanitize_callback" => "sanitize_textarea_field",
                    ],
                ],

                "date" => [
                    "description" => "Name of the address",
                    "type"        => "string",
                    "contex"      => [ "view" ],
                    "format"      => "date-time",
                    "readonly"    => true,
                ],
            ],
        ];

        $this->schema = $schema;

        return $this->add_additional_fields_schema( $this->schema );
    }

    /**
     * colection parametter function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function get_colection_params() {
        $params = parent::get_colection_params();
        unset( $params['search'] );

        return $params;
    }
}