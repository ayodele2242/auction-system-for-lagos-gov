var empTable;

$(document).ready(function() {
	empTable = $("#empTable").DataTable({
		"ajax": "user/retrieve.php",
		//"scrollY": 370,
        //"scrollX": true,
		"pageLength": 150,
		"order": []
	});
	

});
 
$(document).ready(function (e) {
    $("#insertEmployee").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
            url: "user/employee_insert.php",
            type: "POST",
            data:  new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $(".btn-student").html('<img src="../img/processing.gif" width="30" /> &nbsp; please wait');
            },
            contentType: false,
            processData:false,
            success: function(data)
            {
				if(data==1){

					$("#message").fadeIn(1000, function(){
					 $("#message").html('<div class="alert alert-danger"> <span class="fa fa-info-circle"></span> &nbsp; Dupliate entry: Email and/or Username already exist! </div>');
							$("#btn-submit").html('<i class="fa fa-user-plus"></i> Retry');
			
						});
			
					}else if(data=="added")
					{
						$("#message").fadeIn(1000, function(){
							$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
								   $("#btn-submit").html('<i class="fa fa-user-plus"></i> Add Another Employee');
				   
							   });
							   $(".fileinput-remove-button").click();
							   $('input[type="text"]').val('');
							   $('input[type="number"]').val('');
							   $('input[type="email"]').val('');
							   $('input[type="password"]').val('');
							   $('input[type="file"]').val('');
							   $('textarea').val('');
							   $(".btn-student").html('<span class="fa fa-check"></span> &nbsp; Saved');
							   
								empTable.ajax.reload(null, false);
					}
					else{
			
						$("#message").fadeIn(1000, function(){
			
							$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
							$("#btn-submit").html('<i class="fa fa-user-plus"></i> Retry');
						});
			
					}
			

            },
            error: function() 
            {
            } 	        
       });
    }));
});


$(document).ready(function (e) {
    $("#editEmployee").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
            url: "user/edit.php",
            type: "POST",
            data:  new FormData(this),
            beforeSend: function(){
            $("#message").fadeOut();
            $(".btn-student").html('<img src="../img/processing.gif" width="30" /> &nbsp; updating');
            },
            contentType: false,
            processData:false,
            success: function(data)
            {
            if(data=="saved")
                    {
                        $("#message").fadeIn(1000, function(){
                            $("#message").html('<div class="alert alert-success alert-dismissible"> <span class="fa fa-check"></span> &nbsp; Updated Successfully! </div>');
                           
                   
                               });
                               //$('input[type="text"]').val('');
                               // $('textarea').val('');
                            $(".fileinput-remove-button").click();
                            $(".btn-student").html('<span class="fa fa-check"></span> &nbsp; Updated');
                            $(".rid").load(location.href + " .rid");
                            $(".rid2").load(location.href + " .rid2");
                            $(".rid3").load(location.href + " .rid3");
                            //$("#student-form")[0].reset();
                     }
                    else{
            
                        $("#message").fadeIn(1000, function(){
            
                            $("#message").html('<div class="alert alert-danger alert-dismissible"><span class="fa fa-info-circle"></span> &nbsp; '+data+' </div>');
                            $(".btn-student").html('<i class="fa fa-user-plus"></i> Try again');
                        });
            
                    }


            },
            error: function() 
            {
            } 	        
       });
    }));
});


function removeUser(id = null) {
	if(id) {
		// click on remove button
		$("#removeMeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'user/remove.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$("#message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');

						// refresh the table
						$("#empTable").DataTable().ajax.reload(null, false);

						// close the modal
						$("#userModal").modal('hide');

					} else {
						$("#message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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


//View employee details

$(document).ready(function(){
    $('#eModal').on('show.bs.modal', function (e) {
        var eid = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'new.php', //Here you will fetch records 
            data :  'rowid='+ eid, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
