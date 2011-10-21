<?php
/*
 * @package         PageParser
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

class ClassFluentInterface {
    
    /**
     * @var     mixed       Generic mixed variable description
     */
    private $variable;
    
    /**
     * @var     mixed       Generic mixed variable description
     */
    public $public;
    
    /**
     * @var     integer     Generic integer variable description
     */
    private $integer;
    
    /**
     * @var     string       Generic string variable description
     */
    private $string;
    
    /**
     * @var     array       Generic array variable description
     */
    private $array;

    /*
     * Initialize values
     */
   function __construct()
    {
       //
    }
    
    /*
     * Delete (set to NULL) generic variable
     * 
     * @var        string          $name: name of var to return
     *
     * return       object          $this
     */
    public function del( $name )
    {
        $this->$name = NULL;
        return $this;
    }
    
    /*
     * Return generic variable
     * 
     * @var        string          $name: name of var to return
     *
     * return       mixed          $this->$name: value of var
     */
    public function get( $name )
    {
        return $this->$name;
    }
    
    /*
     * Set one generic variable the desired value
     * 
     * @var        string          $name: name of var to return
     *
     * return       object          $this
     */
    public function set( $name, $value )
    {
        $this->$name = $value;
        return $this;
    }
    
    /*
     * Function to debug $this object
     *
     * @var       string        $method: print_r or, var_dump
     * 
     * @var       boolean       $format: true for print <pre> tags. Default false
     * 
     * @return       void
     */
    public function debug( $method = 'print_r', $format = FALSE )
    {
        if ($format){
            echo '<pre>';
        }
        if ($method === 'print_r'){
            print_r( $this );
        } else {
            var_dump( $this );
        }
        if ( $format ){
            echo '</pre>';
        }
    }
}