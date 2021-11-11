// global the manage student table 
var notice;

$(document).ready(function() {
	notice = $("#notice").DataTable({
		"ajax": "notices/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		 "pageLength": 150,
		"order": []
	});

/* validation */
$("#notice-form").validate({
	rules:
	{
		  code: {
		  required: true,
		  },
		  name: {
		  required: true,
	 },
	 },
	 messages:
	 {
		  code:{
					required: "Notices title is required"
				   },
		 name: "Content is required",
	 },
	 submitHandler: noticesForm	
	 });  
	 /* validation */
	 
	 /* login submit */
	 function noticesForm()
	 {		
		  var data = $("#notice-form").serialize();
		  tinyMCE.triggerSave(); 	    
		  $.ajax({		  
		  type : 'POST',
		  url  : 'notices/insert.php',
		  data : data,
		  beforeSend: function()
		  {	
			  
			  $("#message").fadeOut();
			  $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; please wait');
		  },
		  success :  function(response)
			 {						
				if(response==1){

					$("#message").fadeIn(1000, function(){
					 $("#message").html('<div class="alert alert-danger"> <span class="fa fa-info-circle"></span> &nbsp; Dupliate entry. Notice  already exist in the database! </div>');
							$("#btn-submit").html('<i class="fa fa-plus"></i> Add ');
			
						});
			
					}else if(response=="added")
					{
						$("#message").fadeIn(1000, function(){
							$("#message").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
								   $("#btn-submit").html('<i class="fa fa-plus"></i> Add again');
				   
							   });
							   $('#notice-form')[0].reset();
							   notice.ajax.reload(null, false);
					}
					else{
			
						$("#message").fadeIn(1000, function(){
			
							$("#message").html('<div class="alert alert-danger"><span class="fa fa-info-circle"></span> &nbsp; '+response+' !</div>');
							$("#btn-submit").html('<i class="fa fa-plus"></i> Add notices');
						});
			
					} 

			}
		  });
			  return false;
      }

});

 
function removeSub(id = null) {
	if(id) {
		// click on remove button
		$("#removeSubBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'notices/remove.php',
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
						notice.ajax.reload(null, false);

						// close the modal
						$("#removeSubModal").modal('hide');

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

function editSub(id = null) {
	if(id) {

		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".edit-messages").html("");

		// remove the id
		$("#member_id").remove();

		// fetch the member data
		$.ajax({
			url: 'notices/getSelectedMember.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {
		
			$("#editcode").val(response.subect_code);
			$("#editname").val(response.notice);
			


				// mmeber id 
				$(".editSubModal").append('<input type="hidden" etype="member_id" id="member_id" value="'+response.id+'"/>');
				
				// here update the member data
				$("#updateSubForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

			var editcode = $("#editcode").val();
			var editname = $("#editname").val();
			
			
			if(editcode == "") {
				$("#editcode").closest('.form-group').addClass('has-error');
				$("#editcode").after('<p class="text-danger">Please enter notices code</p>');
			} else {
				$("#editcode").closest('.form-group').removeClass('has-error');
				$("#editcode").closest('.form-group').addClass('has-success');				
			}
			
						
			if(editname == "") {
				$("#editname").closest('.form-group').addClass('has-error');
				$("#editname").after('<p class="text-danger">notices name is required</p>');
			} else {
				$("#editname").closest('.form-group').removeClass('has-error');
				$("#editname").closest('.form-group').addClass('has-success');				
			}




			if(editcode && editname) {
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if(response.success == true) {
									$(".edit-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
									'</div>');

									// reload the datatables
									notice.ajax.reload(null, false);
									// this function is built in function of datatables;

									// remove the error 
									$(".form-group").removeClass('has-success').removeClass('has-error');
									$(".text-danger").remove();
								} else {
									$(".edit-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
									'</div>')
								}
							} // /success
						}); // /ajax
					} // /if

					return false;
				});

			} // /success
		}); // /fetch selected member info

	} else {
		alert("Error : Refresh the page again");
	}
}