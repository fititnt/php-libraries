<?php

/*
 * @package         Validacao
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

class Validacao {

    /**
     *
     */
    function __construct() {
        //
    }

    /**
     * Delete (set to NULL) generic variable
     * 
     * @param         String           $name: name of var do delete
     * @return      Object          $this
     */
    public function del($name) {
        $this->$name = NULL;
        return $this;
    }

    /**
     * Return generic variable
     * 
     * @param         String          $name: name of var to return
     * @return      Mixed          $this->$name: value of var
     */
    public function get($name) {
        return $this->$name;
    }

    /**
     * Set one generic variable the desired value
     * 
     * @param         String          $name: name of var to set value
     * @param         Mixed           $value: value to set to desired variable
     * @return      Object          $this
     */
    public function set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    /**
     * Function to debug $this object
     *
     * @param String $method: print_r or, var_dump
     * @param boolean $format: true for print <pre> tags. Default false
     * @return void
     */
    public function debug($method = 'print_r', $format = FALSE) {
        if ($format) {
            echo '<pre>';
        }
        if ($method === 'print_r') {
            print_r($this);
        } else {
            var_dump($this);
        }
        if ($format) {
            echo '</pre>';
        }
    }

}
