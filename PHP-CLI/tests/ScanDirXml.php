<?php
/*
 * @package         PHP-CLI
 * @subpackage      ScanDirXml
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version
 */
//defined('_JEXEC') or die; // no direct access

// Function parse, just for testing the classe ParseDirectory
function parse($directory)
{
    $info = array();
    $dir = opendir( $directory );
    while ( ( $filePointer = readdir($dir)) !== FALSE )
    {
        if( $filePointer != '.' && $filePointer != '..' )
        {
            $path = $directory .'/'.$filePointer;
            if( is_readable($path) )//Be sure if file or path is readable before try parse it
            {
                $subdirs = explode('/',$path);
                if(is_dir($path))
                {
                    $info[] = array(
                        'path'          => $path,
                        'type'          => 'directory',
                        'name'          => end($subdirs),
                        'permission'    => substr( decoct( fileperms($path) ), 1),
                        'content'       => parse($path));
                }elseif(is_file($path))
                {
                    $ext = substr( strrchr( end($subdirs),'.' ),1 );
                    $info[] = array(
                        'path'          => $path,
                        'type'          => $ext,
                        'name'          => end($subdirs),
                        'permission'    => substr( decoct( fileperms($path) ), 2),
                        'edited'        => date ("Y:m:d H:i:s", filemtime($path)),
                        'size'          => filesize($path),
                        'md5'           => md5_file($path)
                    );
                }
            }
        }
    }
    closedir($dir);
    return $info;
}


//Define paths for test
$jCmsPath = "C:/xampp/htdocs/bancada26/templates/beez5/html/com_contact";
//$jCmsPath = "C:/xampp/htdocs/bancada26/templates/beez5/css";


//function parse test
print_r(parse($jCmsPath));


//Class ParseDirectory test
/*
ini_set('xdebug.max_nesting_level', 300);
include_once '../ParseDirectory/ParseDirectory.php';
$parseDir = new ParseDirectory();
$parseDir->directory($jCmsPath);
print_r($parseDir->parse());
*/