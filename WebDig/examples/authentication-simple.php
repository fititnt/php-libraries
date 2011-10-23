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
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //better debug. Or not. Haha!
include_once '../../CLIHelper/library/CLIHelper.php';
include_once '../library/WebDig.php';



$clih = new CLIHelper();
 
//echo $clih->getUrlDir();

$wd = new WebDig(); 

$wd ->setDebug('autentication-simple-debug.log', TRUE) //Setup debug file in current directory
    ->setCookie('autentication-simple-cookie.log') //Setup cookies file
    ->setTarget( $clih->getUrlDir() . '/targets/autentication-simple/login.php' ) //Target to go
    ->post( array(
            'username' => 'user',
            'password' => 'pass'
             )
           )
    ->get('content');

$wd->debug();
