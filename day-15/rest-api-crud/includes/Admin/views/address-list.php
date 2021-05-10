<div class="wrap">
    <h1 class="wp-heading-inline"><?php  esc_html_e( "Address Book", "wedevs-academy" ); ?></h1>
    <a class="page-title-action" href="<?php echo admin_url( "admin.php?page=wedevs-academy&action=new" ); ?>" ><?php  esc_html_e( "Add New", "wedevs-academy" ); ?></a>

    <form action="" method="post">
        <?php 
        
        $table = new Wedevs\Academy\Admin\Address_List();
        $table->prepare_items();
        $table->display();

        ?>
    </form>
</div>