var busTable;

$(document).ready(function() {
	busTable = $("#busTable").DataTable({
		"ajax": "bus/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		"pageLength": 150,
		"order": []
	});
	

});

 // Insert class
 $('#insertBus').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "bus/insert.php",
	  method: "post",
	  data: $('form').serialize(),
	  //dataType: "text",
	  beforeSend: function()
	  {
		  $("#message").fadeOut();
		  $(".status").html('<img src="../img/processing.gif" width="30" /> &nbsp; please wait');
	  },
	  success: function(data){
		//$('#message').html(strMessage);
		//$('#insertClass')[0].reset();
		//busTable.ajax.reload(null, false);
		if(data=="added")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
					   $("#btn-submit").html('<i class="fa fa-plus"></i> Add again');
	   
				   });
				   $('#insertBus')[0].reset();
                    busTable.ajax.reload(null, false);
                    $(".status").html('');
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				//$("#btn-submit").html('<i class="fa fa-plus"></i> Add Class');
			});

		}

	  }
	})
  })


 
 // Update class
 $('#UpdateBus').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "bus/update.php",
	  method: "post",
	  data: $('form').serialize(),
	  //dataType: "text",
	  beforeSend: function()
	  {
		  $("#message").fadeOut();
		  $(".status").html('<img src="../img/processing.gif" width="30" /> &nbsp; Updating, please wait');
	  },
	  success: function(data){
		//$('#message').html(strMessage);
		//$('#insertClass')[0].reset();
		//officerTable.ajax.reload(null, false);
		if(data=="updated")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Details Updated Successfully! </div>');
					  // $("#btn-submit").html('<i class="fa fa-plus"></i> Add again');
	   
				   });
				   $(".status").html('');
				   //$('#insertClass')[0].reset();
		            busTable.ajax.reload(null, false);
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				//$("#btn-submit").html('<i class="fa fa-plus"></i> Add Class');
				$(".status").html('');
			});

		}

	  }
	})
  })


function removeBus(id = null) {
	if(id) {
		// click on remove button
		$("#removeClassBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'bus/remove.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');

						// refresh the table
						busTable.ajax.reload(null, false);

						// close the modal
						$("#classModal").modal('hide');

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


$(document).ready(function(){
 
    function fetch_post_data(post_id)
    {
     $.ajax({
      url:"bus/view.php",
      method:"POST",
      data:{post_id:post_id},
      success:function(data)
      {
       $('#post_modal').modal('show');
       $('#post_detail').html(data);
      }
     });
    }
   
    $(document).on('click', '.view', function(){
     var post_id = $(this).attr("id");
     fetch_post_data(post_id);
    });
   
    $(document).on('click', '.previous', function(){
     var post_id = $(this).attr("id");
     fetch_post_data(post_id);
    });
   
    $(document).on('click', '.next', function(){
     var post_id = $(this).attr("id");
     fetch_post_data(post_id);
    });
    
   });

