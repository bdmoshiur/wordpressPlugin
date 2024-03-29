<?php

namespace Rest\Product\API;

use WP_REST_Controller;
use WP_REST_Server;
use WP_Error;

/**
 * Addressbook Class
 */
class Product extends WP_REST_Controller {

    /**
     * Initialize the class
     * 
     * @since 1.0.0
     */
    function __construct() {
        $this->namespace = 'product/v1';
        $this->rest_base = 'contacts';
    }

    /**
     * Registers the routes for the objects of the controller.
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
                    'args'                => $this->get_collection_params(),
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
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            [
                'args'   => [
                    'id' => [
                        'description' => __( 'Unique identifier for the object.', 'wedevs-academy' ),
                        'type'        => 'integer',
                    ],
                ],
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_item' ],
                    'permission_callback' => [ $this, 'get_item_permissions_check' ],
                    'args'                => [
                        'context' => $this->get_context_param( [ 'default' => 'view' ] ),
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
     * Checks if a given request has access to read contacts.
     * 
     * @since 1.0.0
     * 
     * @param  \WP_REST_Request $request
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
     * Retrieves a list of address items.
     *
     * @since 1.0.0
     * 
     * @param  \WP_Rest_Request $request
     *
     * @return \WP_Rest_Response|WP_Error
     */
    public function get_items( $request ) {
        $args = [];
        $params = $this->get_collection_params();

        foreach ( $params as $key => $value ) {
            if ( isset( $request[ $key ] ) ) {
                $args[ $key ] = $request[ $key ];
            }
        }

        // change `per_page` to `number`
        $args['number'] = $args['per_page'];
        $args['offset'] = $args['number'] * ( $args['page'] - 1 );

        // unset others
        unset( $args['per_page'] );
        unset( $args['page'] );

        $data     = [];
        $contacts = wp_ac_get_address( $args );

        foreach ( $contacts as $contact ) {
            $response = $this->prepare_item_for_response( $contact, $request );
            $data[]   = $this->prepare_response_for_collection( $response );
        }

        $total     = wp_ac_count_address();
        $max_pages = ceil( $total / (int) $args['number'] );

        $response = rest_ensure_response( $data );

        $response->header( 'X-WP-Total', (int) $total );
        $response->header( 'X-WP-TotalPages', (int) $max_pages );

        return $response;
    }

    /**
     * Get the address, if the ID is valid.
     *
     * @since 1.0.0
     * 
     * @param int $id Supplied ID.
     *
     * @return Object|\WP_Error
     */
    protected function get_contact( $id ) {
        $contact = wp_ac_get_address( $id );

        if ( ! $contact ) {
            return new WP_Error(
                'rest_contact_invalid_id',
                __( 'Invalid contact ID.', 'wedevs-academy' ),
                [ 'status' => 404 ]
            );
        }

        return $contact;
    }

    /**
     * Get the address, if the ID is valid.
     *
     * @since 1.0.0
     * 
     * @param int $id Supplied ID.
     *
     * @return Object|\WP_Error
     */
    protected function get_single_contact( $id ) {
        $contact = wp_ac_get_single_address( $id );

        if ( ! $contact ) {
            return new WP_Error(
                'rest_contact_invalid_id',
                __( 'Invalid contact ID.', 'wedevs-academy' ),
                [ 'status' => 404 ]
            );
        }

        return $contact;
    }

    /**
     * Checks if a given request has access to get a specific item.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|bool
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
     * Retrieves one item from the collection.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     */
    public function get_item( $request ) {
        $contact = $this->get_single_contact( $request['id'] );
        $response = $this->prepare_item_for_response( $contact, $request );
        
        $response = rest_ensure_response( $response );

        return $response;
    }

    /**
     * Checks if a given request has access to create items.
     *
     * @since 1.0.0
     * 
     * @param WP_REST_Request $request
     *
     * @return WP_Error|bool
     */
    public function create_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    /**
     * Creates one item from the collection.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|WP_REST_Response
     */
    public function create_item( $request ) {
        $contact = $this->prepare_item_for_database( $request );

        if ( is_wp_error( $contact ) ) {
            return $contact;
        }

        $contact_id = wp_ac_insert_address( $contact );

        if ( is_wp_error( $contact_id ) ) {
            $contact_id->add_data( [ 'status' => 400 ] );

            return $contact_id;
        }

        $contact = $this->get_single_contact( $contact_id );
        $response = $this->prepare_item_for_response( $contact, $request );

        $response->set_status( 201 );
        $response->header( 'Location', rest_url( sprintf( '%s/%s/%d', $this->namespace, $this->rest_base, $contact_id ) ) );

        return rest_ensure_response( $response );
    }

