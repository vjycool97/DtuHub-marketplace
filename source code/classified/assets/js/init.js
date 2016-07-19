	// Makes sure the document is ready before executing scripts

	jQuery(function($)
	{





				 $.fn.bootstrapValidator.validators.securePassword = {
			        validate: function(validator, $field, options) {
			           var value = $field.val();
			            if (value === '') {
			                return true;
			            }

			            // Check the password strength
			            if (value.length < 6) {
			                return {
			                    valid: false,
			                    message: 'The password must be more than 6 characters long'
			                };
			            }

			          

			            // The password doesn't contain any uppercase character
			            if (value === value.toUpperCase()) {
			                return {
			                    valid: false,
			                    message: 'The password must contain at least one lower case character'
			                }
			            }

			            // The password doesn't contain any digit
			            if (value.search(/[0-9]/) < 0) {
			                return {
			                    valid: false,
			                    message: 'The password must contain at least one digit'
			                }
			            }

			            return true;
			        }
			    };

				$('form.loginForm').bootstrapValidator({
					excluded:[':disabled', ':hidden',':not(:visible)'],
					message:'This value is not valid',
					 feedbackIcons: {
			            valid: 'glyphicon glyphicon-ok',
			            invalid: 'glyphicon glyphicon-remove',
			            validating: 'glyphicon glyphicon-refresh'
			        },
			        fields:{
			        	userEmail:{
			                validators: {
			                    notEmpty: {
			                        message: 'The email is required and cannot be empty'
			                    },
			                    emailAddress: {
			                        message: 'The input is not a valid email address'
			                    }
			                }
			            },

			          	userPassword: {
			                validators: {
			                    notEmpty: {
			                        message: 'The password is required and cannot be empty'
			                    },
			                    different: {
			                        field: 'userEmail',
			                        message: 'The password cannot be the same as email'
			                    },
			                    securePassword: {
			                        message: 'The password is not valid'
			                    }
			                   
			                }
			            },
			        }
				});

				$('form.forgotPassword').bootstrapValidator({
					excluded:[':disabled', ':hidden',':not(:visible)'],
					message:'This value is not valid',
					feedbackIcons:{
                        valid:'glyphicon glyphicon-ok',
                        invalid:'glyphicon glyphicon-remove',
                        validating:'glyphicon glyphicon-refresh'
                        },
                        fields:{
                            userEmail:{
			                validators: {
			                    notEmpty: {
			                        message: 'The email is required and cannot be empty'
			                    },
			                    emailAddress: {
			                        message: 'The input is not a valid email address'
			                    }
			                }
			            },
			        }
				});

				$('form.userRegisterForm').bootstrapValidator({
					excluded:[':disabled', ':hidden',':not(:visible)'],
					message:'This value is not valid',
					 feedbackIcons: {
			            valid: 'glyphicon glyphicon-ok',
			            invalid: 'glyphicon glyphicon-remove',
			            validating: 'glyphicon glyphicon-refresh'
			        },
			        fields:{
			        	fullName:{
			                validators: {
			                    notEmpty: {
			                        message: 'The full name is required and cannot be empty'
			                    },
			                    stringLength: {
			                        min: 6,
			                        max: 30,
			                        message: 'The username must be more than 6 and less than 30 characters long'
			                    },
			                    regexp: {
			                        regexp: /^[a-zA-Z 0-9_]+$/,
			                        message: 'The username can only consist of alphabetical, number and underscore'
			                    }
			                }
			            },

			        	email:{
			                validators: {
			                    notEmpty: {
			                        message: 'The email is required and cannot be empty'
			                    },
			                    emailAddress: {
			                        message: 'The input is not a valid email address'
			                    }
			                }
			            },

			          	password: {
			                validators: {
			                    notEmpty: {
			                        message: 'The password is required and cannot be empty'
			                    },
			                    different: {
			                        field: 'userEmail',
			                        message: 'The password cannot be the same as email'
			                    },
			                    securePassword: {
			                        message: 'The password is not valid'
			                    }
			                   
			                }
			            },
			        }
				});



				




			    $('form.adPostingForm').bootstrapValidator({
			    	excluded: [':disabled', ':hidden', ':not(:visible)'],
			        message: 'This value is not valid',
			        
			        feedbackIcons: {
			            valid: 'glyphicon glyphicon-ok',
			            invalid: 'glyphicon glyphicon-remove',
			            validating: 'glyphicon glyphicon-refresh'
			        },
			        fields:{
				        category: {
					                validators: {
					                    notEmpty: {
					                        message: 'Please select a category'
					                    }
					                }
					        },
					    subCategory: {
					            validators: {
					                notEmpty: {
					                    message: 'Select a subcategory'
					                }
					            }
					    },
			        

			        	adType: {
			                validators: {
			                    notEmpty: {
			                        message: 'The type of ad is required'
			                    }
			                }
			            },
			            itemCondition: {
				                validators: {
				                    notEmpty: {
				                        message: 'The item condition is required'
				                    }
				                }
				        },

			            post_title: {
			                message: 'The post title is not valid',
			                validators: {
			                    notEmpty: {
			                        message: 'The title is required and cannot be empty'
			                    },
			                    stringLength: {
			                        min: 10,
			                        max: 150,
			                        message: 'The title must be more than 10 characters and less than 150 characters long'
			                    },
			                    regexp: {
			                        regexp: /^[a-zA-Z0-9 ',.-]+$/,
			                        message: 'The title can only consist of alphabetical, number, comma and hyphen'
			                    }
			                }
			            },
			            post_description: {
			                message: 'The post description is not valid',
			                validators: {
			                    notEmpty: {
			                        message: 'Write a good, detailed description. A good description sell up to 2 times more '
			                    },
			                    stringLength: {
			                        min: 20,
			                        max: 500,
			                        message: 'The description must be more than 20 characters and less than 500 characters long'
			                    },
			                    regexp: {
			                        regexp: /^[a-zA-Z0-9 -,.-]+$/,
			                        message: 'The description can only consist of alphabetical, number, comma and hyphen'
			                    }
			                }
			            },
			            priceType: {
				                validators: {
				                    notEmpty: {
				                        message: 'The selling price option is required'
				                    }
				                }
				        },

			            sellerEmail: {
			                validators: {
			                    notEmpty: {
			                        message: 'The email is required and cannot be empty'
			                    },
			                    emailAddress: {
			                        message: 'The input is not a valid email address'
			                    }
			                }
			            },
			            sellerName: {
			                message: 'The seller name is not valid',
			                validators: {
			                    notEmpty: {
			                        message: 'The seller name is required and cannot be empty'
			                    },
			                    stringLength: {
			                        min: 4,
			                        max: 80,
			                        message: 'The seller name must be more than 4 and less than 80 characters long'
			                    },
			                    regexp: {
			                        regexp: /^[a-zA-Z0-9 ]+$/,
			                        message: 'The username can only consist of alphabetical and number'
			                    }
			                }
			            },
			            sellerNumber: {
			                validators: {
			                    digits: {
			                        message: 'The phone number can contain digits only'
			                    },
			                    stringLength:{
			                    	min:10,
			                    	max:10,
			                    	message:'The mobile number must be equal to 10 digits long'
			                    },
			                    notEmpty: {
			                        message: 'The phone number is required'
			                    }
			                }
			            },
			            sellerState: {
				                validators: {
				                    notEmpty: {
				                        message: 'Please select the state'
				                    }
				                }
				        },
				        sellerUniversity: {
				                validators: {
				                    notEmpty: {
				                        message: 'Please select your target university'
				                    }
				                }
				        },
				        sellerCollege: {
				                validators: {
				                    notEmpty: {
				                        message: 'Please select you target institute'
				                    }
				                }
				        },

			        }
			    });


			

		// File to which AJAX requests should be sent
		var processFile = "../assets/inc/ajax.inc.php",
		// Functions to manipulate the modal window
		fx = {
					// Checks for a modal window and returns it, or
					// else creates a new one and returns that
					"initModal" : function() 
					{
					// If no elements are matched, the length
					// property will be 0
					if ( $(".modal-window").length==0 )
					{
						// Creates a div, adds a class, and
						// appends it to the body tag
						return $("<div>")
						.hide()
						.addClass("modal-window")
						.appendTo("body");
					}
					else
					{
						// Returns the modal window if one
						// already exists in the DOM
						return $(".modal-window");
					}
				},

				// Adds the window to the markup and fades it in
				"boxin" : function(data, modal) 
				{
						// Creates an overlay for the site, adds
						// a class and a click event handler, then
						// appends it to the body element
						$("<div>")
						.hide()
						.addClass("modal-overlay")
						.click(function(event){
						// Removes event
						fx.boxout(event);
					})
						.appendTo("body");
						// Loads data into the modal window and
						// appends it to the body element
						modal
						.hide()
						.append(data)
						.appendTo("body");
						// Fades in the modal window and overlay
						$(".modal-overlay").fadeIn(200);

						$(".modal-window").slideDown(50);
					},

				// fades out the window and removes it from the DOM
				"boxout" : function(event)
				{
					// if an event was triggered by the element 
					// that called this function, prevents the 
					// default action from firing 
					if( event !=undefined )
					{
						event.preventDefault();
					}
					// Removes the active class from all the links 
					$("a").removeClass("active");
					// Fades out the modal window, then removes 
					// it from DOM entirely 

					$(".modal-overlay").fadeOut(200, function(){
						$(this).remove();

					});
					$(".modal-window").slideUp(200, function(){
						$(this).remove();

					});
				},

				"cancelButton" : function()
				{
						// close button and fade out modal windows and overlays
						$("a:contains(cancel)").click(function(event){
							event.preventDefault();
							fx.boxout(event);
						});
				},


			}


			// displays the edit form as a modal widow
			$("a.login").on('click', function(event)
			{
				// prevent the form from submitting 

				event.preventDefault();


				// Logs a message to prove the handler was triggered
				console.log("Add a new Post button clicked!");

				// Loads the action for the processing file
				var action="formLogin";

				// Loads the editing form and display it
				$.ajax(
				{
					type:"POST",
					url:processFile,
					data:"action="+action,
					success: function(data)
					{
						// Hides the form 
						var form =$(data).hide(), 

						// Makes sure the modal widow exists 
						modal= fx.initModal();

						// Creates a button to close the window
						$("<a>")
						.attr("href", "#")
						.addClass("modal-close-btn")
						.html("&times;")
						.click(function(event)
						{
							// Prevent the default action
							event.preventDefault();
							// Removes modal window
							fx.boxout(event);
						})
						.appendTo(modal);

						// Call the boxin function to create 
						// the modal overlay and fade it in 
						fx.boxin(null, modal);
						// Load the form into the window 
						// fades in the content, and adds 
						// a class to the form
						form.appendTo(modal).addClass("formLogin").fadeIn("slow");

						fx.cancelButton();

					},
					error:function(msg)
					{
						alert(msg);
					}
				});

			});

// Fire an event to load register form in modal-overlay
			$("a.feedBackLink").on('click', function(event)
			{
				event.preventDefault();
				var URL= window.location.pathname;
				var id = URL.substring(URL.lastIndexOf('/') + 1);
				

				var notification= '<div class="container"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div></div></div>';
				var loader= '<div class="col-md-6"><div class="spinner1"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>';
				var msg='Your message has been successfully sent to publisher';


				// Loads the action for the message to seller form
				$.ajax(
				{
					type:"POST",
					url:processFile,
					data:"action=displayFeedbackForm&id="+id,
					success:function(data)
					{
						// Hides the form
						var form=$(data).hide(),
						modal= fx.initModal();
						// Creates a button to close the window
								$("<a>")
								.attr("href", "#")
								.addClass("modal-close-btn")
								.html("&times;")
								.click(function(event)
								{
									// Prevent the default action
									event.preventDefault();
									// Removes modal window
									fx.boxout(event);
								})
								.appendTo(modal);

								// Call the boxin function to create 
								// the modal overlay and fade it in 
								fx.boxin(null, modal);
									// Make the cancel button on editing forms behave like the


								// Load the form into the window 
								// fades in the content, and adds 
								// a class to the form
								form.appendTo(modal).fadeIn("slow");
								$(".modal-window").addClass("formMessage");
								$('form.messageToSeller').bootstrapValidator({
									excluded:[':disabled', ':hidden',':not(:visible)'],
									message:'This value is not valid',
									 feedbackIcons: {
							            valid: 'glyphicon glyphicon-ok',
							            invalid: 'glyphicon glyphicon-remove',
							            validating: 'glyphicon glyphicon-refresh'
							        },
							        fields:{
							        	

							        	buyerEmail:{
							                validators: {
							                    notEmpty: {
							                        message: 'The email is required and cannot be empty'
							                    },
							                    emailAddress: {
							                        message: 'The input is not a valid email address'
							                    }
							                }
							            },
							            buyerNumber:{
							               validators: {
							                    digits: {
							                        message: 'The phone number can contain digits only'
							                    },
							                    stringLength:{
							                    	min:10,
							                    	max:10,
							                    	message:'The mobile number must be equal to 10 digits long'
							                    },
							                    notEmpty: {
							                        message: 'The phone number is required'
							                    }
							                }
							            },

							           buyerMessage: {
							                message: 'The post description is not valid',
							                validators: {
							                    notEmpty: {
							                        message: 'Write a good, detailed description. A good description sell up to 2 times more '
							                    },
							                    stringLength: {
							                        min: 20,
							                        max: 500,
							                        message: 'The description must be more than 20 characters and less than 500 characters long'
							                    },
							                    regexp: {
							                        regexp: /^[a-zA-Z0-9 -,.-]+$/,
							                        message: 'The description can only consist of alphabetical, number, comma and hyphen'
							                    }
							                }
							            },
							        }
								});
								
								// close button and fade out modal windows and overlays
								fx.cancelButton();

								$(".feedback-form button[type=submit]").on('click',function(event)
								{
									event.preventDefault();
										// Log a message to indicate and preventation has worked
									var formData = $(this).parents("form").serialize();
									// Sends the data to the processing file 
									$.ajax({
											type:'POST',
											url:processFile,
											data:"action=sendFeedback&"+formData,
											beforeSend: function(){
						 	
										        // Code to display spinner
										        
										        $(loader).fadeIn('slow').prependTo('.feedback-form button[type=submit]');
										       
										    },
											success: function(data){
												// Fades out the modal window
												fx.boxout();
												// Logs a message to console 
												console.log("Message sent!");
											},
											complete: function(){
										        // Code to hide spinner.
										        $(".alert, .alert-success").remove();
										        $(notification).slideDown('slow').insertAfter(".body-header");
										        $('.alert-success').append(msg);
										       

										    
										    },
											error:function(msg)
											{
												alert(msg);
											}
										});
									});
								},
							error:function(msg)
							{
								alert(msg);
							}
						});

			});


	$(".feedback-form button[type=submit]").on('click',function(event)
								{
									event.preventDefault();
										// Log a message to indicate and preventation has worked
									var formData = $(this).parents("form").serialize();
									var notification= '<div class="container"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div></div></div>';
									var loader= '<div class="col-md-6"><div class="spinner1"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>';
									var msg='Thankyou, Your feedback has been successfully recorded';
									// Sends the data to the processing file 
									console.log(formData);
									$.ajax({
											type:'POST',
											url:processFile,
											data:"action=sendFeedback&"+formData,
											beforeSend: function(){
						 	
										        // Code to display spinner
										        
										        $(loader).fadeIn('slow').prependTo('.feedback-form button[type=submit]');
										       
										    },
											success: function(data){
												// Fades out the modal window
												fx.boxout();
												$("#feedback").hide(600);
												// Logs a message to console 
												console.log("Message sent!");
											},
											complete: function(){
										        // Code to hide spinner.
										        $(".alert, .alert-success").remove();
										        $(notification).slideDown('slow').insertAfter(".body-header");
										        $('.alert-success').append(msg);
										       

										    
										    },
											error:function(msg)
											{
												alert(msg);
											}
										});
									});



			// Fire an event to load register form in modal-overlay
			$("a.messageToSeller").on('click', function(event)
			{
				event.preventDefault();
				var URL= window.location.pathname;
				var id = URL.substring(URL.lastIndexOf('/') + 1);
				

				var notification= '<div class="container"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div></div></div>';
				var loader= '<div class="col-md-6"><div class="spinner1"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>';
				var msg='Your message has been successfully sent to publisher';


				// Loads the action for the message to seller form
				$.ajax(
				{
					type:"POST",
					url:processFile,
					data:"action=messageForm&id="+id,
					success:function(data)
					{
						// Hides the form
						var form=$(data).hide(),
						modal= fx.initModal();
						// Creates a button to close the window
								$("<a>")
								.attr("href", "#")
								.addClass("modal-close-btn")
								.html("&times;")
								.click(function(event)
								{
									// Prevent the default action
									event.preventDefault();
									// Removes modal window
									fx.boxout(event);
								})
								.appendTo(modal);

								// Call the boxin function to create 
								// the modal overlay and fade it in 
								fx.boxin(null, modal);
									// Make the cancel button on editing forms behave like the


								// Load the form into the window 
								// fades in the content, and adds 
								// a class to the form
								form.appendTo(modal).fadeIn("slow");
								$(".modal-window").addClass("formMessage");
								$('form.messageToSeller').bootstrapValidator({
									excluded:[':disabled', ':hidden',':not(:visible)'],
									message:'This value is not valid',
									 feedbackIcons: {
							            valid: 'glyphicon glyphicon-ok',
							            invalid: 'glyphicon glyphicon-remove',
							            validating: 'glyphicon glyphicon-refresh'
							        },
							        fields:{
							        	

							        	buyerEmail:{
							                validators: {
							                    notEmpty: {
							                        message: 'The email is required and cannot be empty'
							                    },
							                    emailAddress: {
							                        message: 'The input is not a valid email address'
							                    }
							                }
							            },
							            buyerNumber:{
							               validators: {
							                    digits: {
							                        message: 'The phone number can contain digits only'
							                    },
							                    stringLength:{
							                    	min:10,
							                    	max:10,
							                    	message:'The mobile number must be equal to 10 digits long'
							                    },
							                    notEmpty: {
							                        message: 'The phone number is required'
							                    }
							                }
							            },

							           buyerMessage: {
							                message: 'The post description is not valid',
							                validators: {
							                    notEmpty: {
							                        message: 'Write a good, detailed description. A good description sell up to 2 times more '
							                    },
							                    stringLength: {
							                        min: 20,
							                        max: 500,
							                        message: 'The description must be more than 20 characters and less than 500 characters long'
							                    },
							                    regexp: {
							                        regexp: /^[a-zA-Z0-9 -,.-]+$/,
							                        message: 'The description can only consist of alphabetical, number, comma and hyphen'
							                    }
							                }
							            },
							        }
								});
								
								// close button and fade out modal windows and overlays
								fx.cancelButton();

								$(".messageToSeller button[type=submit]").on('click',function(event)
								{
									event.preventDefault();
										// Log a message to indicate and preventation has worked
									var formData = $(this).parents("form").serialize();
									// Sends the data to the processing file 
									$.ajax({
											type:'POST',
											url:processFile,
											data:"action=message_to_seller&"+formData,
											beforeSend: function(){
						 	
										        // Code to display spinner
										        
										        $(loader).fadeIn('slow').prependTo('.messageToSeller button[type=submit]');
										       
										    },
											success: function(data){
												// Fades out the modal window
												fx.boxout();
												// Logs a message to console 
												console.log("Message sent!");
											},
											complete: function(){
										        // Code to hide spinner.
										        $(".alert, .alert-success").remove();
										        $(notification).slideDown('slow').insertAfter(".body-header");
										        $('.alert-success').append(msg);
										       

										    
										    },
											error:function(msg)
											{
												alert(msg);
											}
										});
									});
								},
							error:function(msg)
							{
								alert(msg);
							}
						});

			});
			

			$("a.register").on('click', function(event)
			{
						// prevent the form from submitting 

						event.preventDefault();
						// Logs a message to prove the handler was triggered


						// Loads the action for the processing file
						var action="formRegister";
						var notification= '<div class="container"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div></div></div>';
						var loader= '<div class="col-md-6"><div class="spinner1"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>';
						var msg='Well done! You have successfully registered for dtuhub.com. Click here to <a class="login" href="login.php">login</a>';


						// Loads the editing form and display it
						$.ajax(
						{
							type:"POST",
							url:processFile,
							data:"action="+action,
							success: function(data)
							{
								// Hides the form 
								var form =$(data).hide(), 

								// Makes sure the modal widow exists 
								modal= fx.initModal();

								// Creates a button to close the window
								$("<a>")
								.attr("href", "#")
								.addClass("modal-close-btn")
								.html("&times;")
								.click(function(event)
								{
									// Prevent the default action
									event.preventDefault();
									// Removes modal window
									fx.boxout(event);
								})
								.appendTo(modal);

								// Call the boxin function to create 
								// the modal overlay and fade it in 
								fx.boxin(null, modal);
									// Make the cancel button on editing forms behave like the


								// Load the form into the window 
								// fades in the content, and adds 
								// a class to the form
								form.appendTo(modal).fadeIn("slow");

								$(".modal-window").addClass("formRegister");
								$('form.userRegisterForm').bootstrapValidator({
									excluded:[':disabled', ':hidden',':not(:visible)'],
									message:'This value is not valid',
									 feedbackIcons: {
							            valid: 'glyphicon glyphicon-ok',
							            invalid: 'glyphicon glyphicon-remove',
							            validating: 'glyphicon glyphicon-refresh'
							        },
							        fields:{
							        	fullName:{
							                validators: {
							                    notEmpty: {
							                        message: 'The full name is required and cannot be empty'
							                    },
							                    stringLength: {
							                        min: 6,
							                        max: 30,
							                        message: 'The username must be more than 6 and less than 30 characters long'
							                    },
							                    regexp: {
							                        regexp: /^[a-zA-Z 0-9_]+$/,
							                        message: 'The username can only consist of alphabetical, number and underscore'
							                    }
							                }
							            },

							        	email:{
							                validators: {
							                    notEmpty: {
							                        message: 'The email is required and cannot be empty'
							                    },
							                    emailAddress: {
							                        message: 'The input is not a valid email address'
							                    }
							                }
							            },

							          	password: {
							                validators: {
							                    notEmpty: {
							                        message: 'The password is required and cannot be empty'
							                    },
							                    different: {
							                        field: 'userEmail',
							                        message: 'The password cannot be the same as email'
							                    },
							                    securePassword: {
							                        message: 'The password is not valid'
							                    }
							                   
							                }
							            },
							        }
								});

								
								// close button and fade out modal windows and overlays
								fx.cancelButton();
								
								// Prevent the default form action from executing 
								$(".formRegister button[type=submit]").on('click',function(event)
								{
									event.preventDefault();
									
									// Log a message to indicate and preventation has worked
									var formData = $(this).parents("form").serialize();
									// Sends the data to the processing file 
									$.ajax({
										type:'POST',
										url:processFile,
										data:formData,
										beforeSend: function(){
					 	
									        // Code to display spinner
									        
									        $(loader).fadeIn('slow').prependTo('.registerForm');
									       
									    },
										success: function(data){
											// Fades out the modal window
											fx.boxout();
											// Logs a message to console 
											console.log("Event saved!");
										},
										complete: function(){
									        // Code to hide spinner.
									        $(".alert, .alert-success").remove();
									        $(notification).slideDown('slow').insertAfter(".body-header");
									        $('.alert-success').append(msg);
									       

									    
									    },
										error:function(msg)
										{
											alert(msg);
										}
									});

									
								});


							},
							error:function(msg)
							{
								alert(msg);
							}
						});

			});

			$("input[class=options]").on('change',function(event)
			{
				event.preventDefault();
				
				var filterData =$(this).parents("form").serialize();

				
				var id = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);

				var collegeName= window.location.search.replace("?", "");
				
				if(collegeName==""||collegeName==null)
				{
					var collegeNameSlug="";

				}else{
					var collegeNameSlug= "&"+collegeName;
				}


				console.log(id);
				console.log("action=filterForm&id="+id+collegeNameSlug+"&"+filterData);
				var notification= '<div class="container"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div></div></div>';
				var loader= '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
				
				
				$.ajax({
					type:'POST',
					url:processFile,
					data:"action=filterForm&id="+id+collegeNameSlug+"&"+filterData,
					beforeSend: function(){
					 	
				        // Code to display spinner
				        
				        $(notification).slideDown('slow').insertAfter(".body-header");
				        $(loader).fadeIn('slow').appendTo('.alert-success');
				       
				    },
					success:function(data)
					{
						$(".categoryPost>.panel, .categoryPost>.row").remove();
						$(data).fadeIn('slow').appendTo(".categoryPost");
						
					},

				    complete: function(){
				        // Code to hide spinner.
				        $(".alert, .alert-success").remove();				       

				    
				    },
					error: function(msg)
					{
						alert(msg);
					}
				});
			});

	

			// A quick check to make sure the script loaded properly
			// Fire an event to select Subcategory after selecting a category
			$(".category").on('change',function() 
			{
				$(".subCategory").load("assets/inc/processdata.inc.php?id=" + $(".category").val());
			});

			// Fire an event to select universities after selecting a state
			$(".sellerState").on('change',function()
			{
				$(".sellerUniversity").load("assets/inc/processdata.inc.php?state_name=" + $(".sellerState").val());
			});



			// Fire an event to select college after selecting a university
			$(".sellerUniversity").on('change',function() 
			{
				$(".sellerCollege").load("assets/inc/processdata.inc.php?university_name=" + $(".sellerUniversity").val());
			});

		            // Set up the number formatting.
		            
		            $('#priceTextBox').number( true, 0 );
		            
		            

					$(".panel-head").click(function(){
					    if($(this).find("a").length){
					        window.location.href = $(this).find("a").attr("href");
					    }
					});


		            $("#input-id").fileinput({
		            	'showUpload':false,
		            	'showPreview':true, 
		            	'previewFileType':'image',
		            	maxFileSize: 4096,
		            	maxFileCount: 8,
		            	browseLabel: "Pick Images",
		            	browseClass: "btn btn-success",
		            	browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",

		            });



//############################### Few common customized scripts ###########################//
		    // Script initials for jquery slider in classified page

		    $(function() {
		    	var demo1 = $("#demo1").slippry({
		    		transition: 'fade',
		    		useCSS: true,
		    		speed: 1000,
		    		pause: 6000,
		    		auto: true,
		    		preload: 'visible'
		    	});

		    });

		    $(function(){
			    $(".feedback-form").hide(700);
				$("input[name='collegeName']").focus();


				$(".row#feedback").mouseover(function(){
				$(".feedback-form").css("display","block");
				$("textarea").focus();
				});
				
				$(".row#feedback").mouseout(function(){
				$(".feedback-form").css("display","none")
			  	});
		  	});

			// hide #back-top first
			$(".go-top").hide();
			
			// fade in #back-top
			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$('.go-top').fadeIn('slow');
					} else {
						$('.go-top').fadeOut('slow');
					}
				});

				// scroll body to 0px on click
				$('a.go-top, a[href=#top]').click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
			});



			$(function()
			{  
			    $('.footer-text li a').hover(function()
			    {  
			        $(this).stop().animate(
			        {  
			            left: '8px'			
			        }, 150);  
			    }, 
			    function()
			    {  
			        $(this).stop().animate(
			        {  
			            left: '0'  
			        }, 150);  
			    });  
			}); 





$('.collegeName').typeahead({                                   
  name: 'example',                                                             
  local: [
        'IIT Delhi',
        'Delhi Technological University',
        'Netaji Subhash Institute of Technology',
        'IIIT Delhi',
        'Jawaharlal Nehru University',
        'Jamia Millia Islamia',
        'NIFT Delhi',
        'Shri Ram College of Commerce',
        'NIT Delhi',
        'Shri Ram College of Commerce',
  ]                                                                           
});

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  




		}); // End of the file [closing of jQuery.()]


