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

//DBParser is abstract. Just extend it here to test
class DBParserTest extends DBParser {
	function __construct() {
		parent::__construct();
	}
}

echo '<pre>';
echo "\t\tMYSQL: basic table info \n\n";
$pdo_mysql = new DBParserTest();

echo '<pre>';
$pdo_mysql
		->setDriver('mysql')
		->setHost('localhost')
		->setDatabase('db_bancada39')
		->setUsername('root')
		->setPassword('cain140ii')
		->connect();
;

//$pdo_mysql->prepare('DESC jos_content');
//$pdo_mysql->execute();
//var_dump($pdo_mysql->fetchAll());
print_r($pdo_mysql->getTableInfo('jos_content'));

echo '<pre>';
echo "\t\tPostGres: basic table info \n\n";
$pdo_postgresql = new DBParserTest();

echo '<pre>';
$pdo_postgresql
//		->setDriver('mysql')
		->setDriver('postgresql')
		->setHost('localhost')
		->setDatabase('db_bancada40')
		->setUsername('postgres')
		->setPassword('cain140ii')
		->connect();
;

//$pdo_mysql->prepare('DESC jos_content');
//$pdo_mysql->execute();
//var_dump($pdo_mysql->fetchAll());
//print_r($pdo_postgresql->getTableInfo('jos_content'));