<?php
/**
 * Plugin Name:       We Contact Form
 * Plugin URI:        https://contactform.com
 * Description:       We Contact Form this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Moshiur Rahman
 * Author URI:        https://moshiur-rahman.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-contact-form
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly
 * 
 * @since 1.0.0
*/ 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The main class of plugin
 */
class Cf_We_Contact_Form {

    /**
     * constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        add_shortcode( 'we-add-form', [ $this, 'add_contact_form' ] );
        add_shortcode( 'we-add-field', [ $this, 'add_field_contact_form' ] );
    }

    /**
     * Contact form function
     * 
     * @since 1.0.0
     * 
     * @param array $atts
     * @param string/mixed $content
     * 
     * @return string
     */
    public function add_contact_form( $atts, $content ) {
        $atts = shortcode_atts( 
            [
                'title'       => __( 'Contact Form', 'we-contact-form' ),
                'description' => __( 'weDevs is the maker of Dokan Multivendor WP Project Manager WP User Frontend WP ERP and many more', 'we-contact-form' ),
            ],
            $atts
        );
        ?>
           <div>
                <h2><?php esc_html_e( $atts[ 'title' ], 'we-contact-form' ); ?></h2>
                <p><?php  esc_html_e( $atts[ 'description' ], 'we-contact-form' ) ; ?></p>
                <br>
                <form action="" method="">
                    <?php echo do_shortcode( $content ); ?>
                </form>
           </div>
       <?php
    }

    /**
     * form field add function
     *
     * @param array $atts
     * 
     * @return string
     */
    public function add_field_contact_form( $atts ) {
        $atts = shortcode_atts(
            [
                'name'        => 'name-' . time(),
                'type'        => __( 'text', 'we-contact-form' ),
                'placeholder' => __( 'Enter your text here', 'we-contact-form' ),
                'value'       => __( 'Submit', 'we-contact-form' ),
                'lavel'       => __( 'Your Name', 'we-contact-form' ),
                'option'      =>  __( 'One', 'we-contact-form' ),
            ],
            $atts
        );

        $type = $atts['type'];
        $inputType = [
            'text',
            'number',
            'password',
            'phone',
            'tel',
            'file',
            'email',
            'url',
        ];

        if ( in_array( $atts['type'], $inputType ) ) {
            $type = 'globalInput';
        }

        switch ( $type ) {
            case 'globalInput':
                return "<label> {$atts['lavel']} </label><input type='{$atts['type']}' name='{$atts['name']}' placeholder='{$atts['placeholder']}'><br/>";
            case 'radio':
                return "<label> {$atts['lavel']} </label>
                        <input type='{$atts['type']}' name='{$atts['name']}' > EEE
                        <input type='{$atts['type']}' name='{$atts['name']}' > CSE
                        <br/>";
            case 'textarea':
                return "<label> {$atts['lavel']} </label><textarea name='{$atts['name']}' rows='4' cols='50'>{$atts['placeholder']}</textarea><br/>";
            case 'checkbox':
                return "<label> {$atts['lavel']} </label>
                        <input type='checkbox' name='{$atts['name']}' value='Male'> Male
                        <input type='checkbox' name='{$atts['name']}' value='Female'> Female
                        ";
            case 'select':
                        $options = explode( ',', $atts['option'] );
                        $test = '<option>Select One</option>';
                        foreach ( $options as $option) {
                            $test .= "<option>$option</option>";
                        }
                return "<label> {$atts['lavel']} </label>
                        <select> $test </select>
                        <br/>";
            case 'button':
                return "<input type='{$atts['type']}' name='{$atts['name']}' value='{$atts['value']}'><br/>";
            default:
                return "<label> {$atts['lavel']} </label><input type='{$atts['type']}' name='{$atts['name']}'><br/>";
        }
    }
}

/**
 * The main class instance function
 *
 * @return \Cf_We_Contact_Form
 */
function cf_we_contact_form() {
    return new Cf_We_Contact_Form();
}

/**
 * object calling function
 */
cf_we_contact_form();