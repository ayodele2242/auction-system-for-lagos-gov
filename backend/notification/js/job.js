// global the manage student table 
var manageStuTable;

$(document).ready(function() {
	manageStuTable = $("#manageStuTable").DataTable({
		"ajax": "job/retrieve.php",
		"scrollY": 370,
        "scrollX": true,
		 "pageLength": 150,
		"order": []
	});

	$("#addStuModalBtn").on('click', function() {
		// reset the form 
		$("#createStuForm")[0].reset();
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// submit form
		$("#createStuForm").unbind('submit').bind('submit', function() {

			$(".text-danger").remove();

			var form = $(this);
			var formData = new FormData($(this)[0]);

			// validation
			var vtitle = $("#vtitle").val();
			//var etype = $("#etype").val();
			var qualification = $("#qualification").val();
			var course = $("#course").val();
			//var mpeople = $("#mpeople").val();
			var lwork = $("#lwork").val();
			var town = $("#town").val();
			var state = $("#state").val();
			//var wage = $("#wage").val();
			//var wdays = $("#wdays").val();
			//var duration = $("#duration").val();
			var cdate = $("#cdate").val();
			//var moa = $("#moa").val();
			var jobdes = $("#jobdes").val();
			
			if(vtitle == "") {
				$("#vtitle").closest('.form-group').addClass('has-error');
				$("#vtitle").after('<p class="text-danger">Please enter the vacancy title</p>');
			} else {
				$("#vtitle").closest('.form-group').removeClass('has-error');
				$("#vtitle").closest('.form-group').addClass('has-success');				
			}
			
						
			if(qualification == "") {
				$("#qualification").closest('.form-group').addClass('has-error');
				$("#qualification").after('<p class="text-danger">Select qualifiction for this job</p>');
			} else {
				$("#qualification").closest('.form-group').removeClass('has-error');
				$("#qualification").closest('.form-group').addClass('has-success');				
			}

			if(course == "") {
				$("#course").closest('.form-group').addClass('has-error');
				$("#course").after('<p class="text-danger">Course is required</p>');
			} else {
				$("#course").closest('.form-group').removeClass('has-error');
				$("#course").closest('.form-group').addClass('has-success');				
			}
		
			if(lwork == "") {
				$("#lwork").closest('.form-group').addClass('has-error');
				$("#lwork").after('<p class="text-danger">Work location is required</p>');
			} else {
				$("#lwork").closest('.form-group').removeClass('has-error');
				$("#lwork").closest('.form-group').addClass('has-success');				
			}
			
			
			if(town == "") {
				$("#town").closest('.form-group').addClass('has-error');
				$("#town").after('<p class="text-danger">Town is required </p>');
			} else {
				$("#town").closest('.form-group').removeClass('has-error');
				$("#town").closest('.form-group').addClass('has-success');				
			}
			
			if(state == "") {
				$("#state").closest('.form-group').addClass('has-error');
				$("#state").after('<p class="text-danger">State is required </p>');
			} else {
				$("#state").closest('.form-group').removeClass('has-error');
				$("#state").closest('.form-group').addClass('has-success');				
			}
			
			if(cdate == "") {
				$("#cdate").closest('.form-group').addClass('has-error');
				$("#cdate").after('<p class="text-danger">Vacancy closing date is required </p>');
			} else {
				$("#cdate").closest('.form-group').removeClass('has-error');
				$("#cdate").closest('.form-group').addClass('has-success');				
			}
			
			
			
			
			if(jobdes == "") {
				$("#jobdes").closest('.form-group').addClass('has-error');
				$("#jobdes").after('<p class="text-danger">Job description is required</p>');
			} else {
				$("#jobdes").closest('.form-group').removeClass('has-error');
				$("#jobdes").closest('.form-group').addClass('has-success');				
			}
			
		
			if(vtitle && qualification && course &&  lwork && town && state && cdate  && jobdes) {
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
							$("#createStuForm")[0].reset();		

							// reload the datatables
							manageStuTable.ajax.reload(null, false);
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

function removeStu(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'job/remove.php',
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
						manageStuTable.ajax.reload(null, false);

						// close the modal
						$("#removeStuModal").modal('hide');

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

function editStu(id = null) {
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
			url: 'job/getSelectedMember.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {
		
			$("#evtitle").val(response.jtitle);
			$("#eetype").val(response.etype);
			$("#equalification").val(response.qualification);
			$("#ecourse").val(response.course);
			$("#empeople").val(response.mpost);
		    $("#elwork").val(response.lwork);
			$("#etown").val(response.town);
			$("#estate").val(response.states);
			$("#ewage").val(response.wages);
			$("#ewdays").val(response.wdays);
			$("#eduration").val(response.duration);
			$("#ecdate").val(response.closing);
			$("#emoa").val(response.method_of_application);
			$("#ejobdes").val(response.jdiscrib);



				// mmeber id 
				$(".editStuModal").append('<input type="hidden" etype="member_id" id="member_id" value="'+response.id+'"/>');

				// here update the member data
				$("#updateStuForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

			var evtitle = $("#evtitle").val();
			var eetype = $("#eetype").val();
			var equalification = $("#equalification").val();
			var ecourse = $("#ecourse").val();
			var empeople = $("#empeople").val();
			var elwork = $("#elwork").val();
			var etown = $("#etown").val();
			var estate = $("#estate").val();
			var ewage = $("#ewage").val();
			var ewdays = $("#ewdays").val();
			var eduration = $("#eduration").val();
			var ecdate = $("#ecdate").val();
			var emoa = $("#emoa").val();
			var ejobdes = $("#ejobdes").val();
			
			if(evtitle == "") {
				$("#evtitle").closest('.form-group').addClass('has-error');
				$("#evtitle").after('<p class="text-danger">Please enter the vacancy title</p>');
			} else {
				$("#evtitle").closest('.form-group').removeClass('has-error');
				$("#evtitle").closest('.form-group').addClass('has-success');				
			}
			
						
			if(equalification == "") {
				$("#equalification").closest('.form-group').addClass('has-error');
				$("#equalification").after('<p class="text-danger">Select qualifiction for this job</p>');
			} else {
				$("#equalification").closest('.form-group').removeClass('has-error');
				$("#equalification").closest('.form-group').addClass('has-success');				
			}

			if(ecourse == "") {
				$("#ecourse").closest('.form-group').addClass('has-error');
				$("#ecourse").after('<p class="text-danger">Course is required</p>');
			} else {
				$("#ecourse").closest('.form-group').removeClass('has-error');
				$("#ecourse").closest('.form-group').addClass('has-success');				
			}
		
			if(elwork == "") {
				$("#elwork").closest('.form-group').addClass('has-error');
				$("#elwork").after('<p class="text-danger">Work location is required</p>');
			} else {
				$("#elwork").closest('.form-group').removeClass('has-error');
				$("#elwork").closest('.form-group').addClass('has-success');				
			}
			
			
			if(etown == "") {
				$("#etown").closest('.form-group').addClass('has-error');
				$("#etown").after('<p class="text-danger">Town is required </p>');
			} else {
				$("#etown").closest('.form-group').removeClass('has-error');
				$("#etown").closest('.form-group').addClass('has-success');				
			}
			
			if(estate == "") {
				$("#estate").closest('.form-group').addClass('has-error');
				$("#estate").after('<p class="text-danger">State is required </p>');
			} else {
				$("#estate").closest('.form-group').removeClass('has-error');
				$("#estate").closest('.form-group').addClass('has-success');				
			}
			
			if(ecdate == "") {
				$("#ecdate").closest('.form-group').addClass('has-error');
				$("#ecdate").after('<p class="text-danger">Vacancy closing date is required </p>');
			} else {
				$("#ecdate").closest('.form-group').removeClass('has-error');
				$("#ecdate").closest('.form-group').addClass('has-success');				
			}
			
			if(ejobdes == "") {
				$("#ejobdes").closest('.form-group').addClass('has-error');
				$("#ejobdes").after('<p class="text-danger">Job description is required</p>');
			} else {
				$("#ejobdes").closest('.form-group').removeClass('has-error');
				$("#ejobdes").closest('.form-group').addClass('has-success');				
			}


			if(evtitle && equalification && ecourse &&  elwork && etown && estate && ecdate &&  ejobdes) {
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
									manageStuTable.ajax.reload(null, false);
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