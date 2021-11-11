var auctions;

$(document).ready(function() {
   
   	auctions = $("#auctions").DataTable({
    "processing": true,   
		"ajax": "allactions/retrieve.php",
    "scrollX": true,
		"pageLength": 150,
    "order": [],
    
        dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'auctions';
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'auctions';
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = 'auctions';
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'auctions';
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'auctions';
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
    $('input').attr("placeholder", "Search");
    $('input').removeClass('form-control-sm');
    });
    $('.dataTables_length').addClass('d-flex flex-row');
    $('.dataTables_filter').addClass('md-form');
    $('select').addClass('mdb-select');
    $('.mdb-select').material_select();
    $('.mdb-select').removeClass('form-control form-control-sm');
    $('.dataTables_filter').find('label').remove();
	
});





function selectAll(source) {
		checkboxes = document.getElementsByName('mailcheckbox[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}