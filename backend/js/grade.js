// global the manage memeber table 
var manageGradeTable;

$(document).ready(function() {
	manageGradeTable = $("#manageGradeTable").DataTable({
		"ajax": "grade/retrieve.php",
		//"scrollY": 370,
        //"scrollX": true,
		// "pageLength": 150,
		"order": []
	});

	$("#addGradeModalBtn").on('click', function() {
		// reset the form 
		$("#createGradeForm")[0].reset();
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// submit form
		$("#createGradeForm").unbind('submit').bind('submit', function() {

			$(".text-danger").remove();

			var form = $(this);

			// validation
			var sname = $("#sname").val();
			var matric = $("#matric").val();
			var ccode = $("#ccode").val();
			var tscore = $("#tscore").val();
			var escore = $("#escore").val();
			var semester = $("#semester").val();
			var level = $("#level").val();
			var session = $("#session").val();

			
			if(sname == "") {
				$("#sname").closest('.form-group').addClass('has-error');
				$("#sname").after('<p class="text-danger"></p>');
			} else {
				$("#sname").closest('.form-group').removeClass('has-error');
				$("#sname").closest('.form-group').addClass('has-success');				
			}
			
			if(matric == "") {
				$("#matric").closest('.form-group').addClass('has-error');
				$("#matric").after('<p class="text-danger">Student Matric Number is required</p>');
			} else {
				$("#matric").closest('.form-group').removeClass('has-error');
				$("#matric").closest('.form-group').addClass('has-success');				
			}
			
			if(ccode == "") {
				$("#ccode").closest('.form-group').addClass('has-error');
				$("#ccode").after('<p class="text-danger">Course Code is required</p>');
			} else {
				$("#ccode").closest('.form-group').removeClass('has-error');
				$("#ccode").closest('.form-group').addClass('has-success');				
			}
			

			if(tscore == "") {
				$("#tscore").closest('.form-group').addClass('has-error');
				$("#tscore").after('<p class="text-danger">Test score is required</p>');
			} else {
				$("#tscore").closest('.form-group').removeClass('has-error');
				$("#tscore").closest('.form-group').addClass('has-success');				
			}
			
			if(escore == "") {
				$("#escore").closest('.form-group').addClass('has-error');
				$("#escore").after('<p class="text-danger">Exam score is required</p>');
			} else {
				$("#escore").closest('.form-group').removeClass('has-error');
				$("#escore").closest('.form-group').addClass('has-success');				
			}
			
			if(semester == "") {
				$("#semester").closest('.form-group').addClass('has-error');
				$("#semester").after('<p class="text-danger">Semester is required</p>');
			} else {
				$("#semester").closest('.form-group').removeClass('has-error');
				$("#semester").closest('.form-group').addClass('has-success');				
			}
			
			if(level == "") {
				$("#level").closest('.form-group').addClass('has-error');
				$("#level").after('<p class="text-danger">Student level for this result is required</p>');
			} else {
				$("#level").closest('.form-group').removeClass('has-error');
				$("#level").closest('.form-group').addClass('has-success');				
			}

			
			if(session == "") {
				$("#session").closest('.form-group').addClass('has-error');
				$("#session").after('<p class="text-danger">School session is required</p>');
			} else {
				$("#session").closest('.form-group').removeClass('has-error');
				$("#session").closest('.form-group').addClass('has-success');				
			}


			
			if(sname && matric && ccode && tscore && escore && semester && level && session) {
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
							$("#createGradeForm")[0].reset();		

							// reload the datatables
							manageGradeTable.ajax.reload(null, false);
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

function removeGrade(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'grade/remove.php',
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
						manageGradeTable.ajax.reload(null, false);

						// close the modal
						$("#removeGradeModal").modal('hide');

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

function editGrade(id = null) {
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
			url: 'grade/getSelectedMember.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {
			
				$("#ematric").val(response.matric_no);
				$("#eccode").val(response.coursetitle);
				$("#etscore").val(response.test);
				$("#eescore").val(response.exam);
				$("#esemester").val(response.semester);
				$("#esession").val(response.session);


				// mmeber id 
				$(".editGradeModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');

				// here update the member data
				$("#updateGradeForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

					// validation
					var ematric = $("#ematric").val();
					var eccode = $("#eccode").val();
					var etscore = $("#etscore").val();
					var eescore = $("#eescore").val();
					var esemester = $("#esemester").val();
					var esession = $("#esession").val();
					
					
				if(ematric == "") {
				$("#ematric").closest('.form-group').addClass('has-error');
				$("#ematric").after('<p class="text-danger">Student Matric Number is required</p>');
			} else {
				$("#ematric").closest('.form-group').removeClass('has-error');
				$("#ematric").closest('.form-group').addClass('has-success');				
			}
			
			if(eccode == "") {
				$("#eccode").closest('.form-group').addClass('has-error');
				$("#eccode").after('<p class="text-danger">Course Code is required</p>');
			} else {
				$("#eccode").closest('.form-group').removeClass('has-error');
				$("#eccode").closest('.form-group').addClass('has-success');				
			}
			

			if(etscore == "") {
				$("#etscore").closest('.form-group').addClass('has-error');
				$("#etscore").after('<p class="text-danger">Test score is required</p>');
			} else {
				$("#etscore").closest('.form-group').removeClass('has-error');
				$("#etscore").closest('.form-group').addClass('has-success');				
			}
			
			if(eescore == "") {
				$("#eescore").closest('.form-group').addClass('has-error');
				$("#eescore").after('<p class="text-danger">Exam score is required</p>');
			} else {
				$("#eescore").closest('.form-group').removeClass('has-error');
				$("#eescore").closest('.form-group').addClass('has-success');				
			}
			
			if(esemester == "") {
				$("#esemester").closest('.form-group').addClass('has-error');
				$("#esemester").after('<p class="text-danger">Semester is required</p>');
			} else {
				$("#esemester").closest('.form-group').removeClass('has-error');
				$("#esemester").closest('.form-group').addClass('has-success');				
			}
			
			if(esession == "") {
				$("#esession").closest('.form-group').addClass('has-error');
				$("#esession").after('<p class="text-danger">School session is required</p>');
			} else {
				$("#esession").closest('.form-group').removeClass('has-error');
				$("#esession").closest('.form-group').addClass('has-success');				
			}


					if(ematric && eccode && etscore && eescore && esemester && esession) {
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
									manageGradeTable.ajax.reload(null, false);
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