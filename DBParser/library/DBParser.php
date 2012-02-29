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

abstract class DBParser {

	/**
	 * PDO connection resource
	 * 
	 * @var string 
	 */
	private static $_connection;

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
	 * Contains result of some of last executed methods
	 * 
	 * This function may return Boolean FALSE, but may also return a non-Boolean
	 * value which evaluates to FALSE. Please read the section on Booleans for 
	 * more information. Use the === operator for testing the return value of 
	 * this function.
	 * 
	 * @see exec()
	 * 
	 * @var mixed 
	 */
	protected $last_result;

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
	 * @return Object $this Suport for method chaining
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
	 * 		->setDriver('postgresql')
	 * 		->setHost('localhost')
	 * 		->setDatabase('db_name')
	 * 		->setUsername('postgres')
	 * 		->setPassword('password')
	 * 		->connect();
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
	 * @param String $name: name of var do delete
	 * @return Object $this Suport for method chaining
	 */
	public function del($name) {
		$this->$name = NULL;
		return $this;
	}

	/**
	 * Fetch results
	 * 
	 * @see setFetchMode()
	 * 
	 * @return mixed Results
	 */
	public function fetch() {
		return $this->_conn_handler->fetch();
		;
	}

	/**
	 * Fetch results
	 * 
	 * @see setFetchMode()
	 * 
	 * @return mixed Results
	 */
	public function fetchAll() {
		return $this->_conn_handler->fetchAll();
		;
	}

	/**
	 * Proxy for PDO::exec
	 * 
	 * Execute an SQL statement and return the number of affected rows.
	 * This does not return results from a SELECT statement. For a SELECT 
	 * statement that you only need to issue once during your program, 
	 * consider issuing query(). For a statement that you need to issue 
	 * multiple times, prepare object with prepare() and issue the statement 
	 * with execute().
	 * 
	 * @param string $command
	 * @return Object $this Suport for method chaining
	 */
	public function exec($command) {
		$this->last_result = $this->_connection->exec($command);
		return $this;
	}

	/**
	 * PDO execute statement
	 * 
	 * @todo Think better if this method like is now is really right (fititnt, 
	 * 2012-02-15 07:47)
	 * 
	 * @param type $command
	 * @return Object $this Suport for method chaining
	 */
	public function execute($command = NULL) {
		$this->_conn_handler->execute($command);
		return $this;
	}

	/**
	 * Method to debug one class from inside
	 * 
	 * @see github.com/fititnt/php-snippet/tree/master/dump
	 * 
	 * @param array $option Whoe function must work
	 * 						$option['method'] = 'default':
	 * 							Return simple print_r() inside <pre>
	 * 						$option['method'] = 'console':
	 * 							Return values on javascript console of browsers
	 * 						$option['die'] = 1:
	 * 							If excecution must stop after excecution
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
				$html[] = 'console.dir(eval(' . json_encode($this) . '));'; //evail is evil... And?
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
	 * @param String $name: name of var to return
	 * @return Mixed $this->$name: value of var
	 */
	public function get($name) {
		return $this->$name;
	}
	
	/**
	 * Return information about one table
	 * 
	 * @param string $table Name of table
	 * @return array 
	 */
	public function getTableInfo($table){
		switch ($this->driver) {
			case 'postgresql':
			default:
				$this->prepare('\d ' . $table);//Needs more test
			case 'mysql':
			default:
				$this->prepare('DESC ' . $table);
				break;
		}
		$this->execute();
		return $this->fetchAll();
	}

	/**
	 * Return last inserted ID
	 * 
	 * @return Mixed $this->_connection->lastInsertId()
	 */
	public function lastInsertId() {
		return $this->_connection->lastInsertId();
	}

