var alumni_users_invite;
$('document').ready(function()
{
    /* validation */
    $("#aregister").validate({
        rules:
        {
         
            firstname:{
           required: true
         },
      
         lastname:{
          required: true
        },
        grad_year:{
            required: true
          },
        
        gender:{
          required: true
        },
            password: {
                required: true,
                minlength: 8,
                maxlength: 15
            },
            cpassword: {
                required: true,
                equalTo: '#password'
            },
            user_email: {
                required: true,
                email: true
            },
        },
        messages:
        {
          
          
          firstname: "Please enter first name",
          lastname: "Please enter surname",
          grad_year: "Graduation Year is required",
          gender: "Select gender",
            password:{
                required: "Provide a Password",
                minlength: "Password Needs To Be Minimum of 8 Characters"
            },
            user_email: "Enter a Valid Email",
            cpassword:{
                required: "Retype Your Password",
                equalTo: "Password Mismatch! Retype"
            }
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
        var data = $("#aregister").serialize();

        $.ajax({

            type : 'POST',
            url  : 'user/register.php',
            data : data,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; Adding User');
            },
            success :  function(data)
            {
                if(data==1){

                    $("#error").fadeIn(1000, function(){


                        $("#error").html('<div class="alert alert-danger"> <span class="fa fa-warning"></span> &nbsp; Sorry, email address already exist!</div>');

                        $("#btn-submit").html('<span class="fa fa-user-plus"></span> &nbsp; Add User');

                    });

                }
                else if(data=="added")
                {
                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-success"> <span class="fa fa-check"></span> &nbsp; Added to database! </div>');
           
                           });
                    $("#btn-submit").html('<i class="fa fa-user-plus"></i> Add again');       
                    $('#aregister')[0].reset();
                }
                else{

                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-danger"><span class="fa fa-warning"></span> &nbsp; '+data+' !</div>');

                        $("#btn-submit").html('<span class="fa-user-plus"></span> &nbsp; Add User');

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});



$(document).ready(function() {
   
    alumni_users_invite = $("#alumni_users_invite").DataTable({
 "processing": true,   
     "ajax": "user/alumni_users_list.php",
    // "scrollY": 370,
 //"scrollX": true,
     "pageLength": 150,
 "order": [],
 
     dom: "Bfrtip",
           buttons: [
             {
               extend: "copy",
               className: "btn-sm",
               title: function(){
                  var printTitle = 'Alumni Users Table';
                return printTitle
                }
             },
             {
               extend: "csv",
               className: "btn-sm",
               title: function(){
                  var printTitle = 'Alumni Users Table';
                return printTitle
                }
             },
             
             {
               extend: "excel",
               className: "btn-sm",
              title: function(){
                  var printTitle = 'Alumni Users Table';
                return printTitle
                }
             },
             {
               extend: "pdf",
               className: "btn-sm",
               title: function(){
                  var printTitle = 'Alumni Users Table';
                return printTitle
                }
             },
             {
               extend: "print",
               className: "btn-sm",
               title: function(){
                  var printTitle = 'Alumni Users Table';
                return printTitle
                }
             },
           ],
           responsive: true,

           initComplete: function () {
             this.api().columns([6]).every( function() {
                 var column = this;
                 var select = $('<select style="width:140px; margin-left:4px; padding:7px; background: rgb(3, 32, 34); border:none;"><option value="">' + $(column.header()).html() +  '</option></select>')
                     .appendTo($("#alertms"))
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


function removeAUser(user_id = null) {
	if(user_id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'user/alumni_user_remove.php',
				type: 'post',
				data: {member_id : user_id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                        // close the modal
						$(".removem").modal('hide');    

						// refresh the table
						 $("#alumni_users_invite").DataTable().ajax.reload(null, false);

						

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