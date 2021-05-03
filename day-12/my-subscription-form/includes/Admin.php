<?php
namespace Subscription\Form;

/**
 * The admin main Class
 */
class Admin {
    function __construct() {
        new Admin\Subscription_Form_Setting();
        new Admin\Subscription_Form_Widget();
    }
}
