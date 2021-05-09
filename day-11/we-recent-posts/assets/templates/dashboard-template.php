
<form id="mrm_dashboard_form" action=""  method="">
    <div class="input-text-wrap" id="title-wrap">
        <label for="mrm_posts_no"><strong><?php echo esc_html__( 'Posts no', 'recent-posts' ); ?></strong></label>
        <input name="mrm_posts_no" type="text" id="mrm_posts_no" value="<?php echo esc_attr( $mrm_posts_no ); ?>" class="widefat" placeholder="Post no" />
	</div>
    <br>
	<div class="input-text-wrap" id="title-wrap">
        <label for="mrm_order"><strong><?php echo esc_html__( 'Post Order', 'recent-posts' ); ?></label>
        <select name="mrm_order" id="mrm_order">
           <option selected="selected" value="subscriber">Select one</option>
           <option value="ASC" <?php selected( 'ASC' === $mrm_order, 1 ); ?>>ASC</option>
           <option value="DESC" <?php selected( 'DESC' === $mrm_order, 1 ); ?>>DESC</option>
        </select>

	</div>
    <br>
	<div id="title-wrap">
        <?php foreach( $categories as $category ): ?>
        <label for="<?php echo esc_attr( $category->slug ); ?>">
           <input name="mrm_category_items[]" type="checkbox" id="<?php echo esc_attr( $category->slug ); ?>" value="<?php echo esc_attr( $category->slug ); ?>" <?php if ( count( $category_select ) > 0 ) { checked( in_array( $category->slug, $category_select ), 1 );  } ?> />
           <?php echo esc_html__( $category->name, 'recent-posts' ); ?>
        </label><br/>
        <?php endforeach; ?>
	</div>
	<br>
    <p class="submit">
       <input type="submit" name="mrm_save" id="mrm_save" class="button button-primary" value="Save">
    </p>
</form>


<div id="mrm_list_container">

    <?php 
        if ( $the_query->have_posts() ) {
            while( $the_query->have_posts() ) {
                $the_query->the_post();
                ?>
                <p>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </p>
                <?php
            }
        }
    ?>

</div>
