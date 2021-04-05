<div class="from_shortcode_ajax" id="from_shortcode_ajax">
    <form action="" method="post">
        <div class="form-group form-row">
            <label><?php _e('Name', 'form_submit_ajax') ?></label>
            <input type="text" name="name" class="form-control" value="" placeholder="Enter Name" required>
        </div>
        <div class="form-group form-row">
            <label><?php _e('Email', 'form_submit_ajax') ?></label>
            <input type="email" name="email" class="form-control" value="" placeholder="Enter Email" required>
        </div>
        <div class="form-group form-row">
            <label><?php _e('Message', 'form_submit_ajax') ?></label>
            <textarea class="form-control" name="message" rows="3" required ></textarea>
        </div>
        <div class="form-group form-row">
            <?php wp_nonce_field( 'nonce_from_shortcode' ) ?>
            <input type="hidden" name="action" value="from_shortcode">
            <input type="submit" name="send_shortcode" value="<?php _e('Save', 'form_submit_ajax') ?>">
        </div>
    </form>
</div>