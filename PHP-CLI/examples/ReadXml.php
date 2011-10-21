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

include_once '../ReadXml/ReadXml.php';
include_once '../ReadXml/JXMLExtension.php';

$xml = new JXMLExtension();
$xml->file = 'C:\xampp\htdocs\bancada26\templates\beez5/templateDetails.xml';
//$xml->getObject();
$xml->getInfo();
//print_r($xml);
//echo $xml->"@atributtes":

echo "\n $xml->type - $xml->name";
echo "\n $xml->description";
echo "\n $xml->author - $xml->authorEmail - $xml->authorUrl";

