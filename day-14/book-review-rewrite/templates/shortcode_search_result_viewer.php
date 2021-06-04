<div class="single-post">
    <div id="search-results-wrapper" class="container wrapper default-max-width clearfix"">
        <h2>
            <a href="<?php echo esc_url( $post->guid ); ?>">
                <?php esc_html_e( $post->post_title, 'nrr-book-review' ); ?>
            </a>
        </h2>

        <a href="<?php echo esc_url( $post->guid ); ?>">
            <img src="<?php esc_url( the_post_thumbnail() ); ?>" alt="<?php esc_attr_e( $post->post_title, 'nrr-book-review' ); ?>" />
        </a>

        <p>
            <?php esc_html_e( $post->post_excerpt, 'nrr-book-review' ); ?>
            <a href="<?php echo esc_url( $post->guid ) ?>">
                <?php esc_html_e( 'Read More', 'nrr-book-review' ); ?>
            </a>
        </p>
    </div>
</div>
