var accountTable;

$(document).ready(function() {
    accountTable = $("#accountTable").DataTable({
		"ajax": "accounts/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		"pageLength": 150,
		"order": []
	});
	
});



 // Insert class
 $('#addAccount').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "accounts/pay.php",
	  method: "post",
	  data: $('form').serialize(),
	  //dataType: "text",
	  beforeSend: function()
	  {
		  $("#message").fadeOut();
		  $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; making payment');
	  },
	  success: function(data){
		if(data=="paid")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Payment Made Successfully! </div>');
					   $("#btn-submit").html('<i class="fa fa-check"></i> Add again');
	   
				   });
				   $('#addAccount')[0].reset();
		            //classTable.ajax.reload(null, false);
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				$("#btn-submit").html('<i class="fa fa-check"></i> Pay');
			});

		}

	  }
	})
  })



   // Insert class
 $('#updateAccount').submit(function(event){
	event.preventDefault();
	//var data = $("#register-form").serialize();
	$.ajax({
	  url: "accounts/update.php",
	  method: "post",
	  data: $('form').serialize(),
	  //dataType: "text",
	  beforeSend: function()
	  {
		  $("#message").fadeOut();
		  $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; updating payment');
	  },
	  success: function(data){
		if(data=="paid")
		{
			$("#message").fadeIn(1000, function(){
				$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Payment Updated Successfully! </div>');
					   $("#btn-submit").html('<i class="fa fa-check"></i> Updated');
	   
				   });
                   accountTable.ajax.reload(null, false);
                   $(".rid").load(location.href + " .rid");
                   $('#updateAccount')[0].reset();
		}
		else{

			$("#message").fadeIn(1000, function(){

				$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+data+' !</div>');
				$("#btn-submit").html('<i class="fa fa-check"></i> Pay');
			});

		}

	  }
	})
  })



