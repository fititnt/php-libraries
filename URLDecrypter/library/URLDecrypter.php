<?php

/*
 * @package         URLDecrypter
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

class URLDecrypter {

    /**
     *
     * @var Array 
     */
    private $wildcards;

    /**
     *
     * @var Array 
     */
    private $urlshorteners;
    
    /**
     * If requested only one decrypt, hold the solution
     * 
     * @var String 
     */
    private $solution;
    
    /**
     * If requested more than one decrypt, hold the array of solution
     * 
     * @var Array
     */
    private $solutions;
    
    /**
     * If requested only one decrypt, hold the request
     * 
     * @var String 
     */
    private $target;
    
    /**
     * If requested more than one decrypt, hold the request
     * 
     * @var Array
     */
    private $targets;
    
    
    /**
     * @var Object
     */
    private $logic;
    
    
    /**
     * @var Object
     */
    private $method;

    /**
     *
     * @param String $wildcards
     * @param String $urlshorteners 
     */
    function __construct( $wildcards = null, $urlshorteners = null ) {
        if ( $wildcards == null ) {
            $this->wildcards = $this->_loadFile( dirname(__FILE__) . '/wildcards.ini' );
        } else {
            $this->wildcards = $this->_loadFile( $wildcards );
        }
        if ( $urlshorteners == null ) {
            $this->urlshorteners = $this->_loadFile( dirname(__FILE__) . '/urlshorteners.ini' );
        } else {
            $this->urlshorteners = $this->_loadFile( $urlshorteners );
        }
        $this->method = new stdClass();
    }

    /**
     *
     * @param String $target 
     */
    public function target( $target ){
        $this->target = $target;
        return $this;
    }
    
    /**
     *
     * @param Mixed $targets
     * @return URLDecrypter 
     */
    public function targets ( $targets ){
        if( !is_array( $targets ) ){
            $targets = explode( "\n", $targets );
            foreach( $targets AS $item){
                $item = rtrim($item, "\r");//Remove carriege return from Windows
            }
        }
        $this->targets = $targets;
        return $this;
    }
    
    /**
     * Try solve the defined target(s)
     * You can define the targets also in function target() and targets()d
     * 
     * @param Mixed $targets
     * @return Mixed $solutions
     */
    public function solve( $targets = null ){
        ///Check if target is passed via this functon, and use it
        if ( $targets != null){
            if( is_array($targets)){
                $this->targets( $targets );
            } else {
                $this->target( $targets );
            }
            
        }
        ///Try determine if will parse one one target or more at once
        ///If both are seted, will load the Array instead of String
        if( $this->targets != null){
            $this->method->type = 0;//unlimited
        } else {
            $this->method->type = 1;//Just one target
        }
        return $solutions;
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
        if ( $format ) {
            echo '<pre>';
        }
        if ( $method === 'print_r' ) {
            print_r( $this );
        } else {
            var_dump( $this );
        }
        if ( $format ) {
            echo '</pre>';
        }
    }

    /**
     * 
     */
    private function _analize( $target ){
        ///Check if is already is not one desired URL
        
        ///Check simples conversions
        
        ///Break url in less parts
        
        /// return
    }
    
    
    /**
     *
     * @param Object $params 
     */
    private function _decript( $params = null ){
        $solutions = null;
        if ( $this->method->type == 1){
            $this->data[0] = $this->target;
        } else {
            $this->data = $this->targets;
        }
        
        return $solutions;
    }
    
    /**
     * @todo Solve posible problem with UTF-8
     * @param String $data 
     */
    private function getReverse( $data ){
        $reverse = strrev( $data );
        return $reverse;
    }
    
    /**
     *
     * @param string $data
     * @return string 
     */
    private function getRot13( $data ){
        $rot13 = str_rot13( $data ); //$rot13 = '@todo implement it';
        return $rot13;
    }
    
    /**
     * Compare one String with the wildcards list
     * 
     * @param String $data
     * @return Mixed String or false 
     */
    private function _compareWildcards( $data ){
        $result = false;
        
        //for be compared, need, at least, be one domain, so lets do a fast check
        if ( strpos( $data, array('.com', '.org') ) === false ){
            return false;
        }
        //Return wildcards if found, else will return false
        $result = array_search( $data, $this->wildcards );
        
        return $result;
        
    }
    
    /**
     * Compare one String with the urlshorteners list
     * 
     * @param String $data
     * @return Mixed String or false 
     */
    private function _compareUrlShorteners( $data ){
        $result = false;
        
        //Return wildcards if found, else will return false
        $result = array_search( $data, $this->urlshorteners );
        
        return $result;
    }
    
    /**
     *
     * @param String $file
     * @return Array 
     */
    private function _loadFile($file) {
        $filecontents = array();
        $filecontents = file($file); //Maybe some another alternatives too, hun?        
        return $filecontents;
    }

}
