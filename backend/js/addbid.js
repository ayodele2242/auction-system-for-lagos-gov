$('document').ready(function()
{
    /* validation */
    $("#addbid").validate({
        rules:
        {
        
            bidPrice:{
            required: true
          },
        
        },
        messages:
        {
         
            bidPrice: "Enter the amount bidding for"
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#addbid").serialize();
        var bla = $('#bidP').val();

        $.ajax({

            type : 'POST',
            url  : 'php/addbid.php',
            data : data,
            beforeSend: function()
            {
                //$("#error").fadeOut();
                //$("#merror").fadeOut();
                $("#btn-submit").html('processing ...');
            },
            success:  function(data)
            {
               if(data=="unacceptable")
                {
                    $("#btn-submit").html('Place Bid');
                    $("#error").html('<div class="alert alert-danger removeMessages"><i class="fa fa-info-sign" aria-hidden="true"></i> &nbsp; Enter value greater than '+bla+'</div>');

                }else if(data=="bid")
                {
                    $("#btn-submit").html('Place Bid');
                   // $("#btn-submit").html('Bidding...');
                    $("#error").html('<div class="alert alert-success removeMessages"><i class="fa fa-thumbs-up" aria-hidden="true"></i> &nbsp; Successfully Bidded</div>');

                }
                else{

                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-danger removeMessages"><span class="fa fa-info-sign"></span> &nbsp; '+data+' !</div>');

                        $("#btn-submit").html('Place Bid');

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});