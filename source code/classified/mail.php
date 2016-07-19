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

                    $email= new ClassifiedCategory; 
    				$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->Mailer = 'smtp';
					$mail->SMTPAuth = false;
					$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				    $mail->Port = 25;
					//$mail->SMTPSecure = 'ssl';
					// or try these settings (worked on XAMPP and WAMP):
					//$mail->Port = 587;
					//$mail->SMTPSecure = 'tls';


                    $mail->SMTPDebug = 1;
					//$mail->Username = "admin@dtuhub.com";
					//$mail->Password = "Hari@134";

					$mail->IsHTML(true); // if you are going to send HTML formatted emails
					$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

					$mail->From = "admin@dtuhub.com";
					$mail->FromName = "admin";
					//$mail->AddReplyTo("dtuhub@gmail.com","Admin");

					$mail->addAddress('shekhardtu@gmail.com','Dtuhub mail working');


					//$mail->addBCC("shekhardtu@gmail.com","Registration Done!");
					

				
    			$mail->Subject = "Congratulation! we pleased to have you here - DTUhub";
				$mail->Body= $email->emailBody($salutation='Hi '.$userName, $subject='We are pleased to have you here.
				 <br \><a href="http://www.dtuhub.com"> Welcome to DTUhub.com.</a>',  $title=NULL, $welcomeBar='Welcome to DTUHUB',
				  $comment=NULL, $mailContent='Now buying or selling is just few clicks away. Do not wait, post an ad.',
	 $senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$userEmail);
              
					if(!$mail->Send()){
					   echo $mail->ErrorInfo;
					}
                    else
                    {
                        echo " Mail sent sucessfully";
                    }
                   
                        