<?php

namespace Woo\Referral;

/**
 * The frontend main Class
 */
class Frontend {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    function __construct() {
        new Frontend\My_Coupons();
        new Frontend\Generate_Coupon();
        new Frontend\My_Referral_Links();
        new Frontend\Track_Referral_Rewards();
    }
}
