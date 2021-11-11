var classTable;

$(document).ready(function() {
	classTable = $("#classTable").DataTable({
		"ajax": "office/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		"pageLength": 150,
		"order": []
	});
	

});

 // Insert class
 $('#insertClass').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "office/insert.php",
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
		//classTable.ajax.reload(null, false);
		if(data==1){

		$("#message").fadeIn(1000, function(){
     	$("#message").html('<div class="alert alert-danger"> <span class="fa fa-info-circle"></span> &nbsp; Dupliate entry. Class already exist in the database! </div>');
				$("#btn-submit").html('<i class="fa fa-plus"></i> Add Class');

			});

		}else if(data=="added")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
					   $("#btn-submit").html('<i class="fa fa-plus"></i> Add again');
	   
				   });
				   $(".status").html('');
				   $('#insertClass')[0].reset();
		            classTable.ajax.reload(null, false);
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				$("#btn-submit").html('<i class="fa fa-plus"></i> Add Class');
			});

		}

	  }
	})
  })


  
 // Update class
 $('#UpdateClass').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "office/update.php",
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
		//classTable.ajax.reload(null, false);
		if(data=="updated")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Details Updated Successfully! </div>');
					   $("#btn-submit").html('<i class="fa fa-plus"></i> Add again');
	   
				   });
				   $(".status").html('');
				   //$('#insertClass')[0].reset();
		            classTable.ajax.reload(null, false);
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				$("#btn-submit").html('<i class="fa fa-plus"></i> Add Class');
			});

		}

	  }
	})
  })

function removeClass(id = null) {
	if(id) {
		// click on remove button
		$("#removeClassBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'office/remove.php',
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
						classTable.ajax.reload(null, false);

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