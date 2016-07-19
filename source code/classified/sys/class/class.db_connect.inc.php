<?php 

/** 
 * Database actions (DB access, validation, etc.)
 *
 * PHP version 5
 * LICENSE: This source file is subject to the MIT license, available
 * at http://www.opensource.org/license/mit-license.html
 * 
 * @author		Shekhar <shekhardtu@gmail.com>
 * @copyright	2014 prepmade pvt. ltd. 
 * @license		http://www.opensource.org/license/mit-license.html
 */
 
 class DB_Connect
 {
 /** 
  * Stores a database object
  *
  *@var object A database Object
  */
  
  protected $db;
  
  /**
	* Checks for a DB object or creates one if one isn't found
	* @param object $dbo A database object
	*/
	
	protected function __construct($dbo=NULL,$db=NULL)
	{
		if( is_object($db) )
		{	
			$this->db = $db;
		}
		else
		{
			//Constats are defined in /sys/config/db-cted.inc.php
			$dsn= "mysql:host=".DB_HOST. "; dbname=".DB_NAME;
			try
			{
				$this->db= new PDO($dsn, DB_USER, DB_PASS);
				
			}
			catch(Exception $e)
			
			{
				//If the DB connection fails, output the error
				die($e->getMessage());
				
			}
		}
	}
 
 }