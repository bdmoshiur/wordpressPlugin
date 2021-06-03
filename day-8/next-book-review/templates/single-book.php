<?php

    /**
     * Get the themme header
     */
    get_header();

    /**
     * Enqueue all styles and scripts
     */
    wp_enqueue_style( 'nbr-rating-plugin-style' );
    wp_enqueue_style( 'nbr-book-review-style' );
    wp_enqueue_script( 'nbr-rating-plugin-script' );
    wp_enqueue_script( 'nbr-rating-handler-script' );

    global $post;

    /**
     * Get single post meta data
     */
    $single_post_name        = get_post_meta( $post->ID, 'book_meta_key_name', true );
    $single_post_date        = get_post_meta( $post->ID, 'book_meta_key_date', true );
    $single_post_code        = get_post_meta( $post->ID, 'book_meta_key_code', true );
    $single_post_price       = get_post_meta( $post->ID, 'book_meta_key_price', true );
    $single_post_description = get_post_meta( $post->ID, 'book_meta_key_description', true );

    /**
     * Fetching the rating data
     */
    $post_id = ! empty( get_the_ID() ) ? (int) get_the_ID(): 0;
    $args    = [
        'post_id' => $post_id,
    ];

    $book_rating_result = nbr_get_rating( $args );
    $book_rating        = isset( $book_rating_result->rating ) ? (float) $book_rating_result->rating : 0;
    $book_rating_id     = isset( $book_rating_result->id ) ? (int) $book_rating_result->id: '';

    /**
     * Single book template loaded
     */
?>
<div id="book-review-wrapper" class="container wrapper">
    <h2 class="book-title"><?php esc_html_e( $post->post_title ); ?></h2>

    <div class="book-review-content clearfix">
        <div class="book-review-thumb float-left">
            <img src="<?php esc_url( the_post_thumbnail_url() ); ?>" alt="<?php esc_attr_e( $post->post_title, 'nbr-book-review' ); ?>" />
        </div>

        <div class="book-review-details float-left">
            <ul class="book-review-details-list">
                <li>
                    <span><?php esc_html_e( 'Book Name', 'nbr-book-review' ); ?>: </span>
                    <?php esc_html_e( $single_post_name, 'nbr-book-review' ); ?>
                </li>
                <li>
                    <span><?php esc_html_e( 'Book Publishing Date', 'nbr-book-review' ); ?>: </span>
                    <?php echo esc_html( $single_post_date ); ?></li>
                <li>
                    <span><?php esc_html_e( 'Book Code', 'nbr-book-review' ); ?>: </span>
                    <?php esc_html_e( $single_post_code, 'nbr-book-review' ); ?></li>
                <li>
                    <span><?php esc_html_e( 'Book Price', 'nbr-book-review' ); ?>: </span>
                    Tk<?php esc_html_e( $single_post_price, 'nbr-book-review' ); ?></li>
                <li>
                    <span><?php esc_html_e( 'Book Short Description', 'nbr-book-review' ); ?>: </span>
                    <?php echo esc_textarea( $single_post_description, 'nbr-book-review' ); ?></li>
            </ul>

            <div class="rating book-rating" data-rate-value="<?php echo esc_attr( $book_rating ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-rating-id="<?php echo esc_attr( $book_rating_id ); ?>"></div>
            <p class="rating-status "></p>
        </div>
    </div>
</div>
<?php

/**
 * Get the themme footer
 */
get_footer();
