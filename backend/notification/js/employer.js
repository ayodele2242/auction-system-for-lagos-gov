var sempTable;

$(document).ready(function() {
   	sempTable = $("#sempTable").DataTable({
    "ajax": "employers_info/retrieve.php",
    "processing": true,
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
                     var printTitle = "Employers Information";
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = "Employers Information";
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = "Employers Information";
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = "Employers Information";
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = "Employers Information";
                   return printTitle
                   }
                },
              ],
              responsive: true,

              initComplete: function () {
                this.api().columns([2, 4, 3]).every( function() {
                    var column = this;
                    var select = $('<select style="width:140px; margin-left:4px; padding:7px; background: rgb(3, 32, 34); border:none;"><option value="">' + $(column.header()).html() +  '</option></select>')
                        .appendTo($("#employs"))
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
     
                        column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
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
						sempTable.ajax.reload(null, false);

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