<?php

$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','jquery-ui.css','style.css');

/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';
/*
* Load the calendar for January
*/

/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';

?>


 
<div class="container no-border-bottom background-white padding-top-15 rounded-corner">
<div class="row">

	<!-- side bar  -->
	<div class="col-md-3">
		<div class="row">
			<div class="col-md-12 text-left">
			




			</div>
		</div>
		

	</div>

	<!-- right hand results -->
	<div class="col-md-9">
		
		<?php
      
		  echo $category->siteSearch(null, 'publish',null, 1);

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
