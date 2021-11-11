var Jobseekers;

$(document).ready(function() {
   
   	Jobseekers = $("#Jobseekers").DataTable({
    "processing": true,   
		"ajax": "general/jobseekers.php",
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
                     var printTitle = 'Jobseekers Table';
                   return printTitle
                   }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Jobseekers Table';
                   return printTitle
                   }
                },
				
                {
                  extend: "excel",
                  className: "btn-sm",
                 title: function(){
                     var printTitle = 'Jobseekers Table';
                   return printTitle
                   }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Jobseekers Table';
                   return printTitle
                   }
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  title: function(){
                     var printTitle = 'Jobseekers Table';
                   return printTitle
                   }
                },
              ],
              responsive: true

              
	});
	
	
});

