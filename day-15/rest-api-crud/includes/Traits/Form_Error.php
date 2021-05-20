<?php

namespace Rest\Product\Traits;

/**
 * All error message show trait
 */
trait Form_Error {
    public $errors = [];

    /**
     * Hass error function
     *
     * @param [type] $key
     * @return boolean
     */
    function has_error( $key ) {
        return isset( $this->errors[ $key ] ) ? true : false;
    }

    /**
     * Get eror function
     *
     * @param [type] $key
     * @return void
     */
    function get_error( $key ) {
        if ( isset( $this->errors[ $key ] ) ) {
            return $this->errors[ $key ];
        }
        
        return false;
    }
} 