<?php
namespace Formsubmit\Ajax;

/**
 * The frontend main Class
 */
class Mrm_Frontend {
    function __construct() {
        new Frontend\Mrm_Ajax_Form_Shortcode();
    }
}
