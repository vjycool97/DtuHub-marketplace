<?php

$page_title = "Kindly Choose the category for post";
$css_files = array('bootstrap.css','font-awesome.min.css','slippry.css','style.css');
/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';
/*
* Load the calendar for January
*/
include_once'assets/common/header.inc.php';
$results=$category->getPrice($id);
$seller= $category->getSellerInfo($results[0]["post_author"]);

/* 
 * Output the session time for edit an ad
 */
 if(isset($_SESSION['guest']['edit'])){
$session_duration=(time()-$_SESSION['guest']['edit'])/60 ;

if($session_duration >= 5){ 
    unset($_SESSION['guest']);
	header('Location:index.php');
    }
 }
?>

<div class="container margin-top-40">
	<div class="row background-green padding-bottom-15 margin-bottom-20">
		
		<div class="col-md-1 text-center">
			<br />
			 <h1> <span class="glyphicon glyphicon-ok-sign"></span> </h1>
			
		</div>
		<div class="col-md-11">
			 <h1> Congratulation! Your ad has been submitted. It will be displayed on DTUhub within 4 to 8 hours. </h1>
			 <p> Our team will review your ad and send you an email notification as soon as it will be activated. Till than you make it better or post more and more ads. </p>
				<a href="index.php" class="btn-yellow btn-3a btn-normal"><span class="glyphicon glyphicon-home"> </span> Great! Let me go to home</a> 
				<a href="posting.php" class="btn-blue btn-3a"><span class="glyphicon glyphicon-plus"> </span>  Let's post one more ad</a>

				
		</div>

	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-8 background-background">
			<?php
				echo $category->createPostObject($id,NULL,8);
			?>
		</div>
		
		<div class="col-md-4 background-white rounded-corner">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 margin-top-15">
							Mark as
						</div>
					</div>
					<div class="btn-group btn-group-justified" data-toggle="buttons">
			          
			          <label class="btn btn-default">
			            <input type="radio" name="options" id="option2"> Spam
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options" id="option2"> Duplicate
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options" id="option2"> Offensive
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options" id="option2"> Expired
			          </label>
         			 </div>
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-12">
					<div class="contact-form rounded-corner">
						<div class="row">
							<div class="col-md-12 text-center padding-0">
								<h2 class="padding-0 line-height"> <i class="fa fa-inr"></i> <?php echo $results[0]['price']; ?>/- </h2>
								<span class="less-visible line-height">(<?php echo $results[0]['price_type']; ?>)</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">

				<div class="col-md-12">
					<div class="contact-form rounded-corner">
						<div class="row">
							<div class="col-md-12 text-center">
								<h2 class="padding-0 margin-bottom-10"> <span class="glyphicon glyphicon-user"> </span>
									<?php echo $seller[0]['user_login']; ?> <br />Call on<br /><i class="glyphicon glyphicon-phone"></i>
									 <?php echo $seller[0]['user_mobile']; ?> <br /> or</h2>
								 <div class="form-group">
						       	<a class="btn btn-info btn-lg btn-block messageToSeller" ><i class="fa fa-mail-reply"></i>  Send a message</a>
						       <?php   ?>
						    </div>
							</div>
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