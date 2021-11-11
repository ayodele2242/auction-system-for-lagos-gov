$('document').ready(function()
{
    /* validation */
    $("#sms-form").validate({
        rules:
        {
            subject_sms:{
            required: true
          },
          
          body_sms:{
           required: true
         },
      
        },
        messages:
        {
          subject_sms: "Text subject is required",
          body_sms: "You have forgotten to type your text message",
         },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#sms-form").serialize();

        $.ajax({

            type : 'POST',
            url  : 'send_sms.php',
            data : data,
            beforeSend: function()
            {
                $("#errors").fadeOut();
                $("#btn-submits").html('<img src="../img/processing.gif" width="30" /> &nbsp; sending...');
            },
            success :  function(data)
            {
                if(data=="sm")
                {
                    $("#errors").fadeIn(1000, function(){

                        $("#errors").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Successfully Sent!!</div>');
                        $("#btn-submits").html('<span class="fa fa-check"></span> &nbsp; Sent');

                    });
                }
                
                else{

                    $("#errors").fadeIn(1000, function(){

                        $("#errors").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                    

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});