    /**
     * Checks if a given request has access to update a specific item.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request Full data about the request.
     *
     * @return \WP_Error|bool
     */
    public function update_item_permissions_check( $request ) {
        return $this->get_item_permissions_check( $request );
    }

    /**
     * Updates one item from the collection.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|\WP_REST_Response
     */
    public function update_item( $request ) {
        $contact  = $this->get_single_contact( $request['id'] );
        $prepared = $this->prepare_item_for_database( $request );

        $prepared = array_merge( (array) $contact, $prepared );

        $updated = wp_ac_insert_address( $prepared );

        if ( ! $updated ) {
            return new WP_Error(
                'rest_not_updated',
                __( 'Sorry, the address could not be updated.', 'wedevs-academy' ),
                [ 'status' => 400 ]
            );
        }

        $contact  = $this->get_single_contact( $request['id'] );
        $response = $this->prepare_item_for_response( $contact, $request );

        return rest_ensure_response( $response );
    }

    /**
     * Checks if a given request has access to delete a specific item.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|bool
     */
    public function delete_item_permissions_check( $request ) {
        return $this->get_item_permissions_check( $request );
    }

    /**
     * Deletes one item from the collection.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|WP_REST_Response
     */
    public function delete_item( $request ) {
        $contact  = $this->get_single_contact( $request['id'] );
        $previous = $this->prepare_item_for_response( $contact, $request );

        $deleted = wp_ac_delete_address( $request['id'] );

        if ( ! $deleted ) {
            return new WP_Error(
                'rest_not_deleted',
                __( 'Sorry, the address could not be deleted.', 'wedevs-academy' ),
                [ 'status' => 400 ]
            );
        }

        $data = [
            'deleted'  => true,
            'previous' => $previous->get_data(),
        ];

        $response = rest_ensure_response( $data );

        return $data;
    }

    /**
     * Prepares one item for create or update operation.
     *
     * @since 1.0.0
     * 
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|object
     */
    protected function prepare_item_for_database( $request ) {
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
     * @since 1.0.0
     * 
     * @param mixed $item    WordPress representation of the item.
     * @param \WP_REST_Request $request Request object.
     *
     * @return \WP_Error|WP_REST_Response
     */
    public function prepare_item_for_response( $item, $request ) {
        $data   = [];
        $fields = $this->get_fields_for_response( $request );

        if ( in_array( 'id', $fields, true ) ) {
            $data['id'] = (int) $item->id;
        }

        if ( in_array( 'name', $fields, true ) ) {
            $data['name'] = $item->name;
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
        $data    = $this->filter_response_by_context( $data, $context );

        $response = rest_ensure_response( $data );
        $response->add_links( $this->prepare_links( $item ) );

        return $response;
    }

    /**
     * Prepares links for the request.
     *
     * @since 1.0.0
     * 
     * @param \WP_Post $post Post object.
     *
     * @return array Links for the given post.
     */
    protected function prepare_links( $item ) {
        $base = sprintf( '%s/%s', $this->namespace, $this->rest_base );

        $links = [
            'self' => [
                'href' => rest_url( trailingslashit( $base ) . $item->id ),
            ],
            'collection' => [
                'href' => rest_url( $base ),
            ],
        ];

        return $links;
    }

    /**
     * Retrieves the contact schema, conforming to JSON Schema.
     *
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_item_schema() {
        if ( $this->schema ) {
            return $this->add_additional_fields_schema( $this->schema );
        }

        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'contact',
            'type'       => 'object',
            'properties' => [
                'id' => [
                    'description' => __( 'Unique identifier for the object.', 'wedevs-academy' ),
                    'type'        => 'integer',
                    'context'     => [ 'view', 'edit' ],
                    'readonly'    => true,
                ],
                'name' => [
                    'description' => __( 'Name of the contact.', 'wedevs-academy' ),
                    'type'        => 'string',
                    'context'     => [ 'view', 'edit' ],
                    'required'    => true,
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'address' => [
                    'description' => __( 'Address of the contact.', 'wedevs-academy' ),
                    'type'        => 'string',
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ],
                ],
                'phone' => [
                    'description' => __( 'Phone number of the contact.', 'wedevs-academy' ),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'date' => [
                    'description' => __( "The date the object was published, in the site's timezone.", 'wedevs-academy' ),
                    'type'        => 'string',
                    'format'      => 'date-time',
                    'context'     => [ 'view' ],
                    'readonly'    => true,
                ],
            ]
        ];

        $this->schema = $schema;

        return $this->add_additional_fields_schema( $this->schema );
    }

    /**
     * Retrieves the query params for collections.
     *
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_collection_params() {
        $params = parent::get_collection_params();

        unset( $params['search'] );

        return $params;
    }
}