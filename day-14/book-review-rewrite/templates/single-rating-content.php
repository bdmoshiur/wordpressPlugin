<?php

get_header();

echo "<div class='content-area'>";
if ( ! empty( $all_ratings ) ) {
    foreach( $all_ratings as $ratings ):

    $post_id                = get_the_permalink( $ratings['post_id'] );
    $post_title             = get_the_title( $ratings['post_id'] );
    $post_url               = get_the_permalink( $ratings['post_id'] );
    $avatar_url             = get_avatar_url( $ratings['user_id'] );
    $author_nicename        = get_the_author_meta( 'nickname', $ratings['user_id'] );
    $post_created_times_ago = human_time_diff( strtotime( $ratings['created_at'] ), current_time( 'timestamp' ) );
    $avarage_rating         = $ratings['rating'];

?>

<div class="doctor-card">
    <div class="info">
        <div class="avatar">
            <img src="<?php echo esc_url( $avatar_url ); ?>" alt="doc name" />
        </div>
        <div class="details">
            <div class="name"><a href="<?php echo esc_url( $post_url ); ?>"><?php echo esc_html__( $post_title, 'nrr-book-review' ); ?></a></div>
            <div class="meta-info">
                <span class="sp"><?php echo esc_html__( $author_nicename, 'nrr-book-review' ); ?></span>
                <span class="exp-yr"><?php echo esc_html__( $post_created_times_ago . " ago", 'nrr-book-review' ); ?></span>
            </div>
        </div>
    </div>
    <div class="actions">
        <div class="ratings">
            <span class="rating-control">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            </span>
            <span class="rating-count">( <?php echo esc_html__( $avarage_rating, 'nrr-book-review' ); ?> ) rating</span>
        </div>
    </div>
    <div class="locations"></div>
</div>

<?php

    endforeach;
} else {
    get_404_template();
}

echo "</div>";

get_footer();