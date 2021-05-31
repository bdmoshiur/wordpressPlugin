<div class="job-search-form-wrapper">
    <form action="" method="get" id="job-search-form">
        <input type="text" name="search-keyword" id="search-keyword" placeholder="<?php esc_attr_e( 'Search Jobs Keyword', 'github_jobs_earch' ); ?>">

        <input type="text" name="search-location" id="search-location" placeholder="<?php esc_attr_e( 'Search Jobs Location', 'github_jobs_earch' ); ?>">

        <?php $job_fulltime = isset( $_GET['search-fulltime'] ) ? sanitize_text_field( $_GET['search-fulltime'] ) : '' ?>
        <input type="checkbox" name="search-fulltime" id="search-fulltime" value="on" <?php checked( $job_fulltime, 'on' ); ?>>
        <label for="search-fulltime"><?php esc_html_e( 'Full time', 'github_jobs_earch' ); ?></label>

        <input type="submit" name="job-search-submit" value="<?php esc_attr_e( 'Jobs Search', 'github_jobs_earch' ); ?>">
    </form>
</div>
