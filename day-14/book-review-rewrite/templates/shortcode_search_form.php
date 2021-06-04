<h3><?php esc_html_e( 'Book Review serch', 'nrr-book-review' ); ?></h3>
<form id="book-review-search-form" action="" method="GET">
    <div>
        <input name="keyword" type="text" id="keyword" <?php esc_attr_e( 'Input text here', 'nrr-book-review' ); ?>" required>
        <?php wp_nonce_field( 'book-review-search' ); ?>
        <input name="book-post-meta-search" type="submit" value="<?php esc_attr_e( 'Search', 'nrr-book-review' ); ?>">
    </div>
</form>

