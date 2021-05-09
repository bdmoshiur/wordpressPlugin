<div class="single-job-wrapper">
    <h4><a href="<?php echo esc_attr( '?search-id='. $single_job_search->id ); ?>"><?php echo esc_html( $single_job_search->title ); ?></a></h4>
    <p>
        <span style="font-weight: bold;"><?php esc_html_e( 'Search Jobs Type', 'github_jobs_earch' ); ?>: </span>
        <?php echo esc_html( $single_job_search->type ); ?>
    </p>
    <p>
        <span style="font-weight: bold;"><?php esc_html_e( 'Search Jobs Location', 'github_jobs_earch' ); ?>: </span>
        <?php echo esc_html( $single_job_search->location ); ?>
    </p>
</div>