	/**
	 * Proxy for PDO::prepare
	 * Prepares an SQL statement to be executed by the execute() 
	 * method. The SQL statement can contain zero or more named (:name) or 
	 * question mark (?) parameter markers for which real values will be 
	 * substituted when the statement is executed. You cannot use both named 
	 * and question mark parameter markers within the same SQL statement; pick 
	 * one or the other parameter style. Use these parameters to bind any 
	 * user-input, do not include the user-input directly in the query.
	 * 
	 * You must include a unique parameter marker for each value you wish to 
	 * pass in to the statement when you call execute(). You 
	 * cannot use a named parameter marker of the same name twice in a prepared 
	 * statement. You cannot bind multiple values to a single named parameter 
	 * in, for example, the IN() clause of an SQL statement.
	 * 
	 * Calling prepare() and execute() for statements that will be issued 
	 * multiple times with different parameter values optimizes the performance 
	 * of your application by allowing the driver to negotiate client and/or 
	 * server side caching of the query plan and meta information, and helps to 
	 * prevent SQL injection attacks by eliminating the need to manually quote 
	 * the parameters.
	 * 
	 * PDO will emulate prepared statements/bound parameters for drivers that do
	 * not natively support them, and can also rewrite named or question mark 
	 * style parameter markers to something more appropriate, if the driver 
	 * supports one style but not the other.
	 * 
	 * @see http://www.php.net/manual/en/pdo.prepare.php
	 * @see setFetchMode()
	 * 
	 * @param type $statement This must be a valid SQL statement for the target 
	 *                        database server.
	 * @return Object $this Suport for method chaining
	 */
	public function prepare($statement) {
		if ($statement === FALSE || $statement === NULL) {
			$this->_conn_handler = NULL;
			return $this;
		}
		$this->_conn_handler = $this->_connection->prepare($statement);
		return $this;
	}

	/**
	 * Proxy for PDO::query
	 * Executes an SQL statement in a single function call, returning the result
	 * set (if any) returned by the statement as a PDOStatement object
	 * 
	 * 
	 * 
	 * @see http://www.php.net/manual/en/pdo.query.php
	 * @see quote()
	 * 
	 * @param string $statement The SQL statement to prepare and execute. Data 
	 *               inside the query should be properly escaped.
	 * @return mixed $result Returns a PDOStatement object, or FALSE on failure.
	 */
	public function query($statement) {
		$result = $this->_connection->query($statement);
		return $result;
	}

	/**
	 * Quotes strings to be safe to use on queries. Useful if is not using
	 * prepared statements
	 * 
	 * @return mixed $safe Quoted variable
	 */
	public function quote($unsafe) {
		$safe = $this->_connection->quote($unsafe);
		return $safe;
	}

	/**
	 * Number of rows affected of last operation
	 * 
	 * @return int $count Suport for method chaining
	 */
	public function rowCount($unsafe) {
		$count = $this->_conn_handler->rowCount($unsafe);
		return $count;
	}

	/**
	 * Set one generic variable the desired value
	 * 
	 * @param String $name: name of var to set value
	 * @param Mixed $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function set($name, $value) {
		$this->$name = $value;
		return $this;
	}

	/**
	 * Set database name
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function setDatabase($value) {
		$this->database = strtolower($value);
		return $this;
	}

	/**
	 * Define fetch mode.
	 * 
	 * @param string $mode: Fetch mode. Default: BOTH
	 * @return Object $this Suport for method chaining
	 */
	public function setFetchMode($mode = 'BOTH') {
		switch (strtoupper($mode)) {
			case 'ASSOC':
			case 'FETCH_ASSOC':
				$this->_conn_handler->rowCount(PDO::FETCH_ASSOC);
				break;
			case 'BOTH':
			case 'FETCH_BOTH':
				$this->_conn_handler->rowCount(PDO::FETCH_BOTH);
				break;
			case 'BOUND':
			case 'FETCH_BOUND':
				$this->_conn_handler->rowCount(PDO::FETCH_BOUND);
				break;
			case 'CLASS':
			case 'FETCH_CLASS':
				$this->_conn_handler->rowCount(PDO::FETCH_CLASS);
				break;
			case 'INTO':
			case 'FETCH_INTO':
				$this->_conn_handler->rowCount(PDO::FETCH_INTO);
				break;
			case 'LAZY':
			case 'FETCH_LAZY':
				$this->_conn_handler->rowCount(PDO::FETCH_LAZY);
				break;
			case 'BOTH':
			case 'FETCH_BOTH':
				$this->_conn_handler->rowCount(PDO::FETCH_BOTH);
				break;
			case 'NUM':
			case 'FETCH_NUM':
				$this->_conn_handler->rowCount(PDO::FETCH_NUM);
				break;
			case 'OBJ':
			case 'FETCH_OBJ':
				$this->_conn_handler->rowCount(PDO::FETCH_OBJ);
				break;
			default:
				break;
		}

		return $this;
	}

	/**
	 * Set database driver
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function setDriver($value) {
		$this->driver = strtolower($value);
		return $this;
	}

	/**
	 * Set database host
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function setHost($value) {
		$this->host = strtolower($value);
		return $this;
	}

	/**
	 * Set database password
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function setPassword($value) {
		$this->password = strtolower($value);
		return $this;
	}

	/**
	 * Set database username
	 * 
	 * @param string $value: value to set to desired variable
	 * @return Object $this Suport for method chaining
	 */
	public function setUsername($value) {
		$this->username = strtolower($value);
		return $this;
	}

}
