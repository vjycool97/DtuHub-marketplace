<?php

$page_title = "DTUhub- Student to Student Marketplace";
$css_files = array('bootstrap.min.css','font-awesome.min.css','style.css');

/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';

/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';

?>




<div class="container no-border-bottom background-white padding-bottom-15">
	<div class="row ">
		<div class="col-md-8 col-md-12 col-sm-12 background-background">
			
	    	<div class="row">

				<div class="col-md-12 col-xs-12 col-md-12 background-white padding-bottom-15 box-shadow">
			       <div class="row border-bottom margin-bottom-10 padding-top-10">
			       		<div class="col-md-5">
			       			<h2 class="padding-0 heading-padding" style="font-weight:100;">Select Category</h2>
			       		</div>
			       		<div class="col-md-6 text-right">
			       			<div class="row padding-0 heading-padding margin-top-10">
			       				<div class="col-md-4 col-md-offset-2 text-right">
					       			<small>Filtered by?</small>
					       		</div>
					       		<div class="col-md-6 text-right">

					       					
					       				<?php 
					       				if(!empty($_SESSION['guest']['collegeId']))
					       				{
					       					echo '<form role="form" method="POST" action="assets/inc/process.inc.php"> 
					       					<div class="input-group">
					       					<input type="text" class="form-control input-sm" style="width:200px;height:22px;"
					       					 value="'. $_SESSION['guest']['collegeName'] .'" disabled>
					       								
					       									
					       									 <input type="hidden" name="token" value="'.$_SESSION['token'].'" />
															<input type="hidden" name="action" value="unsetCollegeName" />
															
													      <span class="input-group-btn">
													        <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-times"></i></a></button>
													      </span> 
													      </div>
													      </form>';
					       				}
					       				else
					       				{
							       			echo'<form role="form" action="assets/inc/process.inc.php" method="POST">
													    <div class="input-group">
													    <div id="remote">
													      	<input type="text" name="collegeName" placeholder="Enter your college name"
													      	  data-provide="typeahead" class="collegeName form-control input-sm"
													      	   autocomplete="off" autofocus style="width:200px;height:22px;top:2px"/>
													    </div>
													      	<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
															<input type="hidden" name="action" value="setCollegeName" />
															
													      <span class="input-group-btn">
													        <button class="btn btn-default btn-xs" type="submit"><i class="glyphicon glyphicon-ok"></i></button>
													      </span>
													    </div><!-- /input-group -->
												    	
												</form>';
					       				}

					       				?>
					       			
										 
										
									
					       		</div>
					       	</div>
			       		</div>
			  	 	</div>
			        <?php
						echo $category->createCategoryObject();
					?>
			
	    		</div>
	    	</div>
	    </div>
	    
	    <div class="col-md-4 col-sm-12 background-white">


		    
		    
		    <div class="row border-left-thick border">
			    <div class="col-md-12 col-sm-12 background-white padding-0">
					<div class="widget-area padding-right-10" role="complementary">
						<h3 class="padding-0 margin-left-10 margin-top-15"> Connect with us</h3>
						
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
									<a href="https://plus.google.com/112584436965525027349" rel="publisher" target="_blank">
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

		    <br/>
		    <div class="row border-left-thick border" id="feedback">
			    <div class="col-md-12 col-sm-12 background-white padding-15">

			    	<h3>Your <span style="font-weight:700; color:#54D6FC"> Feedback </span> is important for us. Leave us a message </h3>
			    	<div class="row feedback-form border-top padding-top-15">
			    		<form role="form" action="assets/inc/process.inc.php" method="POST">
				    		<div class="col-md-8 padding-left border-right">
				    			<textarea class="form-control input-sm" name="feedbackMessage" placeholder="Thanks for contributing to DTUhub"></textarea>
				    		</div>
				    		<div class="col-md-4">
				    			<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
								<input type="hidden" name="action" value="sendFeedback" />
									
									<input type="hidden" name="buyerIp" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
									<input type="hidden" name="buyerName" value="anonymous" />
				    			<button class="btn btn-default btn-md" type="submit">Submit</button>
				    		</div>
				    		
							   
							

			    		</form>
			    	</div>
			    </div>
		    </div>

	    </div>
	</div>
</div>

<div class="container-fluid no-border-bottom full-width-blue box-shadow padding-bottom-15 margin-top-15">
	<div class="row">

		<div class="col-md-10 col-md-offset-1">
			<h1> Sell your notes, books, xerox and many more. absolutely free </h1>
		</div>
		
	</div>
</div>


<?php
/* 
 * Output the footer HTML
 */
include_once'assets/common/footer.inc.php';

?>