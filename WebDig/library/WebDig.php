<?php
/*
 * @package         WebDig
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */

class WebDig {

    /*
     * 
     */
    private $curl;
    
    /*
     * SSL Certificate. FALSE for none certificate
     * 
     * @var         Mixed
     */
    private $certificate = FALSE;
    
    /*
     * Target URL
     * 
     * @var         Mixed
     */
    private $url = null;
    
    /*
     * Content of last page
     * 
     * @var         Mixed
     */
    private $content = null;
    
    /*
     * Content of last page
     * 
     * @var         Array
     */
    private $history = array();
    

    /*
     * Initialize values
     */
   function __construct()
    {
       $this->curl = $ch = curl_init();//Init
       curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, 1); //Return value instead of print
       curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, $this->certificate); //SSL Certificate.
    }
    
   function __destruct() {
       curl_close( $this->curl );
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
     * Execute Dig. Set TRUE for return content. Default FALSE
     * 
     * @var        string          $method: TRUE for return contents, FALSE for not
     *
     * return       mixed          $this object OR $this->content String
     */
    public function dig( $method = FALSE )
    {
        curl_setopt( $this->curl, CURLOPT_URL, $this->url); //Set Target
        $this->content = curl_exec( $this->curl );//Execute
        $this->history[] = $this->content;
        
        if ($method === TRUE){
            return $this->content;
        } else {
            return $this;
        }
        
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
     * Set SSL certificate
     * 
     * @var        string           $value: name of var to return
     *
     * return       object          $this
     */
    public function setCertificate( $value )
    {
        $this->certificate = $value;
        curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, $this->certificate);

        return $this;
    }
    
    /*
     * Target URL
     * 
     * @var        string           $value: value to set
     *
     * return       object          $this
     */
    public function setUrl( $value )
    {
        $this->url = $value;

        return $this;
    }
}
