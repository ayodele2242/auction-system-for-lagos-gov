  /* $(function(){
    var curHeight = $('.text').height();     
    if(curHeight==100)
        $('.readmore').show();
    else
        $('.readmore').hide();
});     
function changeheight() {
       var readmore = $('.readmore');
       if (readmore.text() == 'Read more') {
           readmore.text("Read less");
             $(".textbody").animate({maxHeight : '80px', height : '80px'},"slow");
       } else {
           readmore.text("Read more");
             $(".textbody").animate({maxHeight : '38px', height: '38px'},"slow");
       }           
};/*/
 
  

$(document).ready(function (e) {
    
$("#page").on('submit',(function(e) {
        e.preventDefault();

        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        $.ajax({
            url: "page/insert.php",
            type: "POST",
            data:  new FormData($("#page")[0]),//new FormData(this),
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
				if(data==1){

					$("#message").fadeIn(1000, function(){
					 $("#message").html('<div class="alert alert-danger"> <span class="fa fa-info-circle"></span> &nbsp; Dupliate entries: Title and/or Content already exist! </div>');
									
                        });
                        $("#btn-submit").html('<i class="fa fa-user-plus"></i> Retry');
			
					}else if(data=="added")
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
    
    $("#pagedit").on('submit',(function(e) {
            e.preventDefault();
    
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            
            $.ajax({
                url: "page/edit.php",
                type: "POST",
                data:  new FormData($("#pagedit")[0]),//new FormData(this),
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
	

function removeContent(page_id = null) {
	if(page_id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'page/remove.php',
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


//Tags
$(document).ready(function (e) {
    
    $("#addtags").on('submit',(function(e) {
            e.preventDefault();
    
                       
            $.ajax({
                url: "tags/save.php",
                type: "POST",
                data:  new FormData($("#addtags")[0]),//new FormData(this),
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
                    if(data==1){
    
                        $("#message").fadeIn(1000, function(){
                         $("#message").html('<div class="alert alert-danger"> <span class="fa fa-info-circle"></span> &nbsp; Dupliate entries: Title and/or Content already exist! </div>');
                                        
                            });
                            $("#btn-submit").html('<i class="fa fa-user-plus"></i> Retry');
                
                        }else if(data=="added")
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


    //Comment 

$(document).ready(function (e) {
$("#commentit").on('submit',(function(e) {
        e.preventDefault();   
        tinyMCE.triggerSave();     
        $.ajax({
            url: "page/comment_insert.php",
            type: "POST",
            data:  new FormData($("#commentit")[0]),//new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $("#btn-submit").html('commenting');
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function(data)
            {
				if(data=="done")
					{
					           $("#btn-submit").html('<span class="fa fa-comment"></span> &nbsp; Comment');
                               $(".stas").load(location.href + " .stas");
                               $("#mcomment").val('');
                               var tinymce_editor_id = 'mcomment'; 
                               tinymce.get(tinymce_editor_id).setContent('');

                               
					}
					else{
			
						$("#message").fadeIn(1000, function(){
			
							$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
						});
                        $("#btn-submit").html('<i class="fa fa-comment"></i> Retry');
			
					}
			

            },
            error: function() 
            {
            } 	        
       });
    }));
});