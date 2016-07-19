<?php
include_once 'sys/core/init.inc.php';
$user = new Admin($dbo);
/* 
 * Output the header HTML
 */
if ( !isset($_SESSION['user']))
{
header("Location: login.php");
exit;
}
$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','style.css');
/*
* Include necessary files
*/
include_once'assets/common/header.inc.php';
?>

<div class="container-fluid margin-bottom-90">
	<div class="row">

		<!-- Left bar[Content] starts from here -->

		<div class="col-md-2 background-background">
			<div class="row margin-bottom-20 background-white rounded-corner padding-15">
				
				<div class="col-md-12">
					<ul>
						<li> <a>Add Institution</a></li>
						<li><a>Add Category</a></li>
					</ul>

				</div>
			
			</div>
		</div>
		<div class="col-md-6 background-background">
			
			<div class="row margin-bottom-20 background-white rounded-corner padding-15">
				
				<div class="col-md-6 border-right">

					<?php echo $category->addInstitutionDisplayForm(); ?>
				</div>
				<div class="col-md-6 border-left">

					
				</div>
				
				


			</div>
			<div class="row margin-bottom-20 background-white rounded-corner padding-15">
				
				<div class="col-md-6 border-right">
					<?php echo $user->loadPostApproval(Null, 'pending'); ?>

					
				</div>
				<div class="col-md-6 border-right">

				</div>
				
				


			</div>

			



			
		</div>
		

		<!-- Side bar starts from here -->

		<div class="col-md-4 background-white rounded-corner">
			<div class="row">
				

			</div>
			<div class="row">
				
				<div class="col-md-12 col-sm-12 background-white padding-0 ">
					<div id="secondary" class="widget-area padding-right-10" role="complementary">
						<p class="text-left "> <h3 class="padding-0 margin-left-10"> Connect with us</h3></p>
						<div class="execphpwidget"><div class="clearfix"></div>

							

							<div class="socialbox">
								<div class="fb-like"> 
									<div class="fb-like" data-href="https://facebook.com/dtuhub"
									 data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
									</div>
										
								</div>	
								<div class="facebook"> 
									<a href="https://www.facebook.com/dtuhub" target="_blank">
										<i class="fa fa-facebook"></i>
									</a>
										
								</div>
								<div class="google">
									<a href="https://plus.google.com/u/0" target="_blank">
										<i class="fa fa-google-plus"></i>
									</a>
										
								</div>

								<div class="twitter">
									<a href="https://twitter.com/dtuhub" target="_blank">
										<i class="fa fa-twitter"></i>
									</a>
										
								</div>
								
								
							</div>
						</div>
					</div>
		    	</div>
			</div>
			<div class="row">

				<div class="col-md-12">
					
					
				</div>
			</div>
		</div>

		
	</div>   
</div>




















<?php
/* 
 * Output the footer HTML
 */
include_once'assets/common/footer.inc.php';

?>
