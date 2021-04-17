<?php
/**
 * Template: Single job viwer
 *
 * HMTL template for single job preview
 *
 * @since 1.0.0
 */
?>
<div class="single-job-wrapper">
    <h4><?php echo esc_html( $job_search_result->title ); ?></h4>
    <p>
        <span style="font-weight: bold;"><?php esc_html_e( 'Search Jobs Type', 'github_jobs_earch' ); ?>: </span>
        <?php echo esc_html( $job_search_result->type ); ?>
    </p>
    <p>
        <span style="font-weight: bold;"><?php esc_html_e( 'Search Jobs Location', 'github_jobs_earch' ); ?>: </span>
        <?php echo esc_html( $job_search_result->location ); ?>
    </p>
    <div class="job-description">
        <?php echo wp_kses_post( $job_search_result->description ); ?>
    </div>
</div>
<?php
