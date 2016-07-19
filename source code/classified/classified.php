<?php
$css_files = array('bootstrap.css','font-awesome.min.css','slippry.css','style.css');
/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';

$category = new ClassifiedCategory($dbo);
$rawData= $category->_loadPostData($id,'publish');

$page_description=$rawData[0]['post_content'];
/*
* Load the calendar for January
*/
include_once'assets/common/header.inc.php';
$results=$category->getPrice($id);
$seller= $category->getSellerInfo($results[0]["post_author"]);



/* 
 * Output the header HTML
 */


?>



<div class="container">
	<div class="row">
		<div class="col-md-8 background-background">
			<?php
                echo $category->createPostObject($id,'publish', 8);
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
			            <input type="radio" name="options"> Spam
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options"> Duplicate
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options"> Offensive
			          </label>
			          <label class="btn btn-default">
			            <input type="radio" name="options"> Expired
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