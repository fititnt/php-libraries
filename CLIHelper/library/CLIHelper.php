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
    
    /*
     * @var         String      Name of SAPI
     */
    private         $sapiName;
    
    
    /*
     * Determine if access is made by Command Line Interface
     * 
     * @var         Boolean      Full name of SAPI
     */
    private         $cli = FALSE;
    
    /*
     * Determine if access is made by Browser
     * 
     * @var         Boolean      Full name of SAPI
     */
    private         $browser = FALSE;
    

    /*
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
   
    /*
     * Function to debug $this object
     *
     * @var         String        $method: print_r or, var_dump
     * 
     * @var         Boolean       $format: true for print <pre> tags. Default false
     * 
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
    
    /*
     * Delete (set to NULL) generic variable
     * 
     * @var        String           $name: name of var do delete
     *
     * return      Object          $this
     */
    public function del( $name )
    {
        $this->$name = NULL;
        return $this;
    }
    
    /*
     * Return generic variable
     * 
     * @var        String          $name: name of var to return
     *
     * return      Mixed          $this->$name: value of var
     */
    public function get( $name )
    {
        return $this->$name;
    }
    
    /*
     * Return SAPI name
     * 
     *
     * @return      String           $this->$name: value of var
     */
    public function getSapi( )
    {
        $name = $this->sapiName;     
        return $name;
    }
    
    /*
     * Emulate CLI $argv even if accessed by browser
     * 
     * This script run both on PHP Command Line Interface and Browser 
     * For set directory on browser: add one param to url with any key but with one path 
     * example: /script.php?foo=C:/xampp/htaccess/mysyte 
     * on CLI, just add a new parameter 
     * example: php script.php C:/xampp/htaccess/mysyte
     * 
     * @see https://gist.github.com/1210131
     * 
     *
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
    
    /*
     * Set one generic variable the desired value
     * 
     * @var         String          $name: name of var to set value
     * 
     * @var         Mixed           $value: value to set to desired variable
     *
     * return       Object          $this
     */
    public function set( $name, $value )
    {
        $this->$name = $value;
        return $this;
    }
    
    /*
     * Example of private method. Its a good pratice start with _ (undescore)
     *
     * @var             <vartype>        <vardescription>
     * 
     * @return          <returntype>        <returndescription>
     */
    private function _getShortSapiName( )
    {
        $name  = '';
        return $name;
    }
}
