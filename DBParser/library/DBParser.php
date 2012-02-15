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

class DBParser {

	/**
	 * PDO connection resource
	 * 
	 * @var string 
	 */
	protected $_connection;

	/**
	 * PDO connection resource
	 * 
	 * @var string 
	 */
	protected $_conn_handler;

	/**
	 * Database Name
	 * 
	 * @var string 
	 */
	protected $database;

	/**
	 * PDO Driver
	 * 
	 * @var string 
	 */
	protected $driver;

	/**
	 * Databse username passowrd
	 * 
	 * @var string 
	 */
	private $password;

	/**
	 * Databse username
	 * 
	 * @var string 
	 */
	protected $username;

	/**
	 *
	 */
	function __construct() {
		
	}

	/**
	 * PDO execute statement
	 * 
	 * @param type $command
	 * @return instance This class 
	 */
	public function bind() {
		//...
		return $this;
	}

	/**
	 * Connect to desired Database
	 * 
	 * @example
	 * @code
	 * $postgresql = new DBParser();
	 * $postgresql
	 *		->setDriver('postgresql')
	 *		->setHost('localhost')
	 *		->setDatabase('db_name')
	 *		->setUsername('postgres')
	 *		->setPassword('password')
	 *		->connect();
	 * ;
	 * @endcode
	 * 
	 * @param mixed $driver if NULL or FALSE, reset connection. If string, load
	 *                      respective driver
	 * @return Object $this Suport for method chaining
	 * @throws Exception 
	 */
	public function connect($driver = TRUE) {
		if ($driver === FALSE || $driver === NULL) {
			$this->_connection = NULL;
			return $this;
		} else if ($driver !== TRUE && is_string($driver)) {
			$this->driver = $driver;
		}

		//If already has the conection, does noting
		if (!isset($this->_connection) || $this->_connection === NULL) {
			try {
				switch ($this->driver) {
					case 'mysql':
					case 'mysqli':
						$this->_connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
						break;
					case 'postgresql':
						$this->_connection = new PDO("pgsql:dbname={$this->database};host={$this->host};user={$this->username};password={$this->password}");
						break;
					case 'mssql':
						$this->_connection = new PDO("mssql:host={$this->host};dbname={$this->database}, $this->username, $this->password");
						break;
					case 'sybase':
						$this->_connection = new PDO("sybase:host={$this->host};dbname={$this->database}, $this->username, $this->password");
						break;
					default:
						throw new Exception('Database driver did not match (' . $this->driver . ')');
						break;
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		return $this;
	}

	/**
	 * Delete (set to NULL) generic variable
	 * 
	 * @param         String           $name: name of var do delete
	 * @return      Object          $this
	 */
	public function del($name) {
		$this->$name = NULL;
		return $this;
	}

	/**
	 * PDO execute statement
	 * 
	 * @param type $command
	 * @return instance This class 
	 */
	public function excecute($command = NULL) {
		$this->_conn_handler = $this->_connection->excecute($command);
		return $this;
	}

	/**
	 * Method to debug one class from inside
	 * 
	 * @see github.com/fititnt/php-snippet/tree/master/dump
	 * 
	 * @param array $option Whoe function must work
	 *						$option['method'] = 'default':
	 *							Return simple print_r() inside <pre>
	 *						$option['method'] = 'console':
	 *							Return values on javascript console of browsers
	 *						$option['die'] = 1:
	 *							If excecution must stop after excecution
	 * 
	 * @return Object $this Suport for method chaining
	 */
	public function debug($option = array()) {
		if (!isset($option['method'])) {
			$option['method'] = 'default';
		}
		switch ($option['method']) {
			case 'console':
				$html = array();
				$date = date("Y-m-d h:i:s");
				$html[] = '<script>';
				$html[] = 'console.groupCollapsed("' . __CLASS__ . ':' . $date . '");';
				//@todo: add separed group (fititnt, 2012-02-15 02:03)
				$html[] = 'console.groupCollapsed("$this");';
				$html[] = 'console.dir(eval(' . json_encode($this) . '));';//evail is evil... And?
				$html[] = 'console.groupEnd()';
				$html[] = 'console.groupEnd()';
				$html[] = '</script>';
				echo implode(PHP_EOL, $html);
				break;
			case 'default':
			default:
				echo '<pre>';
				print_r($this);
				echo '</pre>';
				break;
		}
		if (isset($option['die'])) {
			die;
		}
		return $this;
	}

	/**
	 * Return generic variable
	 * 
	 * @param         String          $name: name of var to return
	 * @return      Mixed          $this->$name: value of var
	 */
	public function get($name) {
		return $this->$name;
	}

	/**
	 * PDO prepare statement
	 * 
	 * @param type $command
	 * @return instance This class 
	 */
	public function prepare($command) {
		if ($command === FALSE || $driver === NULL) {
			$this->_conn_handler = NULL;
			return $this;
		}
	}

	/**
	 * Set one generic variable the desired value
	 * 
	 * @param         String          $name: name of var to set value
	 * @param         Mixed           $value: value to set to desired variable
	 * @return      Object          $this
	 */
	public function set($name, $value) {
		$this->$name = $value;
		return $this;
	}

	/**
	 * Set database name
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this
	 */
	public function setDatabase($value) {
		$this->database = strtolower($value);
		return $this;
	}

	/**
	 * Set database driver
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this
	 */
	public function setDriver($value) {
		$this->driver = strtolower($value);
		return $this;
	}

	/**
	 * Set database host
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this
	 */
	public function setHost($value) {
		$this->host = strtolower($value);
		return $this;
	}

	/**
	 * Set database password
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this
	 */
	public function setPassword($value) {
		$this->password = strtolower($value);
		return $this;
	}

	/**
	 * Set database username
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this
	 */
	public function setUsername($value) {
		$this->username = strtolower($value);
		return $this;
	}

}
