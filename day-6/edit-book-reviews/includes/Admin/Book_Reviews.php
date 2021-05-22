<?php
namespace Ubrp\Book\Review\Admin;

/**
 * The main class of title capitalize plugin 
 * 
 * @since 1.0.0
 */
class Book_Reviews {

    /**
     * Constructor function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'init', [ $this, 'mrm_book_reviews_init' ] );
        add_action( 'add_meta_boxes', [ $this, 'book_review_meta_box_add' ] );
        add_action( 'save_post', [ $this, 'book_reviews_metabox_save' ], 10, 2 );
    }

    /**
     * Register a custom post type called "book".
     *
     * @see get_post_type_labels() for label keys.
     */
    public function mrm_book_reviews_init() {
        $labels = [
            'name'                  => _x( 'Books', 'Post type general name', 'edit-book-reviews' ),
            'singular_name'         => _x( 'Book', 'Post type singular name', 'edit-book-reviews' ),
            'menu_name'             => _x( 'Books', 'Admin Menu text', 'edit-book-reviews' ),
            'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'edit-book-reviews' ),
            'add_new'               => __( 'Add New', 'edit-book-reviews' ),
            'add_new_item'          => __( 'Add New Book', 'edit-book-reviews' ),
            'new_item'              => __( 'New Book', 'edit-book-reviews' ),
            'edit_item'             => __( 'Edit Book', 'edit-book-reviews' ),
            'view_item'             => __( 'View Book', 'edit-book-reviews' ),
            'all_items'             => __( 'All Books', 'edit-book-reviews' ),
            'search_items'          => __( 'Search Books', 'edit-book-reviews' ),
            'parent_item_colon'     => __( 'Parent Books:', 'edit-book-reviews' ),
            'not_found'             => __( 'No books found.', 'edit-book-reviews' ),
            'not_found_in_trash'    => __( 'No books found in Trash.', 'edit-book-reviews' ),
            'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'edit-book-reviews' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'edit-book-reviews' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'edit-book-reviews' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'edit-book-reviews' ),
            'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'edit-book-reviews' ),
            'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'edit-book-reviews' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'edit-book-reviews' ),
            'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'edit-book-reviews' ),
            'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'edit-book-reviews' ),
            'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'edit-book-reviews' ),
        ];
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'book'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
            'taxonomies'         => ['subjects' , 'category' , 'post_tag'],
        ];
        register_post_type( 'book', $args );
    }

    /**
     * Meta box add function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function book_review_meta_box_add() {
        add_meta_box( 'book_review_meta_boox', __( 'Book Information', 'edit-book-reviews' ), [ $this, 'book_reviews_meta_box_information' ], 'book', 'side', 'high' );
    }
    
    /**
     * Meta box field show function
     *
     * @since 1.0.0
     * 
     * @param object $post
     * 
     * @return void
     */
    public function book_reviews_meta_box_information( $post ) {
        $book_name_show      = get_post_meta( $post->ID, 'br_book_name' , true );
        $book_date_show      = get_post_meta( $post->ID, 'br_book_date' , true );
        $book_code_show      = get_post_meta( $post->ID, 'br_book_code' , true );
        $author_name_show    = get_post_meta( $post->ID, 'br_book_author_name' , true );
        $author_email_show   = get_post_meta( $post->ID, 'br_book_email' , true );
        $author_address_show = get_post_meta( $post->ID, 'br_book_address' , true );
        ob_start();
        ?>
        <?php wp_nonce_field( 'book_reviews_meta_box_information', 'book_reviews_nonce' ); ?>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="bookName" class="form-label"><?php esc_html_e( 'Book Name', 'edit-book-reviews' ); ?></label>
                    <input type="text" class="form-control widefat" id="bookName" name="name" value="<?php esc_attr_e( $book_name_show ); ?>" placeholder="Book Name">
                </div>
                <div class="col-md-3 form-group">
                    <label for="bookPublish" class="form-label"><?php  esc_html_e( 'Book Publish Date', 'edit-book-reviews' ); ?></label>
                    <input type="date" class="form-control widefat" id="bookPublish" value="<?php esc_attr_e( $book_date_show ); ?>" name="date">
                </div>
                <div class="col-md-2 form-group">
                    <label for="bookCode" class="form-label"><?php esc_html_e( 'Zip', 'edit-book-reviews' ); ?></label>
                    <input type="text" class="form-control widefat" id="bookCode" name="code" value="<?php esc_attr_e( $book_code_show ); ?>" placeholder="Code">
                </div>
                <div class="col-md-3 form-group">
                    <label for="authorName" class="form-label"><?php  esc_html_e( 'Author Name', 'edit-book-reviews' ); ?></label>
                    <input type="text" class="form-control widefat" id="bookName" name="author_name" value="<?php esc_attr_e( $author_name_show ); ?>" placeholder="Book Name">
                </div>
                <div class="col-md-6 form-group">
                    <label for="bookEmail" class="form-label"><?php  esc_html_e( 'Author Email', 'edit-book-reviews' ); ?></label>
                    <input type="email" class="form-control widefat" id="bookEmail" name="email" value="<?php esc_attr_e( $author_email_show ); ?>" placeholder="Email">
                </div>
                <div class="col-12 form-group">
                    <label for="authorAddress" class="form-label"><?php  esc_html_e( 'Author Address', 'edit-book-reviews' ); ?></label>
                    <textarea class="form-control widefat" id="authorAddress" name="address" placeholder="Address" rows="5"><?php esc_attr_e( $author_address_show ); ?></textarea>
                </div>
            </div>
        <?php
        echo ob_get_clean();
    }
   
    /**
     * Meta box data save function
     *
     * @since 1.0.0
     * 
     * @param [type] $post_ID
     * @param [type] $post
     * 
     * @return void
     */
    public function book_reviews_metabox_save( $post_ID, $post ) {
        /**
         * Retrive data in database
         */
        $nonce          = isset( $_POST['book_reviews_nonce'] ) ? $_POST['book_reviews_nonce']         : '';
        $book_name      = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] )              : "";
        $publish_date   = isset( $_POST['date'] ) ? $_POST['date']                                     : "";
        $book_code      = isset( $_POST['code'] ) ? sanitize_text_field( $_POST['code']  )             : "";
        $author_name    = isset( $_POST['author_name'] ) ? sanitize_text_field( $_POST['author_name'] ): "";
        $author_email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] )                 : "";
        $author_address = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] )    : "";

        /**
         * Nonce verify check
         * 
         * @since 1.0.0
         * 
         * @return string
         */
        if ( ! wp_verify_nonce( $nonce, 'book_reviews_meta_box_information' ) ) {
            return;
        }

        /**
         * Save input data in database
         */
        update_post_meta( $post_ID, 'br_book_name', $book_name );
        update_post_meta( $post_ID, 'br_book_date', $publish_date );
        update_post_meta( $post_ID, 'br_book_code', $book_code );
        update_post_meta( $post_ID, 'br_book_author_name', $author_name );
        update_post_meta( $post_ID, 'br_book_email', $author_email );
        update_post_meta( $post_ID, 'br_book_address', $author_address );
    }
}