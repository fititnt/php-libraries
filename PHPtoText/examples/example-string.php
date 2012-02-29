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

include_once '../library/PHPtoString.php';

$phpstring = new PHPtoString;
$phpstring->setContent('Line 1');
$phpstring->setContent('Line 2');
$phpstring->setContent('Line 3');
$phpstring->setContent('Line 4');

echo '<pre>';
echo $phpstring->getContent();
//Line 1
//Line 2
//Line 3
//Line 4

//var_dump($phpstring);
