<div>
    <label for="name"><?php esc_html_e( 'Book Name', 'nbr-book-review' ); ?>: </label>
    <input type="text" name="name" id="name" class="widefat" value="<?php esc_attr_e( $book_meta_value_name, 'nbr-book-review' ); ?>"><br><br>
</div>
<div>
    <label for="code"><?php esc_html_e( 'Book Code', 'nbr-book-review' ); ?>: </label>
    <input type="text" name="code" id="code" class="widefat" value="<?php echo esc_attr( $book_meta_value_code, 'nbr-book-review' ); ?>"><br><br>
</div>
<div>
    <label for="date"><?php esc_html_e( 'Book Publishing date', 'nbr-book-review' ); ?>: </label>
    <input type="date" name="date" id="date" class="widefat" value="<?php echo esc_attr( $book_meta_value_date, 'nbr-book-review' ); ?>"><br><br>
</div>
<div>
    <label for="price"><?php esc_html_e( 'Book Price', 'nbr-book-review' ); ?>: </label>
    <input type: name="price" id="price" class="widefat" value="<?php echo esc_attr( $book_meta_value_price, 'nbr-book-review' ); ?>"><br><br>
</div>
<div>
    <label for="description"><?php esc_html_e( 'Book Short Description', 'nbr-book-review' ); ?>: </label>
    <textarea name="description" id="description" class="widefat"><?php echo esc_textarea( $book_meta_value_desc, 'nbr-book-review' ); ?></textarea><br><br>
</div>
