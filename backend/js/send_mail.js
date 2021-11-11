$('document').ready(function()
{
    /* validation */
    $("#mail-form").validate({
        rules:
        {
          subject:{
            required: true
          },
          
         body:{
           required: true
         },
      
        },
        messages:
        {
          subject: "Email subject is required",
          body: "You have forgotten to type your mail message",
         },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#mail-form").serialize();

        $.ajax({

            type : 'POST',
            url  : 'send_mail.php',
            data : data,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; sending...');
            },
            success :  function(data)
            {
                if(data=="sm")
                {
                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Successfully Sent!!</div>');
                        $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Sent');

                    });
                }
                else if(data=="db")
                {
                        $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Saved only to database and mail not sent!!</div>');
                        $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Sent');

                    });
                }
                else{

                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                    

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});