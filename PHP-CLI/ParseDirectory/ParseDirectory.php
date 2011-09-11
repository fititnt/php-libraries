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
     * Parse directory in to one object
     * @return      object
     */
    public function parse( $directory = NULL )
    {
        $directory = $this->_clearDirectory( $directory );

        if(!$directory){
            return FALSE;
        }

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
                            'content'       => $this->parse( $path )
                        );
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

    /*
     *  Clear and prepare Directory name to be used
     */
    private function _clearDirectory( $name = NULL)
    {
        if($name === NULL){
            $name = getcwd();
        }
        //If have / at the end, clear it
        if( substr($name,-1) == '/')
        {
            $name = substr($name,0,-1);
        }
        //The directory exist? Is really one directory? Is readable?
        if(!file_exists($name) || !is_dir($name) || !is_readable($name)){
            return FALSE;
        }
        return $name;
    }
}