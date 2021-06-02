<div class='wrap'>
    <h1><?php  esc_html_e( 'Show Student info', 'student-info' ); ?></h1>
    <br>
    <table class="form-table">
        <thead>
            <th><?php  esc_html_e( 'Sl', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'First Name', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'Last Name', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'Class Name', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'Roll', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'Reg No', 'student-info' ); ?></th>
            <th><?php  esc_html_e( 'Subject Info', 'student-info' ); ?></th>
        </thead>
        <tbody>
            <?php
                $i = 1;
                $students = si_get_student_info();
                foreach ( $students as $student ) {
            ?>
                <tr class="row">
                    <td scope="row"><label><?php echo $i++; ?></label></td>
                    <td scope="row"><label><?php echo esc_html( $student->first_name ) ?></label></td>
                    <td scope="row"><label><?php echo esc_html( $student->last_name ) ?></label></td>
                    <td scope="row"><label><?php echo esc_html( $student->class ) ?></label></td>
                    <td scope="row"><label><?php echo esc_html( $student->roll ) ?></label></td>
                    <td scope="row"><label><?php echo esc_html( $student->reg_no ) ?></label></td>
                    <td scope="row">
                        <label>
                            <?php 
                                $marks = get_student_meta( $student->id, 'sn_subject_num' )[0];
                                foreach ($marks as $key => $mark ) {
                                    echo "<p><strong>" . esc_html( $key ) . "</strong> : " . esc_html( $mark ) . "</p>";
                                }
                            ?>
                        </label>
                    </td>
                </tr>
            <?php
            }

                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $args = array(
                    'posts_per_page' => 5,
                    'paged' => $paged,
                );
                
                $the_query = new WP_Query( $args );
                echo paginate_links( array(
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $the_query->max_num_pages
                ) );
            ?>
        </tbody>
    </table>
</div>