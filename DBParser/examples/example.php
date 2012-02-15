<?php

/*
 * @package         DBParser
 * @author          Emerson Rocha Luiz - emerson at webdesign.eng.br - http://fititnt.org
 * @copyright       Copyright (C) 2011 Webdesign Assessoria em Tecniligia da Informacao. All rights reserved.
 * @license         GNU General Public License version 3. See license-gpl3.txt
 * @license         Massachusetts Institute of Technology. See license-mit.txt
 * @version         0.1alpha
 * 
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //better debug
include_once '../library/DBParser.php';

$postgresql = new DBParser();

echo '<pre>';
$postgresql
//		->setDriver('mysql')
		->setDriver('postgresql')
		->setHost('localhost')
		->setDatabase('db_bancada40')
		->setUsername('postgres')
		->setPassword('cain140ii')
		->connect();
;

print_r($postgresql->debug());

$pdo_mysql = new DBParser();

echo '<pre>';
$pdo_mysql
		->setDriver('mysql')
		->setHost('localhost')
		->setDatabase('db_bancada39')
		->setUsername('root')
		->setPassword('cain140ii')
		->connect();
;

print_r($pdo_mysql->debug(array('method'=> 'console')));
