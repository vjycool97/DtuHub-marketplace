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
   


<div class="container-fluid">
	<div class="row rounded-corner registerForm">
		<div class="col-md-4 col-md-offset-4 background-white border-top">
			
					<?php echo $category->displayRegisterForm(); ?>
				</div>
			</div>
		
</div>


<?php

/* 
 * Output the footer HTML
 */

include_once'assets/common/footer.inc.php';

?>