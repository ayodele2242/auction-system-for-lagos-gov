$('document').ready(function()
{
    /* validation */
    $("#register-form").validate({
        rules:
        {
         /* title:{
            required: true
          },
          
         
      
         fname:{
          required: true
        },
        mname:{
          required: true
        },
         
        mstatus:{
          required: true
        },
        jstatus:{
          required: true
        },
        gender:
          required: true
        },*/
        lname:{
            required: true
          },
        fname:{
            required: true
          },
        uname: {
            required: true
        },
        email: {
        required: true,
        email: true
    },
         pass: {
                required: true,
                minlength: 8,
                maxlength: 15
            },
            cpass: {
                required: true,
                equalTo: '#pass'
            },
           /* */
           /* crt_uname: {
                required: true,
                email: true
            },*/
        },
        messages:
        {
          /*title: "Title required",
          sname: "Please enter surname",
          fname: "Please enter first name",
          mname: "Please enter middle name",
          mstatus: "Marital status is required",
          jstatus: "jobseeker category(graguate or artisan) is required",
          gender: "Select gender",*/
          lname: "Enter your last name",
          fname: "Enter your first name",
          uname: "Enter desired username",
          pass:{
                required: "Provide a Password",
                minlength: "Password Needs To Be Minimum of 8 Characters"
            },
            email: "Enter a Valid Email"
           /* user_email: "Enter a Valid Email",
            cpassword:{
                required: "Retype Your Password",
                equalTo: "Password Mismatch! Retype"
            }*/
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#register-form").serialize();

        $.ajax({

            type : 'POST',
            url  : 'includes/register.php',
            data : data,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('processing ...');
            },
            success:  function(data)
            {
              if(data=="registered")
                {
                    $("#error").fadeIn(1000, function(){
                   $("#btn-submit").html('Create Account');
                    $("#error").html('<div class="alert alert-success"><span class="glyphicon glyphicon-thumb-up"></span> &nbsp; Registered successfully</div>');
                });
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