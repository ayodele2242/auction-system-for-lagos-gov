
$(document).ready(function (e) {
    
$("#sliderForms").on('submit',(function(e) {
        e.preventDefault();

        
        $.ajax({
            url: "php_action/slider.php",
            type: "POST",
            data:  new FormData($("#sliderForms")[0]),//new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; Uploading');
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function(data)
            {
                
			 if(data=="saved")
					{
						$("#message").fadeIn(1000, function(){
                            
							$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Uploaded Successfully! </div>');
								   				   
                               });
                               $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Uploaded');
                               $('input[type="text"]').val('');
                               $('input[type="file"]').val('');
                               $('input[type="textarea"]').val('');
                               $("#avatar-2").val('');
                                $(".fileinput-remove-button").click();
                                $(".stasy").load(location.href + " .stasy");
							   
							   
								//empTable.ajax.reload(null, false);
					}
					else{
			
						$("#message").fadeIn(1000, function(){
			
							$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
						});
                        $("#btn-submit").html('<i class="fa fa-user-plus"></i> Failed');
			
					}
			

            },
            error: function() 
            {
            } 	        
       });
    }));
});



function removeContent(page_id = null) {
	if(page_id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'php_action/remove.php',
				type: 'post',
				data: {member_id : page_id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        // close the modal
						$(".removem").modal('hide');    

						// refresh the table
						$(".stasy").load(location.href + " .stasy");

						

					} else {
						$(".removeMessages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
							'</div>');
					}
				}
			});
		}); // click remove btn
	} else {
		alert('Error: Refresh the page again');
	}
}