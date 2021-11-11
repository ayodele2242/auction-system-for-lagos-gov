var notify;

$(document).ready(function() {
   
   	notify = $("#notify").DataTable({
    "processing": true,   
	"ajax": "notification/retrieve.php",
    "scrollX": true,
	"pageLength": 150,
    "order": [],
    
        dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'notifys';
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'notifys';
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = 'notifys';
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'notifys';
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'notifys';
                   return printTitle
                   }
                },
              ],
              responsive: true,

              initComplete: function () {
                this.api().columns([3, 4, 7, 8]).every( function() {
                    var column = this;
                    var select = $('<select style="width:140px; margin-left:4px; padding:7px; background: rgb(3, 32, 34); border:none;"><option value="">' + $(column.header()).html() +  '</option></select>')
                        .appendTo($("#alertm"))
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
	
  $('.dataTables_wrapper').find('label').each(function() {
    $(this).parent().append($(this).children());
    });
    $('.dataTables_filter').find('input').each(function() {
    $('input').attr("placeholder", "");
    $('input').removeClass('form-control-lg');
    });
    $('.dataTables_length').addClass('d-flex flex-row');
    $('.dataTables_filter').addClass('lg-form');
    $('select').addClass('mdb-select');
    $('.mdb-select').material_select();
    $('.mdb-select').removeClass('form-control form-control-lg');
    $('.dataTables_filter').find('label').remove();
	
});

function removeClass(notificationId = null) {
	if(notificationId) {
		// click on remove button
		$("#removeClassBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'notification/remove.php',
				type: 'post',
				data: {member_id : notificationId},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');

						// refresh the table
						notify.ajax.reload(null, false);

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





function selectAll(source) {
		checkboxes = document.getElementsByName('mailcheckbox[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}