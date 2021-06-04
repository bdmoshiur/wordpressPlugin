<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Address Book', 'we-crud' ); ?> </h1>
    <a class="page-title-action" href="<?php echo admin_url('admin.php?page=we-crud&action=new'); ?>"><?php _e( 'Add New' , 'we-crud' ) ?></a>

    <?php if( isset( $_GET['inserted']) ) { ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Address has been Added successfully', 'we-crud' ) ?></p>
        </div>
    <?php } ?>
    
    <?php if( isset( $_GET['address-deleted'] ) && $_GET['address-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Address has been Deleted successfully', 'we-crud' ) ?></p>
        </div>
    <?php } ?>
    
    <form action="" method="POST">
        <?php
            $tables = new We\Crud\Admin\Address_list();
            $tables->prepare_items();
            $tables->display();
        ?>
    </form>
</div>