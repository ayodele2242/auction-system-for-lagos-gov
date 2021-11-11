// global the manage memeber table 
var userTable;

$('document').ready(function()
{
    /* validation */
    $("#editSetting").validate({
        rules:
        {
         
         installUrl:{
           required: true
         },
         
        },
        messages:
        {
          installUrl: "Please enter website url follow by a trailing slash",
          
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#editSetting").serialize();

        $.ajax({

            type : 'POST',
            url  : 'setting/sitesetting.php',
            data : data,
            beforeSend: function()
            {
                $(".mymsg").fadeOut();
                $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; Processing...');
            },
            success :  function(data)
            {
                if(data=="w"){
                    $("#btn-submit").html('<span class="fa fa-plus"></span> &nbsp; Retry');
                    $(".mymsg").fadeIn(1000, function(){
                       $(".mymsg").html('<div class="alert alert-danger"> <span class="fa fa-info"></span> &nbsp; Enter your website url.</div>');
                        
                    });

                }
                else if(data=="saved")
                {
                //$("#editSetting").reset();
                $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Updated');
                    $(".mymsg").fadeIn(1000, function(){
                    $(".mymsg").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Update Was Successfully!!</div>'); 
                });
                

                 // reload the datatables
				$("#userTable").DataTable().ajax.reload();
				// this function is built in function of datatables;
                
                }
                else{

                    $(".mymsg").fadeIn(1000, function(){

                        $(".mymsg").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

                        

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});