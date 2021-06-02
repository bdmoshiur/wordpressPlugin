<?php

namespace Userrole\Capability;

/**
 * The frontend main class
 */
class Frontend {

    /**
     * Constructor function
     * @since 1.0.0
     */
    function __construct() {
        new Frontend\Customer_Registration_Form();
    }
}
