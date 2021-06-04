<?php
get_header();

echo "<div class='content-area'>";

if ( ! empty( $unique_posts ) ) {
    foreach( $unique_posts as $post_id ) {
        $author_id              = get_post_field( 'post_author', $post_id );
        $created_at             = get_post_field( 'post_modified', $post_id );
        $post_title             = get_the_title( $post_id );
        $post_url               = get_the_permalink( $post_id );
        $avatar_url             = get_avatar_url( $author_id );
        $author_nicename        = get_the_author_meta( 'nickname', $author_id );
        $avarage_rating         = get_average_review_by_post_id( $post_id );
        $post_created_times_ago = human_time_diff( strtotime( $created_at ), current_time( 'timestamp' ) );

        include BRR_BOOK_REVIEW_PATH . '/templates/rating-content.php';
    }

    $current     = ( ! empty( get_query_var( 'paged' ) ) ) ? get_query_var( 'paged' ): 1;
    $per_page    = 5;
    $total_posts = get_all_rating_by_group();
    $total_page  = ceil( count( $total_posts ) / $per_page );

    echo "<div class='review-pagination'>";

    echo paginate_links( array(
        'format' => '?paged=%#%',
        'current' => $current,
        'total' => $total_page,
    ) );

    echo "<div>";
} else {
    get_404_template();
}

echo "</div>";

get_footer();