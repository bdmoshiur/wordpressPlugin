<div class="wrap">
    <h1 class="wp-heading-inline"><?php  esc_html_e( "User Information", "form_submit_ajax" ); ?></h1>

    <form action="" method="post">
        <?php 
        
        $table = new Formsubmit\Ajax\Admin\Address_List();
        $table->prepare_items();
        $table->display();
        
        ?>
    </form>
</div>