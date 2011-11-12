<?php
/**
 * @package         WebDig
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //better debug. Or not. Haha!
include_once '../library/WebDig.php';

$wd = new WebDig(); 
echo $wd->setDebug('debug-autentication-apache.log', TRUE)
    ->setTarget('http://auth.fititnt.org/')
    ->post( array(
            'username' => 'infinitum',
            'password' => 'senha'
             )
           )
    ->get('content');

$wd->debug();