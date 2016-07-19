<?php

$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','style.css','bootstrapValidator.min.css');

/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';
/*
* Load the calendar for January
*/

$category = new ClassifiedCategory($dbo);
/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';


if(!isset($_SESSION['user'])){
	$_SESSION['user']=NULL;
}


?>





<div class="container background-white rounded-corner border-bottom">
	<div class="row">
		<div class="col-md-12">
			
			
			<?php
			 	echo $category->displayForm($_SESSION['user']['email'], $_SESSION['user']['mobile']); 
				
			?>

		</div>
	</div>
</div>

<?php
/* 
 * Output the footer HTML
 */
include_once'assets/common/footer.inc.php';

?>