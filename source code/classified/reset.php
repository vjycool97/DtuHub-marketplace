<?php

/*
 * Include necessary files
 */
include_once'sys/core/init.inc.php';
$user = new Admin($dbo);

/*
 * Output the header 
 */
$page_title="Please log in";
$css_files = array('bootstrap.css','font-awesome.min.css','style.css');
if(isset($_GET['id']))
{
	$id=$_GET['id'];
}	
include_once 'assets/common/header.inc.php';

?>

<div class="container-fluid margin-bottom-90">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 background-white border rounded-corner margin-top-40 border-bottom-3">
		<?php echo $user->resetHtml(); ?>
		</div>
	</div>
</div>


<?php

/* 
 * Output the footer HTML
 */

include_once'assets/common/footer.inc.php';

?>

