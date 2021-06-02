<div class='wrap'>
    <h1><?php  esc_html_e( 'New Student Register', 'student-info' ); ?></h1>
    <br>
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'first_name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="first_name"><?php esc_html_e( 'First Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="text" class="regular-text" name="first_name" id="first_name" value="<?php echo isset( $_REQUEST['first_name'] ) ? $_REQUEST['first_name'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the first name', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'first_name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('first_name') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'last_name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="last_name"><?php esc_html_e( 'Last Name', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="text" class="regular-text" name="last_name" id="last_name" value="<?php echo isset( $_REQUEST['last_name'] ) ? $_REQUEST['last_name'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the last name', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'last_name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('last_name') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'class' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="class"><?php esc_html_e( 'Class', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="text" class="regular-text" name="class" id="class" value="<?php echo isset( $_REQUEST['class'] ) ? $_REQUEST['class'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the Class', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'class' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('class') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'roll' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="roll"><?php esc_html_e( 'Roll', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="roll" id="roll" value="<?php echo isset( $_REQUEST['roll'] ) ? $_REQUEST['roll'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the roll', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'roll' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('roll') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'reg_no' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="reg_no"><?php esc_html_e( 'Reg No', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="reg_no" id="reg_no" value="<?php echo isset( $_REQUEST['reg_no'] ) ? $_REQUEST['reg_no'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the Reg No', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'reg_no' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('reg_no') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'bangla' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="bangla"><?php esc_html_e( 'Bangla', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="bangla" id="bangla" value="<?php echo isset( $_REQUEST['bangla'] ) ? $_REQUEST['bangla'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the bangla marks', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'bangla' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('bangla') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'english' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="english"><?php esc_html_e( 'English', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="english" id="english" value="<?php echo isset( $_REQUEST['english'] ) ? $_REQUEST['english'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the english marks', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'english' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('english') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'math' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="math"><?php esc_html_e( 'Math', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="math" id="math" value="<?php echo isset( $_REQUEST['math'] ) ? $_REQUEST['math'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the math marks', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'math' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('math') ?></p>
                         <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'data_structure' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row"><label for="data_structure"><?php esc_html_e( 'Data Structure', 'wedevs-acadeny' ) ?></label></th>
                    <td>
                        <input type="number" class="regular-text" name="data_structure" id="data_structure" value="<?php echo isset( $_REQUEST['data_structure'] ) ? $_REQUEST['data_structure'] : '' ?>" placeholder="<?php esc_html_e( 'Enter the data structure mark', 'student-info' ); ?>">
                        <?php if( $this->has_error( 'data_structure' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error('data_structure') ?></p>
                         <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php  wp_nonce_field( 'new-info' ); ?>
        <input type="submit" name="std_info" value="<?php esc_html_e( 'Save info', 'student-info' ); ?>">
    </form>
    
</div>