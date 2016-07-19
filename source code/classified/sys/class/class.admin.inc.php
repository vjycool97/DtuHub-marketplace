<?php

/* Manages administrative actions
 *
 * PHP version 5
 * 
 * LICENSE: This source file is subjects to the MIT licesnse, available
 * at http://www.opensource.org/licenses/mit-license.html
 * @author 		 Hari Shekhar <shekhardtu@gmail.com>
 * @copyright	 2014 Prepmade
 * @license 	 http://www.opensource.org/licenses/mit-license.html
 */

class Admin extends DB_Connect
{

	/**
	 * Determines the length of the salt to use in hashed passwords
	 * 
	 * @var int the length of the password salt to use
	 */

	private $_saltLength = 7;

	/**
	 * Stores or creates a DB object and sets the salt length
	 * 
	 * @param object $db a database object
	 * @param int $saltLength length for the password hash
	 */

	public function __construct($db=NULL, $saltLength=NULL)
	{
		parent::__construct($db);
		/* 
		 * If an int was passed, set the length of the salt 
		 */
		if(is_int($saltLength))
		{
			$this->_saltLength= $saltLength;
		}
	}


	public function _getSaltedHash($string, $salt=NULL)
	{
		/* 
		 * Genereate a salt if no salt is passed 
		 */
		if($salt==NULL)
		{
			$salt=substr(md5(time()), 0, $this->_saltLength);
		}

		/* 
		 * Extract the salt from the string if one is passed
		 */
		else
		{
			$salt = substr($salt, 0, $this->_saltLength);
		}
		/*
		 * Add the salt to the hash and return it
		 */
		return $salt.sha1($salt.$string);
	}

	

	/** 
	 * Checks login credentials for a valid user
	 * 
	 * @return mixed TRUE on success, message a error 
	 */

