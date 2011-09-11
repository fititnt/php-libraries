<?php
/*
 * @package         PHP-CLI
 * @subpackage      ReadXml
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version         
 */
//defined('_JEXEC') or die; // no direct access

/*
 * @note:       dependences: Framework Independent
 */

class ParseDirectory {

    /*
     * @var     string      $directory: path to file xml to read
     */
    public $directory;

    static $filePointer;

    public function directory($name)
    {
        //If have / at the end, clear it
        if( substr($name,-1) == '/')
        {
            $name = substr($name,0,-1);
        }
        //The directory exist? Is really one directory? Is readable?
        if(!file_exists($name) || !is_dir($name) || !is_readable($name)){
            return FALSE;
        }

        $this->directory  = $name;
        return $this;
    }

    /*
     * Parse directory in to one object
     * @return      object
     */
    public function parse()
    {
        $info = array();
        $dir = opendir( $this->directory );
        while ( ( $this->filePointer = readdir($dir)) !== FALSE )
        {
            if( $this->filePointer != '.' && $this->filePointer != '..' )
            {
                $path = $this->directory .'/'.$this->filePointer;
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
                            'content'       => $this->parse($path));
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
}