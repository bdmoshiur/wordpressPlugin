<?php
namespace We\Crud\Traits;

/**
 * Form Error trait
 * 
 * @since 1.0.0
 * 
 * @return mixed
 */
trait Form_Error {
    /**
     * Error property declare
     * 
     * @since 1.0.0
     */
    public $errors = [];
    
    /**
     * Error check & set function
     * 
     * @since 1.0.0
     *
     * @param string $key
     * 
     * @return boolean
     */
    public function has_error( $key ) {
        return isset( $this->errors[ $key ] ) ? true : false ;
    }

    /**
     * Error check & get function
     * 
     * @since 1.0.0
     *
     * @param string $key
     * 
     * @return boolean
     */
    public function get_error( $key ) {
        if( isset( $this->errors[ $key ] ) ) {
            return $this->errors[ $key ];
        }

        return false;
    }
}