var trainee_grade;

$(document).ready(function() {
   
   	trainee_grade = $("#trainee_grade").DataTable({
    "processing": true,   
		"ajax": "general/trainee-mark.php",
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
                     var printTitle = 'Trainees Grade Report Table';
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Trainees Grade Report Table';
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = 'Trainees Grade Report Table';
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Trainees Grade Report Table';
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Trainees Grade Report Table';
                   return printTitle
                   }
                },
              ],
              responsive: true,

              initComplete: function () {
                this.api().columns([3, 4, 5, 6]).every( function() {
                    var column = this;
                    var select = $('<select style="width:140px; margin-left:4px; padding:7px; background: rgb(3, 32, 34); border:none;"><option value="">' + $(column.header()).html() +  '</option></select>')
                        .appendTo($("#traindiv"))
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


