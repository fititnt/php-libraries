<?php
/*
 * @package         DynamicFileCreate
 * @subpackage      
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version         0.5beta1 (2011-14-08)
 */


class DynamicCreateFile {
    
 
    
    /* Content to be show/save
     * 
     * var      string     
     */
    private $content;
    
    /* Chaset of content
     * 
     * var      string     
     */
    private $charset = 'utf-8';
    
    /* Mime type of content
     * 
     * var      string     
     */
    private $type = 'text/plain';
    
    /* Path of file to save
     * Need only on save() method
     * 
     * var      string     
     */
    private $path;
    

    /* Name of file to save
     * Need only on save() method
     * 
     * var      string     
     */
    private $name = 'undefined.txt';
    
    /* Name of file to save
     * Need only on save() method
     * 
     * var      string     
     */
    private $cache = 'no-cache';

    
    
    function __contruct()
    {
        
    }

    /*  Method to show on page
     *  @var        string          $name: name of var
     * 
     * return       object      $this
     */
    public function show( )
    {
        $this->_setHeader();
        echo $this->content;
        return $this;
    }
    
    
    /* Method to save in file content
     * 
     * return       object      $this
     */
    public function save()
    {
        $handle = fopen( $this->path . DIRECTORY_SEPARATOR . $this->name, 'w+');
        
        if( $handle )
        {
            return false; // Cannot open
        }
        if( fwrite($handle, $this->content ) === FALSE )
        {
            return false; // Cannot write
        }
        fclose($handle);
        
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     *  @var        mixed           $value: value of var
     * 
     * return       object      $this
     */
    public function set( $name, $value )
    {
        $this->$name = $value;
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       object          $this
     */
    public function del( $name )
    {
        $this->$name = NULL;
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       object          $this
     */
    public function content( $value )
    {
        $this->content = $value;   
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       object          $this
     */
    public function path( $value )
    {
        $this->path = $value;   
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       object          $this
     */
    public function name( $value )
    {
        $this->name = $value;   
        return $this;
    }
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       object          $this
     */
    public function type( $value )
    {
        $this->type = $value;   
        return $this;
    }
    
    
    /*
     *  @var        string          $name: name of var
     * 
     * return       void            Print var_dump of files
     */
    public function debug()
    {
        echo "\ncontent: \n";
        var_dump( $this->content );
        echo "\npath: \n";
        var_dump( $this->path );
        echo "\nname: \n";
        var_dump( $this->name );
        echo "\ntype: \n";
        var_dump( $this->type );
    }
    
    /*
     * Create header()
     * Used when show() method is active
     * 
     * @return      void            set the header of file
     */
    private function _setHeader( )
    {
        
        
        switch( $this->type ){
            case 'html':
            case 'htm':         $content_type = 'text/html'; break; //application/javascript?
            case 'js': 
            case 'javascript':  $content_type = 'text/javascript'; break; //application/javascript?
            case 'css':         $content_type = 'text/css'; break;
            case 'pdf':         $content_type = 'application/pdf'; break;
            default:            $content_type = $this->type;
        }
        $header->contentType = $content_type;
        
        if( isset( $this->charset )){
            $header->charset .= '; charset='. $this->charset;
        } else {
            $header->charset .= '; charset=charset=';
        }
        
        $this->_printHeader( $header );
    }
    
    
    private function _printHeader( $header )
    {
        header('Content-type: '. $header->contentType . $header->charset);
        header('Pragma: '. $this->cache); 
    }
    
}