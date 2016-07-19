<?php session_start();
/*
 * Enable sessions
 */

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

$msg="Some thing went wrong. Please <a href='../../'>click here to go to home Page</a>";



/* 
 * Create a lookup array for form actions
 */

$actions = array(
				'postApprove'=>array(
					'object'=>'Admin',
					'method'=>'processPostApprove',
					'header'=>'Location:../../dh_admin.php'),
				'postDisapprove'=>array(
					'object'=>'Admin',
					'method'=>'processPostDisapprove',
					'header'=>'Location:../../dh_admin.php'),
				'msgForPost'=>array(
					'object'=>'Admin',
					'method'=>'processMsgForPost',
					'header'=>'Location:../../dh_admin.php'),
				'user_register'=>array(
					'object'=>'Admin',
					'method'=>'processRegisterForm',
					'header'=>'Location: ../../login.php'),
				'user_login'=>array(
					'object'=>'Admin',
					'method'=>'processLoginForm',
					'header'=>'Location: ../../profile.php'),
				'user_logout'=>array(
					'object'=>'Admin',
					'method'=>'processLogout',
					'header'=>'Location: ../../login.php'),
				'message_to_seller'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processMessageToSeller',
					'header'=>'Location: ../../profile.php'),
				'reset_password'=>array(
					'object'=>'Admin',
					'method'=>'resetPassword',
					'header'=>'Location: ../../login.php'),
				'new_password'=>array(
					'object'=>'Admin',
					'method'=>'newPassword',
					'header'=>'Location: ../../login.php'),
				'setCollegeName'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'setCollegeName',
					'header'=>'Location: ../../index.php'),
				'unsetCollegeName'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'setCollegeName',
					'header'=>'Location: ../../index.php'),
				'add_institution'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processInstitution',
					'header'=>'Location: ../../dh-admin.php'),
				'post_edit'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processForm',
					'header'=>'Location:'.$_SESSION["guest"]["url"]),
					
				'sendFeedback'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processFeedback',
					'header'=>'Location:../../login.php'),
				);

/*
 * Make sure the ani- CSRF token was passed and that the 
 * requested action exists in the lookup array
 * 
 */
$dsn = "mysql:host=".DB_HOST. "; dbname=". DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);


if($_POST['token']==$_SESSION['token']
	&& isset($actions[$_POST['action']]))
{
	$use_array = $actions[$_POST['action']];

	/* 
	 * Creating new object of main class
	 */
	$obj= new $use_array['object']($dbo);
	if(TRUE===$msg=$obj->$use_array['method']())
	{	
		header($use_array['header']);
		exit;

	}
	else
	{
		// If an error occured, output it and end execution
		die($msg);
	}
}
else
{
	// Redirect to the main index if the token/ action is invalid
	die($msg);
	header("Location: ../../");
	exit;
}

function __autoload($class)
{
	$filename="../../sys/class/class.".strtolower($class).".inc.php";
	if(file_exists($filename))
	{
		require_once $filename;
	}
}