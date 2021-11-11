//Employer Login details
$('document').ready(function()
{ 
 /* validation */
 $("#login-form").validate({
	rules:
	{
		  password: {
		  required: true,
		  },
		  username: {
		  required: true
		  },
	 },
	 messages:
	 {
		  password:{
					required: "Password required"
				   },
		  username: "Enter Your username",
	 },
	 submitHandler: loginForm	
	 });  
	 /* validation */
	 
	 /* login submit */
	 function loginForm()
	 {		
		  var data = $("#login-form").serialize();
			  
		  $.ajax({
			  
		  type : 'POST',
		  url  : '../includes/alumni_login.php',
		  data : data,
		  beforeSend: function()
		  {	
			  $("#error").fadeOut();
			  $("#btn-login").html('<img src="../img/processing.gif" width="30" /> &nbsp; Please wait');
		  },
		  success :  function(response)
			 {						
				  if(response=="yes"){
								  
					  $("#btn-employer").html('<img src="../img/processing.gif" width="30" /> &nbsp; Signing in');
					  setTimeout(' window.location.href = "../alumnis/redirect"; ',4000);
				  }
				 
				 else if(response=="s"){
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Your account has been sustended. Contact the administrator.!</div>');
													$("#btn-login").html('<span class="fa fa-sign-in"></span> &nbsp; Sign In');
					});
				}
				else if(response=="i"){
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Your account is inactive at the moment.</div>');
													$("#btn-login").html('<span class="fa fa-sign-in"></span> &nbsp; Sign In');
					});
				}
				  else{								  
					  $("#error").fadeIn(1000, function(){						
			  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
										  $("#btn-login").html('<span class="fa fa-sign-in"></span> &nbsp; Sign In');
								  });
				  }
			}
		  });
			  return false;
      }
    });
	 /* employer login submit */
