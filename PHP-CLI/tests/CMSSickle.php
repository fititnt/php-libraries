<?php
/*
 * @package         PHP-CLI
 * @subpackage      ScanDirXml
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version
 */
/*
echo "This script run both on PHP Command Line Interface and Browser\n
For set directory on browser: add one param to url with any key but with one path\n
example: /script.php?foo=C:/xampp/htaccess/mysyte\n
on CLI, just add a new parameter\n
example: php script.php C:/xampp/htaccess/mysyte\n";
*/

/* Snippet code to emulate argv on browser like on CLI
 * Author: Emerson Rocha Luiz (http://fititnt.org) License: WTFPLv2
 */
if ( !isset($_SERVER['HTTP_USER_AGENT']) ) {
	$arguments = $argv;
} else {
	$arguments = array();
	$arguments[] = $_SERVER['SCRIPT_FILENAME'];
	foreach ($_GET as $key => $value){
		$arguments[] = $value;
	}
}

//ini_set('xdebug.max_nesting_level', 999);
include_once '../CMSSickle/CMSSickle.php';

if(!isset($arguments[1])) $arguments[1] = NULL;

$parseDir = new CMSSickle();
$start = microtime();
        $object = $parseDir->sickle( $arguments[1] );
$end = microtime();

print_r( $object );
echo sprintf("Run time:  %f", $end-$start);

