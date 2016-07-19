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

$msg="Some thing went wrong. Please <a href='../../'>click here to go to home Page</a>";



/* 
 * Create a lookup array for form actions
 */

$actions = array(
				'view_category'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'createCategoryPostObject'
					),
				'formLogin'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'displayLoginForm'
					),
				'formRegister'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'displayRegisterForm'
					),
				'user_register'=>array(
					'object'=>'Admin',
					'method'=>'processRegisterForm'
					),
				'filterForm'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'createCategoryPostObject'
					),
				'messageForm'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'displayMessageForm'
					),
				'message_to_seller'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processMessageToSeller'
					),
				'feedbackForm'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'displayFeedbackForm'
					),
				'sendFeedback'=>array(
					'object'=>'ClassifiedCategory',
					'method'=>'processFeedback'
					),
				);

/*
 * Make sure the ani- CSRF token was passed and that the 
 * requested action exists in the lookup array
 * 
 */
$dsn = "mysql:host=".DB_HOST. "; dbname=". DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);


if(isset($actions[$_POST['action']]))
{
	$use_array = $actions[$_POST['action']];

	/* 
	 * Creating new object of main class
	 */
	$obj= new $use_array['object']($dbo);

	/* 
	 * Check for an ID and sanitize it if found 
	 */
	

	if(isset($_POST['id']))
	{
		$id=(int)$_POST['id'];

	}
	else
	{
		$id=NULL;
	}





	if(isset($_POST['college']))
	{
		$collegeNameSlug=$_POST['college'];
	}
	else
	{
		$collegeNameSlug=NULL;
	}
	//chaeck for  a sort by post values if it is found

	if(isset($_POST['options']))
	{
		$postOrder=$_POST['options'];
	}
	else
	{
		$postOrder=NULL;
	}


	// check for ad type post value
if(isset($_POST['adType']))
{
	if($_POST['adType']=="all")
	{
		$adType=NULL;
	}
	elseif(isset($_POST['adType']))
	{
		$adType=$_POST['adType'];
	}
}
	else
	{
		$adType=NULL;
	}

	// item selection post value

if(isset($_POST['itemCondition']))
{
	if($_POST['itemCondition']=="all")
	{
		$itemCondition=NULL;
	}
	elseif(isset($_POST['itemCondition']))
	{
		$itemCondition=$_POST['itemCondition'];
	}
}
	else
	{
		$itemCondition=NULL;
	}
	
	echo $obj->$use_array['method']($id, $collegeNameSlug, $post_status='publish',$postOrder, $post_field='classified', $adType, $itemCondition, $imageLimit=1);
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

