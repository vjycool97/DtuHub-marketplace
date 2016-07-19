<?php
include_once 'sys/core/init.inc.php';
$user = new Admin($dbo);
if ( !isset($_SESSION['user']) )
{
header('Location: login.php');
exit;
}
$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','style.css');
/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';
/*
* Include necessary files
*/
?>

<div class="container">
	<div class="row">

		<!-- Left bar[Content] starts from here -->

		<div class="col-md-8 background-background">
			
			<div class="row margin-bottom-20 background-white rounded-corner padding-15">
				<div class="col-md-3 col-xs-1 padding-0 text-center">
					<img src="assets\img\no_image.jpg" alt="..." class="img-thumbnail" width="144">
				</div>
				<div class="col-md-8 col-xs-12">
					<?php
						echo $user->userProfileHTML($_SESSION['user']['id']);
					?>
					<div class="row">
					<div class="col-md-6">
							<a class="btn-blue btn-3a btn-block btn-new rounded-corner" > 
							<span class="glyphicon glyphicon-cog"> </span>  Account Settings</a>

					</div>
				</div>
				</div>


			</div>

			<div class="row margin-bottom-20 ">
				<div class="col-md-3 col-md-offset-1">
					<a href="#classifieds" role="tab" data-toggle="tab" class="btn-yellow btn-3a btn-block btn-new" role="button"><span class="glyphicon glyphicon-th-list"> </span>  Classifieds</a>
				</div>
				<div class="col-md-3 col-md-offset-1 text-center">
					<a href="#userMessages" role="tab" data-toggle="tab" class="btn-red btn-3a btn-block btn-new" > <span class="glyphicon glyphicon-envelope"> </span>  Messages</a>
				</div>
				<div class="col-md-3 col-md-offset-1 text-right">
					<a href="posting.php" class="btn-blue btn-3a btn-block btn-new" role="button"> <span class="glyphicon glyphicon-plus"> </span> Post an ad</a>
				</div>
			</div>



			<div class="row margin-bottom-20 background-white ">
				<div class="col-md-12">

				<div class="tab-content" role="tablist">
					<div id="classifieds" class="tab-pane fade in active no-border-bottom ">

						<div class="row margin-bottom-20 margin-top-10">
							<div class="col-md-12">
								<ul class="nav nav-tabs" role="tablist">
									  <li class="active"><a href="#published" role="tab" data-toggle="tab">Active ads</a></li>
									  <li><a href="#pending" role="tab" data-toggle="tab">Pending ads</a></li>
									  <li><a href="#removed" role="tab" data-toggle="tab">Removed ads</a></li>
					  
								</ul>

								<div class="tab-content">
								  	<div class="tab-pane fade in active" id="published">
									  	<?php
												echo $user->loadUserPosts($_SESSION['user']['id'],$post_status="publish");
										?>
									</div>
								  	<div class="tab-pane fade" style="" id="pending"> 
									  	<?php
											echo $user->loadUserPosts($_SESSION['user']['id'], $post_status="pending");
										?>
									</div>
								  	<div class="tab-pane fade" id="removed">
								  		
								  		<?php
											echo $user->loadUserPosts($_SESSION['user']['id'], $post_status="removed");
										?>
									</div> 
									<!--[END] Removed Tab -->
								 	
								</div>

							</div>

							
						</div>
					</div>
					<div id="userMessages" class="tab-pane fade no-border-bottom background-white padding-0">
						<?php echo $user->sellerMessagesHtml(); ?>
					</div>
				</div>
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
					<div class="contact-form rounded-corner">
						<div class="row">
							<?php if($_SESSION['user']['user_status'] == 9)
  								{ ?>
  									<div class="col-md-12">
									    <a href="dh-admin.php" role="tab">
									      <span class="badge pull-right">42 updates</span>
									      Admin Panel
									    </a>
  									</div>
  				<?php }?>
						</div>
						
					</div>
					
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
