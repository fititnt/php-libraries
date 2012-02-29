<?php

/*
 * @package         PHPtoText
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2012 Webdesign Assessoria em Tecnilogia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //better debug

include_once '../library/PHPtoJavascript.php';

$phpjs = new PHPtoJavascript;

$phpjs->setContent('alert("hi")');
$phpjs->setContent('alert("hello")');
$phpjs->setHeaderMimeType('js');
$phpjs->setHeaderCache(FALSE);
$phpjs->getHeader(true);

//Cache-Control	no-cache, must-revalidate
//Connection	Keep-Alive
//Content-Length	27
//Content-Type	application/javascript
//Date	Wed, 29 Feb 2012 04:56:37 GMT
//Expires	Sun, 25 Jan 1986 05:00:00 GMT
//Keep-Alive	timeout=5, max=100
//Server	Apache/2.2.21 (Win32) PHP/5.3.8
//X-Powered-By	PHP/5.3.8

echo $phpjs->getContent();
//alert("hi")
//alert("hello")
//var_dump($phpjs);
