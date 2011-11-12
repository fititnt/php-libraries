<?php
/*
 * @package         CLIHelper
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

class CLIHelper {
    
    /** 
     * Name of SAPI
     * 
     * @varb String 
     */
    private         $sapiName;
    
    
    /**
     * Determine if access is made by Command Line Interface
     * 
     * @var  Boolean  Full name of SAPI
     */
    private         $cli = FALSE;
    
    /**
     * Determine if access is made by Browser
     * 
     * @var Boolean Full name of SAPI
     */
    private         $browser = FALSE;
    

    /**
     * Initialize values
     */
    function __construct()
    {
        $this->sapiName = PHP_SAPI;
        
        if ( defined('STDIN') || isset($_SERVER['SHELL']) ){
            $this->cli = TRUE;
        } else {
            $this->browser = TRUE;
        }
    }
    
   function __destruct()
   {
       //
   }
   
    /**
     * Function to debug $this object
     *
     * @var String $method: print_r or, var_dump
     * @var Boolean $format: true for print <pre> tags. Default false
     * @return      Void
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
    
    /**
     * Delete (set to NULL) generic variable
     * 
     * @var String $name: name of var do delete
     * @return Object $this
     */
    public function del( $name )
    {
        $this->$name = NULL;
        return $this;
    }
    
    /**
     * Return the absolute directory path of file that called this method
     * 
     * @return String          
     */
    public function getDirPath( )
    {
        $path = dirname(__FILE__); //Or just __DIR__ for PHP 5.3+
        return $path;
    }
    
    /**
     * Return the absolute file path of file that called this method
     * 
     * @return String          
     */
    public function getFilePath( )
    {
        $path = __FILE__;
        return $path;
    }
    
    /**
     * Return the URL directory path, if is accessed by browser.
     * Fallback to get directory path if is acessed by Command Line Interface
     * 
     * @return String          
     */
    public function getUrlDir( )
    {
        if( $this->browser)
        {
            //Gambiarra? Gambiarra @todo: change it.
            if ( $_SERVER['PHP_SELF'] ) //Check if is not root. Maybe do a better check later?
            { 
                $currentUrl = $this->getUrlFile();
                $urlInfo = explode('/', $currentUrl);
                array_pop($urlInfo);//Get of last element of array
                $url = implode('/', $urlInfo);
                
            } else {
                $url = $this->getUrlFile();
            }
        }
        else
        {
            $url = $this->getDirPath();
        }        
        return $url;
    }
    
    /**
     * Return the URL file path, if is accessed by browser.
     * Fallback to get file path if is acessed by Command Line Interface
     * 
     * @return String          
     */
    public function getUrlFile( )
    {
        
        if( $this->browser)
        {
            if ( empty($_SERVER["HTTPS"]) ){
                $url = 'https://';
            } else {
                $url = 'http://';
            }
            
            $url .= $_SERVER["SERVER_NAME"];
            
            if ($_SERVER["SERVER_PORT"] != "80"){
                $url .= ':'. $_SERVER["SERVER_PORT"];
            }
            
            $url .= $_SERVER["REQUEST_URI"];
        } 
        else
        {
            $url = $this->getFilePath();
        }
        

        
        return $url;
    }
    
    /**
     * Return the absolute file path of file that called this method
     * 
     * @var        String          $name: name of var to return
     * @return      Mixed          $this->$name: value of var
     */
    public function getUrlPathCurrent( $name )
    {
        return $this->$name;
    }
    
    
    /**
     * Return SAPI name
     * 
     * @return String $this->$name: value of var
     */
    public function getSapi( )
    {
        $name = $this->sapiName;     
        return $name;
    }
    
    /**
     * Emulate CLI $argv even if accessed by browser
     * 
     * This script run both on PHP Command Line Interface and Browser 
     * For set directory on browser: add one param to url with any key but with one path 
     * example: /script.php?foo=C:/xampp/htaccess/mysyte 
     * on CLI, just add a new parameter 
     * example: php script.php C:/xampp/htaccess/mysyte
     * 
     * @see https://gist.github.com/1210131
     * @return      String           $this->$name: value of var
     */
    public function getVar( $name = NULL, $method = NULL )
    {
        if ( $name === NULL ){
            if ( !isset($_SERVER['HTTP_USER_AGENT']) ) {
                global $argv;
                $arguments = $argv;
            } else {
                $arguments = array();
                $arguments[] = $_SERVER['SCRIPT_FILENAME'];
                foreach ($_GET as $key => $value){
                        $arguments[] = $value;
                }
            }
        }
        return $name;
    }
    
    /**
     * Set one generic variable the desired value
     * 
     * @var         String          $name: name of var to set value
     * @var         Mixed           $value: value to set to desired variable
     * return       Object          $this
     */
    public function set( $name, $value )
    {
        $this->$name = $value;
        return $this;
    }
    
    /**
     * Example of private method. Its a good pratice start with _ (undescore)
     *
     * @var
     * @return
     */
    private function _getShortSapiName( )
    {
        $name  = '';
        return $name;
    }
}
