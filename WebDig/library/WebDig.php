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
class WebDig {

    /**
     * Created resource of cURL
     * 
     * @var Resource
     */
    private $curl;

    /**
     * SSL Certificate. FALSE for none certificate
     * 
     * @var Mixed
     */
    private $certificate = FALSE;

    /**
     * Last assigned path to file cookie
     * 
     * @var String
     */
    private $cookieFile = null;

    /**
     * Define if debug mode must be persistent, i.e., if must be log aways and 
     * not only when is seted when dig
     * 
     * @var Boolean
     */
    private $debugPersistent = FALSE;

    /**
     * Set debug file resource ( fopen() )
     * 
     * @var resource
     */
    private $debugFile = null;

    /**
     * Target URL
     * 
     * @var Mixed
     */
    private $target = null;

    /**
     * Content of last page
     * 
     * @var Mixed
     */
    private $content = null;

    /**
     * Content of last page
     * 
     * @var Array
     */
    private $history = array();

    /**
     * Initialize values
     */
    function __construct() {
        $this->curl = $ch = curl_init(); //Init
        //Browsing
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1); //Return value instead of print
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1); //Accept redirects
        //curl_setopt ($ch, CURLOPT_MAXREDIRS, 1); //Maximum redirects
        //Time to excecute in seconds
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 30); //The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30); //The maximum number of seconds to allow cURL functions to execute.
        //SSL
        //curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, $this->certificate); //SSL Certificate.
        //Emulate Google Agent by default
        curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
    }

    /**
     * Close cURL resource
     * 
     */
    function __destruct() {
        curl_close($this->curl);
        if (!is_null($this->debugFile)) {
            fclose($this->debugFile);
        }
    }

    /**
     * Function to debug $this object
     *
     * @param[in] String        $method: print_r or, var_dump
     * @param[in] boolean       $format: true for print <pre> tags. Default false
     * @return void
     */
    public function debug($method = 'print_r', $format = FALSE) {
        if ($format) {
            echo '<pre>';
        }
        if ($method === 'print_r') {
            print_r($this);
        } else {
            var_dump($this);
        }
        if ($format) {
            echo '</pre>';
        }
    }

    /**
     * Delete (set to NULL) generic variable
     * 
     * @param[in] String $name: name of var do delete
     * return Object $this
     */
    public function del($name) {
        $this->$name = NULL;
        return $this;
    }

    /**
     * Execute Dig. Set TRUE for return content. Default FALSE
     * Note that if you enable $debug, it will only print aditional info or via
     * PHP CLI, or via saved file with 
     * 
     * @param[in] String $target: URL to dig. Default NULL.
     * @param[in] String $method: TRUE for return contents. Default FALSE.
     * @param[in] String $debug: enable cURL debug. Default FALSE.
     * @param[in] String $special: special params
     * @return Mixed $this object OR $this->content String
     */
    public function dig($target = NULL, $method = FALSE, $debug = FALSE, $special = NULL) {
        //Set target
        if ($target !== NULL) {
            $this->target = $target;
        }
        curl_setopt($this->curl, CURLOPT_URL, $this->target); //Set Target        
        //Set post
        if ($special !== NULL) {
            if (isset($special['POST'])) {
                curl_setopt($this->curl, CURLOPT_POST, TRUE);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($special['POST'], '', '&'));
            }
            /*
              if ( isset($special['GET']) )
              {
              curl_setopt( $this->curl, CURLOPT_POST, TRUE);

              }
             */
        } else {
            //Few resets. Think latter if is good always reset, or reset only 
            //when was seted
            curl_setopt($this->curl, CURLOPT_POST, FALSE);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, NULL);
        }

        //Set debug
        if (!$this->debugPersistent) {
            //If debug is arealdy persistent, it means that verbose was seted to
            // true, so is not need reset it here again
            if ($debug) { //Check later if is working
                curl_setopt($this->curl, CURLOPT_VERBOSE, TRUE);
            } else {
                //Just for permit override verbose if is seted before
                curl_setopt($this->curl, CURLOPT_VERBOSE, FALSE);
            }
        }


        $this->content = curl_exec($this->curl); //Execute
        $this->history[] = $this->content;

        if ($method === TRUE) {
            return $this->content;
        } else {
            return $this;
        }
    }

    /**
     * Return generic variable
     * 
     * @param[in] String $name: name of var to return
     * @return mixed $this->$name: value of var
     */
    public function get($name) {
        return $this->$name;
    }

    /**
     * Return generic variable
     * 
     * @param[in] String $name: name of var to return
     * return Mixed $cookie: value of var
     */
    public function getCookie($filepath = FALSE) {
        if ($filepath) {
            $cookie = $this->cookieFile;
        } else {
            $cookie = $this->_getFileContents($this->cookieFile);
        }

        return $cookie;
    }

    /**
     * Alias for curl_getinfo
     * Return informatou about some last actions performed
     * Read more on http://www.php.net/manual/pt_BR/function.curl-getinfo.php
     * 
     * @param[in] String $option: curl_getinfo constant
     * @return Array $cookie: value of var
     */
    public function getInfo($option = NULL) {
        $info = curl_getinfo($this->curl, $option);

        return $info;
    }

    /**
     * Similar to dig, but also post info
     * 
     * @param[in] Mixed $data: array of data or string like 'foo=1&bar=2'
     * @param[in] String $target: URL to dig. Default NULL.
     * @param[in] String $method: TRUE for return contents. Default FALSE.
     * @param[in] String $debug: enable cURL debug. Default FALSE.
     * @return Mixed $response object string of dig() function
     */
    public function post($data, $target = NULL, $method = FALSE, $debug = FALSE) {
        $response = $this->dig($target, $method, $debug, array('POST' => $data));
        return $this;
    }

    /**
     * Set one generic variable the desired value
     * 
     * @param[in] String $name: name of var to set value
     * @param[in] Mixed $value: value to set to desired variable
     * return Object $this
     */
    public function set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    /**
     * Set SSL certificate
     * 
     * @param String $value: name of var to return
     * @return Object $this
     */
    public function setCertificate($value) {
        $this->certificate = $value;
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $this->certificate);

        return $this;
    }

    /**
     * Set SSL certificate
     * 
     * @param[in] String $value: name of var to return
     * @param[in] Boolean $persistent: if debug must be persistent or not
     * @return Object $this
     */
    public function setDebug($filepath = "debug.log", $persistent = FALSE) {
        if ($persistent) {
            $this->debugPersistent = $persistent;
            curl_setopt($this->curl, CURLOPT_VERBOSE, TRUE);
        }

        $this->debugFile = fopen($filepath, 'a+');
        curl_setopt($this->curl, CURLOPT_STDERR, $this->debugFile);
        return $this;
    }

    /**
     * Enable cookie for session
     * 
     * @param[in] String $value: name of var to return
     * @return Object $this
     */
    public function setCookie($path = NULL) {
        $this->cookieFile = $this->_setFile($path);

        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookieFile);

        return $this;
    }

    /**
     * @todo: not tested. Do it later
     * 
     * @param[in] String $host: Host of proxy. Normaly one IPv4
     * @param[in] String $port: proxy port. Default 80
     * @param[in] String $username: username of proxy. Default NULL
     * @param[in] String $password: password of proxy port. Default NULL
     * @return Object $this
     */
    public function setProxy($host, $port = '80', $username = NULL, $password = NULL) {
        curl_setopt($this->curl, CURLOPT_PROXY, "endereco do proxy");
        curl_setopt($this->curl, CURLOPT_PROXYPORT, "porta");
        if ($username !== NULL && $password !== NULL) {
            curl_setopt($this->curl, CURLOPT_PROXYUSERPWD, $username . ':' . $password);
        }
        return $this;
    }

    /**
     * Target URL
     * 
     * @param[in] String $value: value to set
     * @return Object $this
     */
    public function setTarget($value) {
        $this->target = $value;

        return $this;
    }

    /**
     * Custom cURL otion
     * http://php.net/manual/en/function.curl-setopt.php
     * 
     * @param[in] String $name: value to set
     * @param[in] String $value: value to set. Default 1.
     * @return object $this
     */
    public function setcURLOption($name, $value = 1) {
        curl_setopt($this->curl, $name, $this->target);

        return $this;
    }

    /**
     * Test if path give is able to be used for write, and, if not, will try
     * create a new unique file
     * 
     * @todo: improve this function for cases where tempnam() is disabled
     * 
     * @param String $path: path for check if is valid
     * @return Mixed $filepath: path for a valid file, or false if can't create it
     */
    private function _setFile($path = NULL) {
        if ($path === NULL || file_exists($path) && is_readable($path)) {
            //Get temp absolute path
            //$tempPath = realpath( sys_get_temp_dir() ); //If errors, implement workarounds of http://php.net/manual/en/function.sys-get-temp-dir.php
            $tempPath = '/tmp';

            $filepath = tempnam($tempPath, 'WebDig');
        } else {
            $filepath = $path;
        }

        return $filepath;
    }

    /**
     * Read one file and return it's contents in a string
     * 
     * @todo: improve this function for cases where tempnam() is disabled
     * @param[in] String $path: path for check if is valid
     * @return Mixed $content: content for a valid file, or false if can't create it
     */
    private function _getFileContents($filepath) {
        /*
          $content = '';
          if ( file_exists( $filepath ) && is_readable ( $filepath ) ) {
          $fp = fopen( $filepath , 'r');

          while (!feof( $fp )) {
          $line = fgets( $fp );
          //@todo: some check for remove unecessari lines
          $content .= $line;
          }


          fclose( $fp );
          }
         */
        $content = readfile($filepath);

        return $content;
    }

}
