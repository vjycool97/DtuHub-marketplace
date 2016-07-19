<?php
/*
 * Include necessary files
 */
include_once'sys/core/init.inc.php';
/*
 * Output the header 
 */
$css_files = array('bootstrap.css','font-awesome.min.css','style.css');
if(isset($_GET['id']))
{
	$id=$_GET['id'];
}	
include_once 'assets/common/header.inc.php';

?>

<div class="container-fluid padding-bottom-15 margin-bottom-90">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 box-shadow background-white">

			
			
				<?php echo $category->displayLoginForm(); ?>
			</div>
		</div>
			
	
</div>



<?php

/* 
 * Output the footer HTML
 */

include_once'assets/common/footer.inc.php';

?>