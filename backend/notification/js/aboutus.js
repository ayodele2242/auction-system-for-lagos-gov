// global the manage memeber table 
var aboutusTable;

$(document).ready(function() {
	aboutusTable = $("#aboutusTable").DataTable({
		"ajax": "aboutus/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		"pageLength": 150,
		"order": []
	});

	$("#addAboutModalBtn").on('click', function() {
		// reset the form 
		$("#aboutUsForm")[0].reset();
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// submit form
		$("#aboutUsForm").unbind('submit').bind('submit', function() {

			$(".text-danger").remove();

			var form = $(this);

			// validation
			var title = $("#title").val();
			var ckeditor = $("#ckeditor").val();
			//var sname = $("#sname").val();
			
			/*if(sname == "") {
				$("#sname").closest('.form-group').addClass('has-error');
				$("#sname").after('<p class="text-danger"></p>');
			} else {
				$("#sname").closest('.form-group').removeClass('has-error');
				$("#sname").closest('.form-group').addClass('has-success');				
			}*/
			
			if(title == "") {
				$("#title").closest('.form-group').addClass('has-error');
				$("#title").after('<p class="text-danger">Title is required</p>');
			} else {
				$("#title").closest('.form-group').removeClass('has-error');
				$("#title").closest('.form-group').addClass('has-success');				
			}
			

			if(ckeditor == "") {
				$("#ckeditor").closest('.form-group').addClass('has-error');
				$("#ckeditor").after('<p class="text-danger">Content is required</p>');
			} else {
				$("#ckeditor").closest('.form-group').removeClass('has-error');
				$("#ckeditor").closest('.form-group').addClass('has-success');				
			}

			
			if(title && ckeditor) {
				//submi the form to server
				$.ajax({
					url : form.attr('action'),
					type : form.attr('method'),
					data : form.serialize(),
					dataType : 'json',
					success:function(response) {

						// remove the error 
						$(".form-group").removeClass('has-error').removeClass('has-success');

						if(response.success == true) {
							$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');

							// reset the form
							$("#aboutUsForm")[0].reset();		

							// reload the datatables
							aboutusTable.ajax.reload(null, false);
							// this function is built in function of datatables;

						} else {
							$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
							'</div>');
						}  // /else
					} // success  
				}); // ajax subit 				
			} /// if


			return false;
		}); // /submit form for create member
	}); // /add modal

});

function removeAbout(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'aboutus/remove.php',
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
						aboutusTable.ajax.reload(null, false);

						// close the modal
						$("#removeDeptModal").modal('hide');

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

function editAbout(id = null) {
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
			url: 'aboutus/getSelectedMember.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {
				
				$("#edittitle").val(response.header);
				$("#editckeditor").val(response.contents);


				// mmeber id 
				$(".editMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');

				// here update the member data
				$("#updateAboutForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

					// validation
					var edittitle = $("#edittitle").val();
					var editckeditor = $("#editckeditor").val();
					
					
					if(edittitle == "") {
						$("#edittitle").closest('.form-group').addClass('has-error');
						$("#edittitle").after('<p class="text-danger">Title is required</p>');
					} else {
						$("#edittitle").closest('.form-group').removeClass('has-error');
						$("#edittitle").closest('.form-group').addClass('has-success');				
					}

					if(editckeditor == "") {
						$("#editckeditor").closest('.form-group').addClass('has-error');
						$("#editckeditor").after('<p class="text-danger">Content is required</p>');
					} else {
						$("#editckeditor").closest('.form-group').removeClass('has-error');
						$("#editckeditor").closest('.form-group').addClass('has-success');				
					}


					if(edittitle && editckeditor) {
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
									aboutusTable.ajax.reload(null, false);
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