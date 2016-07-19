<?php session_start();
/*
* Enable sessions
*/
/*
* Generate an anti-CSRF token if one doesn't exist
*/
if ( !isset($_SESSION['token']) )
{
$_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}
/*
 * Include the necessary configuration info
 */
include_once 'sys/config/db-cred.inc.php';

/*
 * Define constants for configuration info
 */
 
foreach( $C as $name => $val )
{
	define($name, $val);
}

/*
 * Create a PDO object
 */
 
$dsn = "mysql:host=".DB_HOST. "; dbname=". DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);
 
 /*
  * Define the auto-load function for classes
  */
function __autoload($class)
{
	$filename="sys/class/class.".strtolower($class).".inc.php";
	if(file_exists($filename))
	{
		include_once $filename;
	}
}
/* Load the get value of a page
 * 
 */
 /* Extra code needed for every page */

if(isset($_GET['id']))
{
  $id=$_GET['id'];
}
else{
	$id=NULL;
}

if(isset($_GET['college']))
{
 	$collegeSlug=$_GET['college'];
 	unset($_SESSION['guest']);
}
else{
	$collegeSlug=NULL;
}


$category = new ClassifiedCategory($dbo);