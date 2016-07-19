<?php 
/*
 * Enable sessions
 */
session_start();
/* 
 * Include the necessary files
 */
require_once'../../sys/config/db-cred.inc.php';
/* 
 * Define constants for config info
 */
foreach( $C as $name => $val)
{
	define($name,$val);

}


$dsn = "mysql:host=".DB_HOST. "; dbname=". DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);



if(isset($_GET['university_name']))
{
	$universityName=$_GET['university_name'];
	$college = new ClassifiedCategory($dbo);
	echo $college->getCollege($universityName);
	exit;
}
elseif(isset($_GET['id']))
{
  	$id=$_GET['id'];
  	$category = new ClassifiedCategory($dbo);
	echo $category->getSubCategory($id);
	exit;
}
elseif(isset($_GET['state_name']))
{
	$stateName=$_GET['state_name'];
	$university = new ClassifiedCategory($dbo);
	echo $university->getUniversity($stateName);
	exit;
}

else
{
  $id=1;
  $stateName='Delhi';

}


function __autoload($class)
{
	$filename="../../sys/class/class.".strtolower($class).".inc.php";
	if(file_exists($filename))
	{
		require_once $filename;
	}
}