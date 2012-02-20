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


$pdo_postgresql = new DBParserTest();

echo '<pre>';
echo "\t\tPOSTGRES: basic connection \n\n";
$pdo_postgresql
//		->setDriver('mysql')
		->setDriver('postgresql')
		->setHost('localhost')
		->setDatabase('db_bancada40')
		->setUsername('postgres')
		->setPassword('cain140ii')
		->connect();
;

print_r($pdo_postgresql->debug(array('method'=> 'console')));
//DBParser Object
//(
//    [_conn_handler:protected] => 
//    [database:protected] => db_bancada40
//    [driver:protected] => postgresql
//    [last_result:protected] => 
//    [password:DBParser:private] => cain140ii
//    [username:protected] => postgres
//    [host] => localhost
//    [_connection:DBParser:private] => PDO Object
//        (
//        )
//
//)


echo '<pre>';
echo "\t\tMYSQL: basic connection \n\n";
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

print_r($pdo_mysql->debug(array('method'=> 'console')));
//DBParser Object
//(
//    [_conn_handler:protected] => 
//    [database:protected] => db_bancada39
//    [driver:protected] => mysql
//    [last_result:protected] => 
//    [password:DBParser:private] => cain140ii
//    [username:protected] => root
//    [host] => localhost
//    [_connection:DBParser:private] => PDO Object
//        (
//        )
//
//)

echo '<pre>';
echo "\t\tPOSTGRES: Return all fields from query \n\n";

$pdo_postgresql->prepare('SELECT * FROM jos_content');
$pdo_postgresql->execute();
var_dump($pdo_postgresql->fetchAll());

//array(66) {
//  [0]=>
//  array(68) {
//    ["id"]=>
//    int(1)
//    [0]=>
//    int(1)
//    ["asset_id"]=>
//    string(2) "89"
// (...)
