<?php

namespace Author\Box\Frontend;

/**
 * The Menu Handale Class
 */
class User_Meta_Bio {

    /**
     * Initialize the class
     * 
     * @since 1.0.0
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'render_user_enqueue_scripts' ] );
        add_filter( 'the_content', [ $this, 'render_user_bio_methods' ] );
    }

    /**
     * user assests load function
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public function render_user_enqueue_scripts() {
        wp_enqueue_style( 'user-bio-style', AUTHOR_BOX_ASSETS . '/css/user-style.css' );
    }

    /**
     * User bio show function
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function render_user_bio_methods( $content ) {
        global $post;
        
        $author   = get_user_by( 'id', $post->post_author );
        $bio      = get_user_meta( $author->ID, 'description', true );
        $facebook = get_user_meta( $author->ID, 'facebook', true );
        $twitter  = get_user_meta( $author->ID, 'twitter', true );
        $linkedin = get_user_meta( $author->ID, 'linkedin', true );
        ob_start();
        ?>
        <div class="user-meta-bio-wrap">

            <div class="avatar-image">
                <?php echo get_avatar( $author->ID, 64 ); ?>
            </div>

            <div class="user-meta-bio-content">
                <div class="author-name"><?php echo esc_html( $author->display_name ); ?></div>

                <div class="user-meta-author-bio">
                    <?php echo wpautop( wp_kses_post( $bio ) ); ?>
                </div>

                <ul class="user-meta-socials">
                    <?php if ( $twitter ) { ?>
                        <li><a href="<?php echo esc_url( $twitter ); ?>" target="__blank"><?php _e( 'Twitter', 'author-box' ); ?></a></li>
                    <?php } ?>

                    <?php if ( $facebook ) { ?>
                        <li><a href="<?php echo esc_url( $facebook ); ?>" target="__blank"><?php _e( 'Facebook', 'author-box' ); ?></a></li>
                    <?php } ?>

                    <?php if ( $linkedin ) { ?>
                        <li><a href="<?php echo esc_url( $linkedin ); ?>" target="__blank"><?php _e( 'LinkedIn', 'author-box' ); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php
        $bio_content = ob_get_clean();

        return $content . $bio_content;
    }
}
