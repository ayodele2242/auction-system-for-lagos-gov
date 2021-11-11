//Employer Login details
$('document').ready(function()
{ 
 /* validation */
 $("#forgot_password").validate({
	rules:
	{
            email: {
            required: true,
            email: true
            },
	 },
	 messages:
	 {
        email: "Email address required"
	 },
	 submitHandler: forgotForm	
	 });  
	 /* validation */
	 
	 /* login submit */
	 function forgotForm()
	 {		
		  var data = $("#forgot_password").serialize();
			  
		  $.ajax({
			  
		  type : 'POST',
		  url  : '../includes/admin_pwd_recovery.php',
		  data : data,
		  beforeSend: function()
		  {	
			  $("#error").fadeOut();
			  $("#submit-btn").html('<img src="../img/processing.gif" width="30" /> &nbsp; checking');
		  },
		  success :  function(response)
			 {						
				  if(response=="sent"){
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-check"></span> &nbsp; You have successfully reset your password. Check your inbox for your news password!</div>');
					   $("#submit-btn").html('<span class="fa fa-check"></span> &nbsp; Sent');
					});
				  }
				  else if(response=="e"){
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; There is an error sending mail!</div>');
						$("#submit-btn").html('<i class="fa fa-envelope-o" ></i> RESET MY PASSWORD');
					});
				}
				else{
								  
					  $("#error").fadeIn(1000, function(){						
			  $("#error").html('<div class="alert alert-danger" style="font-size:12px;"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
			  $("#submit-btn").html('<i class="fa fa-envelope-o" ></i> RESET MY PASSWORD');
								  });
				  }
			}
		  });
			  return false;
      }
    });
	 /* employer login submit */
