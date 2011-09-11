<?php
/*
 * @package         PHP-CLI
 * @subpackage      ReadXml
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version         
 */
//defined('_JEXEC') or die; // no direct access

/*
 * @note:       dependences: Framework Independent
 */

class ReadXml {

    /*
     * @var     string      $file: path to file xml to read
     */
    public $file;

    /*
     * @var     string      $data: string to read
     */
    public $data;

    /*
     * @var     object      $xml
     */
    public $xml;

    /*
     * getObject from file $file or from string $data
     * @return      void
     */
    public function getObject()
    {
        if( $this->file !== NULL)
        {
            $this->xml = simplexml_load_file($this->file);
        } else if ($this->data !== NULL)
        {
            $this->xml = simplexml_load_string($this->data);
        } else {
            $this->xml = FALSE;
        }
        //print_r($this->xml);
    }
}