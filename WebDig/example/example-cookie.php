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
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //better debug

//include_once '../library/PageParser.php';
//$pp = new PageParser();

include_once '../../WebDig/library/WebDig.php';

$wd = new WebDig(); //Create new object based on ClassFluentInterface

$wd->setUrl('http://www.google.com.br')->setCookie()->dig(TRUE);

echo $wd->getCookie(TRUE); //Return path to temp file
echo $wd->getCookie(); //Print cookie file. Still need more test
