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
class JXMLExtension extends ReadXml {

    /*
     * @var     string
     */
    public $author;

    /*
     * @var     string
     */
    public $authorEmail;

    /*
     * @var     string
     */
    public $authorUrl;

    /*
     * @var     string
     */
    public $copyright;

    /*
     * @var     string
     */
    public $creationDate;

    /*
     * @var     string      $client: site/administrator
     */
    public $client;
    
    /*
     * @var     string
     */
    public $description;

    /*
     * @var     string
     */
    public $license;

    /*
     * @var     string
     */
    public $name;

    /*
     * @var     string
     */
    public $update;

    /*
     * @var     string
     */
    public $packager;

    /*
     * @var     string
     */
    public $packagerurl;

    /*
     * @var     string      $type: type of the extension
     */
    public $type;

    /*
     * @var     string
     */
    public $version;



    /*
     * @todo: check this later
     */
    function __construct()
    {
        //$this->xml = $this->getObject();
    }

    public function getInfo()
    {
        $this->getObject();
        $this->name = (string)$this->xml->name;
        $this->author = (string)$this->xml->author;
        $this->authorEmail = (string)$this->xml->authorEmail;
        $this->authorUrl = (string)$this->xml->authorUrl;
        $this->copyright = (string)$this->xml->copyright;
        $this->creationDate = (string)$this->xml->creationDate;
        $this->description = (string)$this->xml->description;
        $this->license = (string)$this->xml->license;
        $this->update = (string)$this->xml->update;
        $this->packager = (string)$this->xml->packager;
        $this->packagerurl = (string)$this->xml->packagerurl;
        $this->version = (string)$this->xml->version;
    }

}