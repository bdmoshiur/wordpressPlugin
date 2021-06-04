<?php
/**
 * Template part for displaying posts
 *
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header>
	<div class="entry-content">
	
		<?php
		the_content();
        $id                  = get_the_ID();
        $book_name_show      = get_post_meta( $id, 'br_book_name' , true );
        $book_date_show      = get_post_meta( $id, 'br_book_date' , true );
        $book_code_show      = get_post_meta( $id, 'br_book_code' , true );
        $author_name_show    = get_post_meta( $id, 'br_book_author_name' , true );
        $author_email_show   = get_post_meta( $id, 'br_book_email' , true );
        $author_address_show = get_post_meta( $id, 'br_book_address' , true );

        echo '<div style="width:900px; text-align:center">';
        echo ' <b> Book Name : </b> ' . $book_name_show . '<br>';
        echo ' <b> Book Publish Date : </b> ' . $book_date_show . '<br>';
        echo ' <b> Book Code No : </b> ' . $book_code_show . '<br>';
        echo ' <b> Author Name : </b> ' . $author_name_show . '<br>';
        echo ' <b> Author Email : </b> ' . $author_email_show . '<br>';
        echo ' <b> Author Address : </b> ' . $author_address_show . '<br>';
        echo '</div>';

		wp_link_pages(
			[
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			]
		);
		?>
	</div>

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer>

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article>