	public function processRegisterForm()
	{
		/* 
		 * Fails if the proper action was not submitted 
		 */
		$email= new ClassifiedCategory; 
		
		if($_POST['action']!='user_register')
		{
			return " Invalid action supplied for the processRegisterForm. ";
		}
		
		/*
		 * Escape the user input for security
		 */
		$userName=htmlentities($_POST['fullName'], ENT_QUOTES);
		$userEmail=htmlentities($_POST['email'], ENT_QUOTES);

		$password=$this->_getSaltedHash($_POST['password']);
		$registered_date=date("Y-m-d H:i:s");
		$user_status=2;
		

		try
		{

		
			$userExist=$this->db->prepare("SELECT user_email FROM wp_users WHERE user_email=:userEmail LIMIT 1");
			$userExist->bindParam(':userEmail',$userEmail, PDO::PARAM_STR);
			
			$userExist->execute();
			$ref=$userExist->fetchAll();
			$user=array_shift($ref);
			$userExist->closeCursor();

			if(isset($user))
			{
				return"Your have already registered with $userEmail";
			}
			else
			{
				$stmt= $this->db->prepare("INSERT INTO wp_users(user_login, user_email,user_pass, user_registered, 
					user_status) VALUES(:fullName, :email, :password, :registered_date, :user_status)");
				$stmt->bindParam(":fullName",$userName, PDO::PARAM_STR);
				$stmt->bindParam(":email",$userEmail, PDO::PARAM_STR);
				$stmt->bindParam(":password",$password, PDO::PARAM_STR);
				$stmt->bindParam(":registered_date",$registered_date, PDO::PARAM_STR);
				$stmt->bindParam(":user_status",$user_status, PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();

				$email= new ClassifiedCategory; 
				$mail = new PHPMailer();

                
                
				$mail->IsSMTP();
                $mail->SMTPDebug = 1;
				$mail->SMTPAuth = false;
                //$mail->SMTPSecure = 'ssl';
                $mail->Port = 25;
              	$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				
				
				// or try these settings (worked on XAMPP and WAMP):
				//$mail->Port = 587;
				//$mail->SMTPSecure = 'tls';
                
                $mail->Username = "admin@dtuhub.com";
				//$mail->Password = "Hari@134";


				$mail->IsHTML(true); // if you are going to send HTML formatted emails
				$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$mail->From = "admin@dtuhub.com";
				$mail->FromName = "admin";
				$mail->AddReplyTo("dtuhub@gmail.com","Admin");

				$mail->addAddress($userEmail,$userName);

               
				$mail->addBCC("shekhardtu@gmail.com","Registration Done!");
				
    
				$mail->Subject = "Congratulation! we are pleased to have you - DTUhub";
				$mail->Body= $email->emailBody($salutation='Hi '.$userName, $subject='We are pleased to have you here.
				 <br \><a href="http://www.dtuhub.com"> Welcome to DTUhub.com.</a>',  $title=NULL, $welcomeBar='Welcome to DTUHUB',
				  $comment=NULL, $mailContent='Now buying or selling is just few clicks away. Do not wait, post an ad.',
	 $senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$userEmail);
              
               
				if(!$mail->Send())
				    return $mail->ErrorInfo;
				else
                
				return TRUE;
			}
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

	}
	public function processLoginForm()
	{
		/* 
		 * Fails if the proper action was not submitted 
		 *
		 */
		if($_POST['action']!=='user_login')
		{
			return "Invalid action supplied for processLoginForm.";

		}

		/*
		 * Escapes the user input for security
		 */
		$userEmail= htmlentities($_POST['userEmail'], ENT_QUOTES);
		$userPassword= htmlentities($_POST['userPassword'], ENT_QUOTES);
		


		/* 
		 * Retrieves the matching info from the DB if it exists
		 */
		$sql="SELECT ID, user_pass, user_login, user_email, user_mobile, user_status, post_count FROM wp_users 
		WHERE user_email=:userEmail LIMIT 1";
		
		try
		{	$user=NULL;
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(':userEmail',$userEmail, PDO::PARAM_STR);
			$stmt->execute();
			$ref=$stmt->fetchAll();
			$user=array_shift($ref);
			$stmt->closeCursor();



		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

		/* 
		 * Fails if username doesn't match a DB entry
		 */
		if(!isset($user))
		{
			return " Your email id  or password is invalid. ";

		}

		/*
		 * Get the hash of the user-supplied password
		 */
		$hash = $this->_getSaltedHash($userPassword, $user['user_pass']);
		if($user['user_pass']==$hash)
		{
			/*
			 * Stores the user info in the session as an array 
			 */

			$_SESSION['user'] = array(
			'id' => $user['ID'],
			'user_login' => $user['user_login'],
			'email' => $user['user_email'],
			'mobile' => $user['user_mobile'],
			'post_count' =>$user['post_count'],
			'user_status' =>$user['user_status']
			);
			return TRUE;
		}
		else
		{
			return "Your username or password is invalid.";
			
		}
	}

	/**
	 * Logs out the user
	 * @return mixed TRUE on sucess or message on failure
	 */
	public function processLogout()
	{
		/* 
		 * Fails if the proper action was not submitted 
		 */
		if($_POST['action']!='user_logout')
		{
			return"Invalid action supplied for processLogout";
		}
		/*
		 * Removes the user array from the current session 
		 */
		
		session_destroy();
		return TRUE;
	}

	/**
	 * Generates a salted hash of a supplied string 
	 * 
	 * @param string $string to be hashed 
	 * @param string $salt extract the hash from here 
	 * @return string the salted hash
	 */

	
	private function _loadUserPosts($userId, $postStatus){


		$sql= "SELECT * FROM wp_posts WHERE post_author = '$userId' ";

		 if(isset($postStatus))
		 {
		 	$sql.= "AND post_status='$postStatus' ";
		 }

		try{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$stmt->closeCursor();
			}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	public function loadUserPosts($userId, $postStatus)
	{

		$arr= $this->_loadUserPosts($userId, $postStatus);
		$getHtml=NULL;
		$i=NULL;
		foreach($arr as $post)
		{ 
			
		$results = new Post($post);
		$i=$i+1;
			$getHtml.='

			<div class="row border">
				<div class="col-md-2">
				'.$i.'
				</div>
				<div class="col-md-10">
					<div class="row">

			  			<div class="col-md-8">
			  				<div class="row">
			  					
			  					<div class="col-md-12">
			  						<div class="row">
			  							<div class="col-md-12">
			  								<h5>
			  								<a href="classified.php?id='.$results->post_id.'">'.$results->post_title.'</a></h5>
			  							</div>
			  						</div>
			  						<div class="row">
			  							<div class="col-md-5">
			  								<small>'.$results->post_date.'</small>
			  							</div>
			  							<div class="col-md-3">
			  								
			  							</div>
			  							<div class="col-md-4">
			  								<i class="fa fa-inr"></i>  '.$results->price.'
			  							</div>
			  						</div>

			  					</div>
			  					
			  				</div>
			  			</div>
			  			<div class="col-md-1 col-md-offset-2">
								
								<form action="posting.php" method="POST" role="form">
					  				<button type="submit" name="post_edit" class="btn btn-default btn-info btn-xs 
					  				margin-top-10"> <span class="glyphicon glyphicon-pencil"></span></button>
					  				<input type="hidden" name="post_id" value="'.$results->post_id.'" />
					  				<input type="hidden" name="post_status" value="'.$postStatus.'" />
					  			</form>
					  				

			  					<form action="delete.php" method="POST" role="form">
			  						<button type="submit" class="btn btn-default btn-danger btn-xs margin-top-10" 
			  						name="delete_post"> <span class="glyphicon glyphicon-remove"></span></button>
			  						<input type="hidden" name="post_id" value="'.$results->post_id.'" />
			  						<input type="hidden" name="post_status" value="'.$postStatus.'" />
			  					</form>
			  			</div>
			  		</div>
			  	</div>	
			</div>
			';
		
			

		}
		return $getHtml;
	}


	private function _loadUserProfile($user_id)
	{

		$sql="SELECT * FROM  wp_users WHERE ID=$user_id";

		try{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	public function userProfileHTML($user_id)
	{

		$arr= $this->_loadUserProfile($user_id);
		$A = new ClassifiedCategory;
		foreach($arr as $post)
		{ 

		$results = new Profile($post);
		$getHtml=NULL;
		$getHtml='	<div class="col-md-12 col-xs-12">
							<div class="row">
								<div class="col-md-12">
									<h2>'.$results->fullName.'</h2>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6 col-xs-5">
									<i class="fa fa-phone"> </i> +91 - '.$results->userMobile.'
								</div>
								<div class="col-md-6 col-xs-7" >
									<i class="fa fa-envelope"> </i> '.$results->userEmail.'
									
								</div>
							</div>
					</div>';

					}

		return $getHtml;
	}

	public function _getSellerMessages()
	{
		if(!isset($_SESSION['user']))
		{
			header("Location: index.php");
			return NULL;
		}
		$sellerID=$_SESSION['user']['id'];
		try
		{
			$stmt=$this->db->prepare("SELECT * FROM wp_comments WHERE seller_ID='$sellerID'");
			$stmt->execute();
			$results= $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

		return $results;
	}

	/* Generate the code for messages section of each login user
	 * There will be tabs with format i.e. FROM:EMAIL ID  and 
	 * then corresponding message and reply option to buyer
	 *
	 * @return array $results
	 */

	public function sellerMessagesHtml()
	{

		$A= new ClassifiedCategory;

		$arr=$this->_getSellerMessages();


			$html='
			<div class="row margin-bottom-20">
				<div class="col-md-4 padding-0">

					<ul class="nav nav-pills messageList nav-stacked margin-bottom-0 border-right" role="tablist">';
						foreach($arr as $data)
						{
	
						if(is_null($arr))
						{
							$html.= "<li>There is no message for you</li>";
						}
							$comment= new Comment($data);
			
								
								
						
						  $html.= '<li class="border-radius-0 padding-15 border-bottom">
						  				<div class="row">

						  					<div class="col-md-12 ">
						  						<div class="row">
						  							<div class="col-md-12">
								  						<small><a href="#commentId'.$comment->commentId.'" class="border-radius-0" 
								  						role="tab" data-toggle="tab">Sender: '.strtolower($comment->commentAuthorEmail).'</a></small>
						  							</div>
						  						</div>
						  					

						  				
						  				<div class="row"> 
						  					<div class="col-md-9">
						  						<small><span class="glyphicon glyphicon-time"></span> ';
						  						
						  						$html.= $A->timeStamp($comment->commentDate);
						  						$html.='</small>
						  					</div>


						  					<div class="col-md-1">
						  						
									  				<a href="#commentId'.$comment->commentId.'" data-toggle="tab" 
									  				class="btn btn-default btn-info btn-xs margin-top-10"> 
									  				 <span class="glyphicon glyphicon-pencil"></span>
									  				 </a>
									  				
									  				
					  							
					  						</div>
					  						<div class="col-md-1">
							  					<form action="delete.php" method="POST" role="form">
							  						<button type="submit" class="btn btn-default btn-danger btn-xs margin-top-10" name="delete_message"> 
							  						<span class="glyphicon glyphicon-remove"></span></button>
							  						<input type="hidden" name="comment_id" value="'.$comment->commentId.'" />
												</form>
											</div>
											
						  				</div>
						  				</div>
						  				</div>
						  			</li>';
						  
						  }
		  					 

					$html.='</ul>
				</div>
				<div class="col-md-8">


					<div class="tab-content">';


					foreach($arr as $data)
						{


							$comment= new Comment($data);
			


					  	$html.= '<div class="tab-pane fade" id="commentId'.$comment->commentId.'">
					  			<div class="row border-bottom messagesHeader">
					  				<div class="col-md-12 margin-top-10 margin-bottom-10">
						  			<div class="row">
						  				<div class="col-md-12">';
						  				


						  				$postResult= $A->_loadPostData($comment->commentPostId, NULL);
						  				$html.='<h5 class="padding-0"><a href="classified.php?id='.$comment->commentPostId.'">'.$postResult[0]['post_title'].'</a></h5>';
						  				$html.='</div>


						  			</div>
						  			

						  			<div class="row"> 
							  			<div class="col-md-7">
							  			<a href="mailto:'.$comment->commentAuthorEmail.'"><span class="glyphicon glyphicon-envelope"></span> 
							  			'.$comment->commentAuthorEmail.'</a>
							  			</div>
							  			<div class="col-md-5">
							  			<span class="glyphicon glyphicon-earphone"></span> '.$comment->commentAuthorContact.'
							  			</div>
						  			</div>
						  			</div>
						  			</div>
						  	
						  			<div class="row margin-top-10"> 
							  			<div class="col-md-12">
							  			<p> '.$comment->commentContent .'</p>
							  			</div>							  			
						  			</div>

						  			<div class="row"> 
							  			<div class="col-md-offset-6 col-md-6">
							  			<a href="mailto:'.$comment->commentAuthorEmail.'" class="btn-red btn-3a btn-block btn-new" >Reply</a>
							  			</div>							  			
						  			</div>
						  	


						  	</div>';
						  
						  }
					
					$html.= '</div>
				</div>
			</div>';
		

			return $html;
	}

	public function resetHtml()
	{

		try{

			if(isset($_GET['id']) && isset($_GET['token']))
			{
				$id=htmlentities($_GET['id'], ENT_QUOTES);
				$token=htmlentities($_GET['token'], ENT_QUOTES);

				$html='<div class="row">
						<div class="col-md-12">
							<div class="page-header">
							 	<h3> Forgotten your password? </h3>
							 	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 border-bottom">
							<form role="form" action="assets/inc/process.inc.php" method="post">
						  		<div class="form-group">
							    	<label for="userEmail">Enter new password</label>
							    	<input type="password" class="form-control" id="userEmail" name="userPass" placeholder="...">
							  	</div>
								<div class="form-group">
							    	<label for="confirmPassword">Retype password</label>
							    	<input type="password" class="form-control" id="userEmail" name="retypeUserPass" placeholder="...">
							  	</div>
									
									
								<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
								 
								<input type="hidden" name="user_id" value="'.$id.'" />
								
								<input type="hidden" name="reset_token" value="'.$token.'"/>
								<input type="hidden" name="action" value="new_password" />
								<div class="row">
									<div class="col-md-6 col-md-offset-6">
						  				<button type="submit" class="btn btn-default btn-block">Sign in</button>
							  				or <a href="login.php"> login</a>
						  			</div>
						  		</div>
							</form>
						</div>
					</div>';
			}
			else
			{
			$html='<div class="row">
						<div class="col-md-12">
							<div class="page-header">
							 	<h3> Forgotten your password? </h3>
							 	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 border-bottom">
							<form role="form" class="forgotPassword" action="assets/inc/process.inc.php" method="post">
						  		<div class="form-group">
							    	<label for="userEmail">Email address</label>
							    	<input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter your email">
							  	</div>
									
									
									
								<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
								<input type="hidden" name="action" value="reset_password" />
								<div class="row">
									<div class="col-md-6 col-md-offset-6">
						  				<button type="submit" name="reset_submit" class="btn btn-default btn-block">Sign in</button>
							  				or <a href="login.php"> login</a>
						  			</div>
						  		</div>
							</form>
						</div>
					</div>';
					}
				}
				catch(Exception $e)
				{
					die($e->getMessage());
				}
			

		return $html;

	}

	public function resetPassword()
	{
		if($_POST['action']!=="reset_password" OR $_POST['userEmail']=="")
		{
			return "Invalid action supplied for resetPassword";
		}
		$userEmail= htmlentities($_POST['userEmail'], ENT_QUOTES);
		
		try
		{
			$stmt= $this->db->prepare("SELECT ID, user_login, user_email, user_pass FROM wp_users WHERE user_email=:userEmail");
			$stmt->bindParam(':userEmail',$userEmail, PDO::PARAM_STR);
			$stmt->execute();
			$arr=$stmt->fetchAll();
			$user=array_shift($arr);
			$stmt->closeCursor();

			if($user)
			{	
				$token=md5(uniqid(mt_rand(), TRUE));

				$updateToken= $this->db->prepare(
					"UPDATE wp_users 
					SET 
					user_activation_key= :token
					WHERE ID=:userId");
				$updateToken->bindParam(':token', $token, PDO::PARAM_STR);
				$updateToken->bindParam(':userId', $user['ID'], PDO::PARAM_STR);
				$updateToken->execute();
				$updateToken->closeCursor();

				// To generate 
				if(isset($_SERVER['HTTPS'])){
				        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
				    }
				    else{
				        $protocol = 'http';
				    }
				    $baseUrl= $protocol . "://" . $_SERVER['HTTP_HOST'];

				$resetLink= $baseUrl.'/reset.php?id='.$user["ID"].'&token='.$token;
								
				$email= new ClassifiedCategory; 
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Mailer = 'smtp';
				$mail->SMTPAuth = false;
				$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				$mail->Port = 25;
				//$mail->SMTPSecure = 'ssl';
				// or try these settings (worked on XAMPP and WAMP):
				// $mail->Port = 587;
				// $mail->SMTPSecure = 'tls';


				//$mail->Username = "shekhardtu@gmail.com";
				//$mail->Password = "Hari--@134";

				$mail->IsHTML(true); // if you are going to send HTML formatted emails
				$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$mail->From = "admin@dtuhub.com";
				$mail->FromName = "admin";
				$mail->AddReplyTo("dtuhub@gmail.com","Admin");

				$mail->addAddress($user['user_email'],$user['user_login']);


				$mail->addBCC("shekhardtu@gmail.com","Some one forgot their password");
				

				$mail->Subject = "DTUhub | Password reset instructions";
				$mail->Body= $email->emailBody($salutation='Hi '.$user["user_login"], $subject='Forgot your password?', 
				 $title="We have recieved a Password reset request for your account at DTUhub.com.
				 If you want to reset the password, use the link below", $welcomeBar=NULL,
				  $comment=$resetLink, $mailContent="If you weren't expecting this mail, kindly ignore it. The link will automatically expire in 1 day.",
	 				$senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$user["user_email"]);

				if(!$mail->Send())
				    $msg= $mail->ErrorInfo;
				else

				return TRUE;

			}
		}

		catch( Exception $e)
		{
			die($e->getMessage());
		}
		

	}
	

	public function newPassword()
	{
		if($_POST['action']!=="new_password")
		{
			return "Invalid action supplied for newPassword";
		}
		elseif(isset($_POST['action']) && ($_POST['token'] == $_SESSION['token']))
		
		{
			
			$resetToken= htmlentities($_POST['reset_token'], ENT_QUOTES);
			$userId= htmlentities($_POST['user_id'], ENT_QUOTES);
			//$userPass=htmlentities($_POST['userPass'], ENT_QUOTES);
			$sessionToken=$_SESSION['token'];
		
		    $userPass=$this->_getSaltedHash($_POST['userPass']);
			try
			{
				

					$updateToken= $this->db->prepare(
						"UPDATE wp_users 
						SET 
						user_activation_key=:sessionToken,
						user_pass=:userPass
						WHERE ID=:userId AND user_activation_key=:resetToken");

					$updateToken->bindParam(':userPass', $userPass, PDO::PARAM_STR);
					$updateToken->bindParam(':userId', $userId, PDO::PARAM_STR);
					$updateToken->bindParam(':resetToken', $resetToken, PDO::PARAM_STR);
					$updateToken->bindParam(':sessionToken', $sessionToken, PDO::PARAM_STR);
					
					$updateToken->execute();
					$updateToken->closeCursor();

					
					
									
					$email= new ClassifiedCategory; 
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->Mailer = 'smtp';
					$mail->SMTPAuth = false;
					$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
					$mail->Port = 25;
					//$mail->SMTPSecure = 'ssl';
					// or try these settings (worked on XAMPP and WAMP):
					// $mail->Port = 587;
					// $mail->SMTPSecure = 'tls';



					//$mail->Username = "shekhardtu@gmail.com";
					//$mail->Password = "Hari--@134";

					$mail->IsHTML(true); // if you are going to send HTML formatted emails
					$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

					$mail->From = "admin@dtuhub.com";
					$mail->FromName = "admin";
					$mail->AddReplyTo("dtuhub@gmail.com","Admin");

					$mail->addAddress($user[0]['user_email'],$user[0]['user_login']);


					$mail->addBCC("shekhardtu@gmail.com","Password has been changed");
					

					$mail->Subject = "DTUhub | Your password has been changed";
					$mail->Body= $email->emailBody($salutation='Hi Sparky!', $subject=NULL, 
					$title="Your password has been sucessfully changed. If you did not change your password, contact us immediately", $welcomeBar=NULL,
					$comment=$resetLink, $mailContent=NULL,
		 			$senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$user["user_email"]);

					if(!$mail->Send())
					    $msg= $mail->ErrorInfo;
				else

				return TRUE;

			}
		
			catch( Exception $e)
			{
				die($e->getMessage());
			}
			

		}
	}
		


	public function _loadPostApproval($id=NULL, $post_status=NULL)
	{

		
		

		$sql="SELECT ID, post_title, post_excerpt, post_content, post_author, post_date, post_status, price, state_name, college_name
			FROM wp_posts ";
			
			if(!empty($post_status))
			{
				$sql.="WHERE post_status='$post_status' ";
			}

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

			
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		
		return $results;
	}

	public function loadPostApproval($id=NULL, $post_status=NULL)
	{

		$arr= $this->_loadPostApproval($id, $post_status);
		$getHtml=NULL;

		foreach($arr as $data){

			$result = new Post($data);

			$getHtml.='<div class="row">
							<div class="col-md-12">

								<div class="row">
									<div class="col-md-8">
									<a href=posting_preview.php?id='.$result->post_id.'>'.$result->post_title.'</a>';
									

						$getHtml.='</div>

									<div class="col-md-4">
											<div class="row">
								                
                                                        <div class="col-md-1">
                                                            <form role="form" class="postApprove" action="assets/inc/process.inc.php" method="post">
        								                        <button type="submit" class="btn btn-default btn-xs">
                                                                  <span class="glyphicon glyphicon-ok"></span>
                                                                </button>
                                                                <input type="hidden" name="token" value="'.$_SESSION['token'].'" />
                                                                <input type="hidden" name="userId" value="'.$_SESSION['user']['id'].'" />

    							                                <input type="hidden" name="action" value="postApprove" />
                                                                <input type="hidden" name="postId" value="'.$result->post_id.'" />
                                                                <input type="hidden" name="postTitle" value="'.$result->post_title.'" />
                                                                <input type="hidden" name="postAuthor" value="'.$result->post_author.'" />
                                                            </form>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <form role="form" class="postDisapprove" action="assets/inc/process.inc.php" method="post">
            							                        <button type="button" class="btn btn-default btn-xs">
                                                                  <span class="glyphicon glyphicon-trash"></span>
                                                                </button>
                                                                <input type="hidden" name="token" value="'.$_SESSION['token'].'" />
                                                                <input type="hidden" name="userId" value="'.$_SESSION['user']['id'].'" />
    							                                <input type="hidden" name="action" value="postDisapprove" />
                                                                <input type="hidden" name="postId" value="'.$result->post_id.'" />
                                                                <input type="hidden" name="postTitle" value="'.$result->post_title.'" />
                                                                <input type="hidden" name="postAuthor" value="'.$result->post_author.'" />
                                                            </form>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <form role="form" class="msgForPost" action="assets/inc/process.inc.php" method="post">
            							                        <button type="button" class="btn btn-default btn-xs">
                                                                  <span class="glyphicon glyphicon-envelope"></span>
                                                                </button>
                                                                <input type="hidden" name="token" value="'.$_SESSION['token'].'" />
                                                                <input type="hidden" name="userId" value="'.$_SESSION['user']['id'].'" />
    							                                <input type="hidden" name="action" value="msgForPost" />
                                                                <input type="hidden" name="postId" value="'.$result->post_id.'" />
                                                                <input type="hidden" name="postTitle" value="'.$result->post_title.'" />
                                                                <input type="hidden" name="postAuthor" value="'.$result->post_author.'" />
                                                            </form>
                                                        </div>
                                                    </div>

		                  
							             
									</div>
								</div>
							</div>

						</div>';





		}
		return $getHtml;
	}

	public function processPostApprove()
	{


		$postType="publish";
		$postId=$_POST['postId'];
		$userId=$_POST['userId'];
		$postTitle=$_POST['postTitle'];
		$postAuthor=$_POST['postAuthor'];
		$arr= $this->_loadUserProfile($postAuthor);

		try
		{
			$updatePostStatus= $this->db->prepare(
						"UPDATE wp_posts 
						SET 
						post_status=:postType,
						amid=:userId
						WHERE ID=:postId");

					$updatePostStatus->bindParam(':postType', $postType, PDO::PARAM_STR);
					$updatePostStatus->bindParam(':userId', $userId, PDO::PARAM_STR);
					$updatePostStatus->bindParam(':postId', $postId, PDO::PARAM_STR);
					$updatePostStatus->execute();
					$updatePostStatus->closeCursor();

					$updateRelationshipStatus= $this->db->prepare(
						"UPDATE wp_term_relationships 
						SET 
						relationship_status=:postType
						WHERE object_id=:postId");

					$updateRelationshipStatus->bindParam(':postType', $postType, PDO::PARAM_STR);
					$updateRelationshipStatus->bindParam(':postId', $postId, PDO::PARAM_STR);
					$updateRelationshipStatus->execute();
					$updateRelationshipStatus->closeCursor();


					
					$selectTermId=$this->db->prepare("SELECT term_taxonomy_id FROM wp_term_relationships
							WHERE object_id=:id");
					$selectTermId->bindParam(":id", $postId, PDO::PARAM_INT);
					$selectTermId->execute();
					$termId=$selectTermId->fetchAll();
					$selectTermId->closeCursor();

					
					/* 
		             * Update Category count code
					 */
						foreach ($termId as $value)
						{
							# code...
							
								$updateCategoryCount=$this->db->prepare("UPDATE wp_term_taxonomy
									SET 
									count= count+1
									WHERE term_taxonomy_id=".$value[0]);
								
								
								$updateCategoryCount->execute();
								$updateCategoryCount->closeCursor();
						}


				$baseUrl=$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$adLink= '<a href="'.$baseUrl.'/classified.php?id='.$postId.'">'.$postTitle.'</a>';
				$email= new ClassifiedCategory; 
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPDebug = 1;
				$mail->SMTPAuth = false;
                //$mail->SMTPSecure = 'ssl';
                $mail->Port = 25;
              	$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				
				
				// or try these settings (worked on XAMPP and WAMP):
				//$mail->Port = 587;
				//$mail->SMTPSecure = 'tls';
                
                $mail->Username = "admin@dtuhub.com";
				//$mail->Password = "Hari@134";


				$mail->IsHTML(true); // if you are going to send HTML formatted emails
				$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$mail->From = "admin@dtuhub.com";
				$mail->FromName = "admin";
				$mail->AddReplyTo("dtuhub@gmail.com","Admin");

				$mail->addAddress($arr[0]["user_email"],$arr[0]["user_login"]);

               
				$mail->addBCC("shekhardtu@gmail.com","Ad has been live");
				
    
				$mail->Subject = "Congratulation! Your ad in now live on DTUhub";
				$mail->Body= $email->emailBody($salutation='Hi '.$arr[0]["user_login"], $subject='Thank you for using DTUhub',  $title=NULL, 
                $welcomeBar='Your submitted ad has been displayed now.',
                
				$comment=NULL, $mailContent='VIEW YOUR AD:'.$adLink,
	 $senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$arr[0]["user_email"]);
              
				if(!$mail->Send())
				   {
                       $mail->ErrorInfo;
			 
				   }
                   else

					return true;

		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		
	}

	
	


}