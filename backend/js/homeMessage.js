$(document).ready(function (e) {
    
$("#homemessage").on('submit',(function(e) {
        e.preventDefault();

        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        $.ajax({
            url: "homeMessage/edit.php",
            type: "POST",
            data:  new FormData($("#homemessage")[0]),//new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; Saving');
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function(data)
            {
				if(data=="updated")
					{
						
                               $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Saved');
                               
					}
					else{
			
						$("#message").fadeIn(1000, function(){
			
							$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
						});
                        $("#btn-submit").html('<i class="fa fa-user-plus"></i> Retry');
			
					}
			

            },
            error: function() 
            {
            } 	        
       });
    }));
});

