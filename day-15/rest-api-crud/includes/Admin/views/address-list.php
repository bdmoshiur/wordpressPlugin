<div class="wrap">
    <h1 class="wp-heading-inline"><?php  esc_html_e( "Address Book", "wedevs-academy" ); ?></h1>
    <a class="page-title-action" href="<?php echo admin_url( "admin.php?page=wedevs-academy&action=new" ); ?>" ><?php  esc_html_e( "Add New", "wedevs-academy" ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Address has been added successfully', 'wedevs-acadeny' ) ?></p>
        </div>
    <?php } ?> 
    <?php if ( isset( $_GET['address-deleted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Address has been deleted successfully', 'wedevs-acadeny' ) ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php 
        
        $table = new Rest\Product\Admin\Address_List();
        $table->prepare_items();
        $table->display();

        ?>
    </form>
</div>