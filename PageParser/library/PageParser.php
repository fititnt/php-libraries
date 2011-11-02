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

class PageParser {
    
    /*
     * DomDocument object
     * 
     * @param         object
     */

    private $dom;

    /*
     * Type of document to parse
     * 
     * @param object
     */
    private $doctype = 'HTML';


    /*
     * Content to parse
     * 
     * @param string
     */
    private $content;


    /*
     * Value of last parset element
     * 
     * @param string 
     */
    private $element;

    /*
     * Value of last parset array of element
     * 
     * @param array 
     */
    private $elements;

    /*
     * ID of element to parse
     * 
     * @param string
     */
    private $id;

    /*
     * Path of element to parse
     * 
     * @param string
     */
    private $path;

    /*
     * Initialize values
     */

    function __construct() {
        $this->dom = $doc = new DomDocument;
        $this->dom->preserveWhiteSpace = false;
    }

    function __destruct() {
        //
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

    /*
     * Delete (set to NULL) generic variable
     * 
     * @param string $name: name of var to return
     * @return object $this
     */

    public function del($name) {
        $this->$name = NULL;
        return $this;
    }

    /*
     * Execute Dig. Set TRUE for return content. Default FALSE to just set internal variable
     * 
     * @param string $method: TRUE for return contents, FALSE for not
     * @return mixed $this object OR $this->content String
     */

    public function pp($method = FALSE) {
        //
    }

    /*
     * Execute Dig. Set TRUE for return content. Default FALSE to just set internal variable
     * 
     * @param String $value: value of id to return
     * @param String $method: TRUE for return contents, FALSE for not
     * @return mixed $this object OR $this->content String
     */

    public function ppId($value, $method = TRUE) {
        if ($this->doctype === 'HTML') {
            $this->dom->loadHTML($this->content);
            $this->element = $this->dom->getElementById($value)->nodeValue;
        } else {
            die('PageParser: Document Type is not implemented yet. Use HTML type');
        }

        if ($method) {
            return $this->element;
        } else {
            return $this;
        }
    }

    /*
     * Return generic variable
     * 
     * @param string $name: name of var to return
     * @return mixed $this->$name: value of var
     */

    public function get($name) {
        return $this->$name;
    }

    /*
     * Return last parsed element ( $this->element )
     * 
     * @return mixed $this->$name: value of var
     */

    public function getElement() {
        return $this->element;
    }

    /*
     * Set one generic variable the desired value
     * 
     * @param        string          $name: name of var to return
     *
     * return       object          $this
     */

    public function set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    /*
     * Set content page to parse
     * 
     * @param        string           $value: value to set
     *
     * return       object          $this
     */
    public function setPage($value) {
        $this->content = $value;
        return $this;
    }

    /*
     * Set Type of document to parse
     * 
     * @param        string           $value: value to set
     *
     * return       object          $this
     */

    public function setType($value = 'HTML') {
        $this->doctype = strtoupper($value);
        return $this;
    }

}
