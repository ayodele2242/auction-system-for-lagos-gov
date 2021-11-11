$('document').ready(function()
{
    /* validation */
    $("#pwdForm").validate({
        rules:
        {
            old_password:{
            required: true
          },
         
          new_password:{
            required: true,
            minlength: 8,
            maxlength: 15
        },
        con_newpassword:{
          required: true
        },
            
            cpassword: {
                required: true,
                equalTo: '#new_password'
            },
           
        },
        messages:
        {
         
            new_password:{
                required: "Provide a New Password",
                minlength: "Password Needs To Be Minimum of 8 Characters"
            },
            con_newpassword:{
                required: "Retype Your Password",
                equalTo: "Password Mismatch! Retype"
            }
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#pwdForm").serialize();

        $.ajax({

            type : 'POST',
            url  : 'pwd/pwd_update.php',
            data : data,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('<img src="img/processing.gif" width="30" /> &nbsp; processing ...');
            },
            success :  function(data)
            {
                if(data==1){

                    $("#error").fadeIn(1000, function(){


                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry email already taken !</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in btns"></span> &nbsp; Create Account');

                    });

                }
                else if(data=="registered")
                {
                    $("#btn-submit").html('<img src="img/processing.gif" width="30" /> &nbsp; Signing Up ...');
                    setTimeout(' window.location.href = "success.php"; ',4000);
                }
                else{

                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in btns"></span> &nbsp; Create Account');

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});