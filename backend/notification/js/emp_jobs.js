var jobsTable;

$(document).ready(function() {
    var printCounter = 0;
    // Append a caption to the table before the DataTables initialisation
   	jobsTable = $("#jobsTable").DataTable({
		"ajax": "employers_info/retrieve-jobs.php",
		"scrollY": 370,
        "scrollX": true,
		"pageLength": 150,
		"order": [],
        dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Employers Jobs Information';
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Employers Jobs Information';
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = 'Employers Jobs Information';
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Employers Jobs Information';
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Employers Jobs Information';
                   return printTitle
                   }
                },
              ],
              responsive: true
	});
	

	
});

function removeEmployer(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'employers_info/remove.php',
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
						jobsTable.ajax.reload(null, false);

						// close the modal
						$("#employerModal").modal('hide');

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