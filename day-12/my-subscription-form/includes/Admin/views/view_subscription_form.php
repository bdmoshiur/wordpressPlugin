<div>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'my_related-post-widget' ); ?></label>
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</div>
    <br> 
<div>
    <label for="<?php echo esc_attr( $this->get_field_id( 'mailchimp_list' ) ); ?>"><?php echo esc_html__( 'MailChimp Lists:', 'my_related-post-widget' ); ?></label>
    <select name="<?php echo esc_attr( $this->get_field_name( 'mailchimp_list' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'mailchimp_list' ) ); ?>" class="widefat">
        <option value="<?php echo esc_attr( $list_id ); ?>" selected( $mailchimp_list, $list_id )><?php echo esc_attr( $audience_list_name ); ?></option>
    </select>
</div>
<br>
