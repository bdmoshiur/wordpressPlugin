<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  </head>
  <body>
        <div id="Ajax-myForm">
            <form id="myForm" name="myForm" action="" method="post">
                <div id="output"></div> 
                <div class="form-group form-row">
                    <label><?php _e('Email Subscribtion', 'form_submit_ajax') ?></label>
                    <input type="email" name="email" class="form-control" value="" placeholder="Enter your email Address"  >
                    <input type="hidden" name="list_id"  value="<?php esc_attr_e( $mailchimp_list)?>" >
                </div>
                <div class="form-group form-row">
                    <?php wp_nonce_field( 'from_nonce_shortcode' ); ?>
                    <input type="hidden" name="action" value="from_shortcode">
                    <br>
                    <input type="submit" name="send_shortcode" value="<?php _e('Send', 'form_submit_ajax') ?>">
                </div>
            </form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
  </body>
</html>