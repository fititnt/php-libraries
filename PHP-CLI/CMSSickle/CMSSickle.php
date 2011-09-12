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
                    defined('_JEXEC') or define('_JEXEC', 1);
                    include_once $path.'/includes/version.php';
                    $jos = new JVersion();
                    $josInfo = array();
                    $josInfo['path'] = $path;
                    $josInfo['product'] = $jos->PRODUCT;
                    $josInfo['version'] = JVERSION;
                    $josInfo['released'] = $jos->RELDATE;
                    $cms[] = $josInfo;
                    return;
                }
                //Check Joomla 1.5 & 1.6
                if(file_exists($path.'/libraries/joomla/version.php'))
                {
                    defined('JPATH_BASE') or define('JPATH_BASE', 1);
                    include_once $path.'/libraries/joomla/version.php';
                    $jos = new JVersion();
                    $josInfo = array();
                    $josInfo['path'] = $path;
                    $josInfo['product'] = $jos->PRODUCT;
                    $josInfo['version'] = $jos->getShortVersion();
                    $josInfo['released'] = $jos->RELDATE;
                    $cms[] = $josInfo;
                    $cms[]= $path;
                    return;
                }
                //Check Joomla 1.0
                if(file_exists($path.'/includes/version.php'))
                {
                    defined('_VALID_MOS') or define('_VALID_MOS', 1);
                    //include_once path.'/includes/version.php';
                    //$jos = new joomlaVersion();
                    echo 'j10! ';
                    $cms[]= $path;
                    return;
                }
            }


            closedir($handle);
        }
        return $path;
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