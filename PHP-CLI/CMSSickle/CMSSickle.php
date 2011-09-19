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
 * Class to do a recursive search for CMSs in a directory
 */

class CMSSickle {


    private $cms = array();

    public function sickle( $directory = NULL)
    {
        $cms = array();
        $this->parse( $directory, $this->cms );
        print_r($this->cms);
    }

    /*
     * Parse directory in to one object
     * @return      object
     */
    public function parse( $directory = NULL , &$cms = NULL)
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
                if( is_dir($path) && is_readable($path) )//Be sure if file or path is readable before try parse it
                {
                    $info[] = array(
                        'path'          => $path
                    );

                    if($cms === NULL){
                        //$cms =
                    }

                    $this->_checkCMS( $path , $this->cms );

                    $this->parse($path);
                }
            }
        }
        closedir($dir);

        return $info;
    }

    /*
     *  Clear and prepare Directory name to be used
     *  @todo: this function will have problems with redeclaration of JVersions... Solve it!
     */
    private function _checkCMS( $path, &$cms )
    {

        $administratorFolder = 0; //Joomla!1.0+
        $includesFolder = 0; //Joomla!1.0+
        $mambotsFolder = 0; //Joomla!1.0+
        $librariesFolder = 0; //Joomla!1.5+

        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (($item = readdir($handle)) !== false ) {

                if( strpos($item, 'administrator')  !== FALSE ){
                    ++$administratorFolder;
                }
                if( strpos($item, 'includes')  !== FALSE ){
                    ++$includesFolder;
                }
                if( strpos($item, 'mambots')  !== FALSE ){
                    ++$mambotsFolder;
                }
                if( strpos($item, 'libraries')  !== FALSE ){
                    ++$librariesFolder;
                }
                //echo "$file\n";
            }
            
            //check Joomla
            if($includesFolder && $includesFolder)
            {

                //Check Joomla 1.7
                if(file_exists($path.'/includes/version.php') && !$mambotsFolder)
                {
                    $josInfo = array();
                    $josInfo['path'] = $path;
                    $josInfo['version'] = $this->_getStringNow($path.'/includes/version.php', '$RELEASE') . '.' . $this->_getStringNow($path.'/includes/version.php', '$DEV_LEVEL');
                    $cms[] = $josInfo;
                    return;
                }
                //Check Joomla 1.5 & 1.6
                if(file_exists($path.'/libraries/joomla/version.php'))
                {
                    $josInfo = array();
                    $josInfo['path'] = $path;
                    $cms[] = $josInfo;
                    return;
                }
                //Check Joomla 1.0
                if(file_exists($path.'/includes/version.php'))
                {
                    $josInfo = array();
                    $josInfo['path'] = $path;
                    $cms[] = $josInfo;
                    return;
                }
            }


            closedir($handle);
        }
        return $path;
    }

    /*
     *  Dirty way to get var from version.php
     *  Can't redeclare, I'm better don`t use eval()s...
     *
     * @var         string          $file: path to file
     * @var         string          $string: name of string to take
     * @return      string          $value: value of string. Boolean FALSE if not found
     */
    private function _getStringNow( $file, $string)
    {
        $fp = fopen($file, "r");
        if( $fp !== FALSE){
          $value = $fp;//...
        }
        fclose($fp);

        //$value = 'teste';
        return $value;
    }

    /*
     *  Clear and prepare Directory name to be used
     */
    private function _clearDirectory( $name = NULL)
    {
        if($name === NULL){
            $name = getcwd();
        }
        //If have / or \ at the end, clear it
        if( substr($name,-1) == '/' || substr($name,-1) == '\\')
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