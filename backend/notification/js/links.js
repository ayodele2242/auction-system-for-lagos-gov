$(document).ready(function (e) {
    
$("#links").on('submit',(function(e) {
        e.preventDefault();

        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        $.ajax({
            url: "link/insert.php",
            type: "POST",
            data:  new FormData($("#links")[0]),//new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; please wait');
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function(data)
            {
				if(data=="added")
					{
						$("#message").fadeIn(1000, function(){
                            
							$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
								   				   
                               });
                               $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Saved');
                               $('input[type="text"]').val('');
                               $('input[type="file"]').val('');
                               $('select').val('');
                               $(".stas").load(location.href + " .stas");
                               $("#avatar-2").val('');
                                $(".fileinput-remove-button").click();
                                for ( instance in CKEDITOR.instances ){
                                    CKEDITOR.instances[instance].updateElement();
                                }
                                    CKEDITOR.instances[instance].setData('');
							   
							   
								//empTable.ajax.reload(null, false);
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

//Edit Page


$(document).ready(function (e) {
    
    $("#editlinks").on('submit',(function(e) {
            e.preventDefault();
    
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            
            $.ajax({
                url: "link/edit.php",
                type: "POST",
                data:  new FormData($("#editlinks")[0]),//new FormData(this),
                beforeSend: function(){
                $("#message").fadeOut();
                $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; please wait');
                },
                contentType: false,
                cache: false,
                processData: false,
                async: false,
                success: function(data)
                {
                     if(data=="updated")
                        {
                            $("#message").fadeIn(1000, function(){
                               
                                $("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Updated Successfully! </div>');
                                                          
                                   });
                                   $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Updated Successfully');
                                   $(".stasy").load(location.href + " .stasy");
                                   $(".fileinput-remove-button").click();
                                   
                                 
                        }
                        else{
                
                            $("#message").fadeIn(1000, function(){
                
                                $("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
                            });
                            $("#btn-submit").html('<i class="fa fa-error"></i> Failed. Retry!');
                
                        }
                
    
                },
                error: function() 
                {
                } 	        
           });
        }));
    });
	

function removeLink(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'link/remove.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        // close the modal
						$(".elinks").modal('hide');    

						// refresh the table
						$(".stas").load(location.href + " .stas");

						

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