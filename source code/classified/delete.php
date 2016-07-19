<?php
include_once 'sys/core/init.inc.php';
$delete=$category->confirmDelete();
$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','style.css');

/*
* Include necessary files
*/


/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';

if(!isset($_SESSION['user'])){
	$_SESSION['user']=NULL;
}

?>


<div class="container rounded-corner border-bottom">
	<div class="row">
		<div class="col-md-12">

			
			<?php
			   echo $delete;
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