<div>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'my_related-post-widget' ); ?></label>
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</div>
    <br>
<div>
    <label for="<?php echo esc_attr( $this->get_field_id( 'no-of-post' ) ); ?>"><?php echo esc_html__( 'Number of posts:', 'my_related-post-widget' ); ?></label>
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'no-of-post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no-of-post' ) ); ?>" type="number" value="<?php echo esc_attr( $posts_no ); ?>">
</div>
    <br>
<div>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show-image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-image' ) ); ?>" value="1" <?php checked( 1, $show_image, true ); ?> >
    <label for="<?php echo esc_attr( $this->get_field_id( 'show-image' ) ); ?>"><?php echo esc_html__( 'Image Show', 'my_related-post-widget' ); ?></label>
</div>
    <br>
<div>
    <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show-excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-excerpt' ) ); ?>" value="1" <?php checked( 1, $show_excerpt, true ); ?>>
    <label for="<?php echo esc_attr( $this->get_field_id( 'show-excerpt' ) ); ?>"><?php echo esc_html__( 'Excerpt Show', 'my_related-post-widget' ); ?></label>
</div>