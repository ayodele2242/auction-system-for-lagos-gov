<!--Modal: modalCookie-->
<div class="modal fade top" id="modalCookie1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-frame modal-top modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body modal-danger">
        <div class="row d-flex justify-content-center align-items-center">

          <p class="pt-3 pr-2 lead">Hello <strong><?php echo ucwords($fullname).' </strong>'. $signOutQuip; ?></p>

          <a href="logout?action=logout" class="btn btn-danger btn-sm btn-icon-alt waves-effect"><?php echo $signOutBtn; ?>  <i class="fa fa-sign-out"></i></a>
				<button type="button" class="btn btn-warning btn-sm btn-icon waves-effect" data-dismiss="modal" ><?php echo $cancelBtn; ?></button>
			
        </div>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalCookie-->






<!-- SCRIPTS -->
<!-- JQuery -->
<!--<script type="text/javascript" src="../js2/jquery-3.3.1.min.js"></script>-->
<!-- Bootstrap tooltips -->
<!--<script type="text/javascript" src="../js2/popper.min.js"></script>-->
<!-- Bootstrap core JavaScript -->
<script src="../afiles/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../js2/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../js2/mdb.min.js"></script>
<script src="js/sitesetting.js"></script>
<script src="js/activities_logs.js"></script>
<script src="js/auction.js"></script>


<!--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>-->

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
   <!-- Jquery DataTable Plugin Js -->
<script src="../afiles/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../afiles/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../afiles/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<!-- Custom Js -->
<script src="../afiles/js/pages/tables/jquery-datatable.js"></script>
 




<script>
$(document).ready(function() {
$('.uTable').DataTable({
scrollY: '300px',
scrollCollapse: true,
});
$('.dataTables_wrapper').find('label').each(function() {
$(this).parent().append($(this).children());
});
$('.dataTables_filter').find('input').each(function() {
$('input').attr("placeholder", "");
$('input').removeClass('form-control-sm');
});
$('.dataTables_length').addClass('d-flex flex-row');
$('.dataTables_filter').addClass('md-form');
$('select').addClass('mdb-select');
$('.mdb-select').material_select();
$('.mdb-select').removeClass('form-control form-control-sm');
$('.dataTables_filter').find('label').remove();
});
</script>

<script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'itemName',
 ykeys:['startPrice', 'endTime', 'views'],
 labels:['Start Price', 'End Time', 'Number of Views'],
 hideHover:'auto',
 stacked:true
});
</script>

<script>
      $(function(){
        $('.editor')
          .on('froalaEditor.initialized', function (e, editor) {
            $('.editor').parents('form').on('submit', function () {
              console.log($('.editor').val());
              return false;
            })
          })
          .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
      });
  </script>
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script> 
  
	<script type="text/javascript">
			var btnCust = '<button type="button" class="btn btn-info btn-sm" title="Add picture tags" ' + 
		    'onclick="alert(\'<?php echo $set['installUrl']; ?>logo/<?php echo $set['companyLogo']; ?>\')">' +
		    '<i class="glyphicon glyphicon-tag"></i>' +
		    '</button>'; 
		$("#avatar-2").fileinput({
	    overwriteInitial: true,
	    maxFileSize: 30720,
	    showClose: false,
	    showCaption: false,
	    showBrowse: false,
	    browseOnZoneClick: true,
	    removeLabel: '',
	    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
	    removeTitle: 'Cancel or reset changes',
	    elErrorContainer: '#kv-avatar-errors-2',
	    msgErrorClass: 'alert alert-block alert-danger',
	    defaultPreviewContent: '<img src="<?php echo $set['installUrl']; ?>logo/<?php echo $set['companyLogo']; ?>" alt="Your Avatar" style="width:200px"><h6 class="text-muted">Click image to select</h6>',
	    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
	    allowedFileExtensions: ["jpg", "png", "gif", "avi", "mp3", "mp4", "wav","3gp","AAC","flv"]
		});

$('document').ready(function() {
    /* validation */
    $("#uploadImageForm").validate({
        rules:
        {
          
         name:{
           required: true
         },
         
         dept:{
           required: true
         },

         
        description:{
          required: true
        },
        
        date:{
          required: true
        },

        },
        messages:
        {
          name: "Worker name required",
          dept: "Worker department name required",
          description: "Enter description for this honour.",
          date: "Please select date",
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
		//var data = $("#uploadImageForm").serialize();
		
		//var form = $(this);
		//var formData = new FormData($(this)[0]);

		var form = $('#uploadImageForm')[0];    
        var data = new FormData(form);

        $.ajax({

			type : 'POST',
            url  : 'php_action/uploadImage.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			//async: false,
            success :  function(data)
            {

			if(data==1){

			$("#messages").fadeIn(1000, function(){
				$("#messages").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Unknown error occured !</div>');
				$("#btn-submit").html('<span class="fa fa-exclamation-triangle"></span> &nbsp; Failed');

			});

			}

               else if(data == "saved")
                {
                   	$("#messages").html('<div class="alert alert-success alert-dismissible " role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Saved Successfully.</div>');
					   $('input[type="text"]').val('');
					   $('textarea').val('');
            $(".fileinput-remove-button").click();
            $("#btn-submit").html('<span class="fa fa-check"></span> &nbsp; Save');
                }
                else{

			$("#messages").fadeIn(1000, function(){

				$("#messages").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

				$("#btn-submit").html('<span class="fa fa-exclamation-triangle"></span> &nbsp; Error!!');

			});

			}

            }
        });
        return false;
    }
    /* form submit */

});
    </script>
    
    <script type="text/javascript">
		$(document).ready(function()
		{
           $('.timer').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
                format: 'HH:mm A',
                twelvehour: true
			});


			$.material.init()
		});
		</script>  

<script>
$('.time').bootstrapMaterialDatePicker({ format : 'HH:mm', minDate : new Date() }); 
</script>    

<script>
$('.date').bootstrapMaterialDatePicker({ weekStart : 0, time: false }); 
$('.date2').bootstrapMaterialDatePicker({ weekStart : 0, time: false }); 
$('.date3').bootstrapMaterialDatePicker({ 
    format : 'MM/DD/YYYY hh:mm', 
    twelvehour: true,
    darktheme: true  
});
</script>

<script type="text/javascript">
$('.textbox').focus(function()
{
    /*to make this flexible, I'm storing the current width in an attribute*/
    $(this).attr('data-default', $(this).height());
    $(this).animate({ height: 250 }, 'slow');
}).blur(function()
{
    /* lookup the original width */
    var h = $(this).attr('data-default');
    $(this).animate({ height: h }, 'slow');
});
</script>


<script> 
    $(function() {
        $( "#tag" ).autocomplete({
        source: 'tags/autocomplete.php'
        });
    });
        
    var id = 0;
    $("#addTag").click(function(){
        if($("#tag").val() ) {
            
                id++;
            var li = document.createElement("li");
                li.className = "tag";
                li.setAttribute("id", id);
            
            var i = document.createElement("INPUT"); 
                i.setAttribute("name","multiTag[]");
                i.setAttribute("type","hidden");
                i.setAttribute("id", id);
            
            var tag = document.getElementById('tag').value;
             
            li.innerHTML = " " + tag + '  <button class=\"deleteTag btn-danger btn btn-sm\" id=\"'+id+'\">X</button>' 
            i.setAttribute("value", tag);    
            
            $("#tagList").append(li)
            $("#tagList").append(i)
            $('#tag').val('');  
        }});
  
    $("#tagList").on('click', 'button.deleteTag', function() {
    
        var idDiv = this.id;
        $("#"+idDiv).remove()
        $(":input[id='"+idDiv+"']").remove();

    });

    $("#tagList").on('click', 'button.deleteTagExsit', function() {
    
        var del_id = this.id;
        var toDel = del_id.replace('id_', '');
        $("#id_"+toDel).remove();
        $.ajax({
            type:'POST',
            url:'tags/delete_tag.php',
            data:'tags/delete_id='+toDel
        });
    
    });
    </script>

    

<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( 'ckeditor',
                {
                    filebrowserBrowseUrl :'<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : '<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '<?php echo $set['installUrl']; ?>afiles/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
                });
                


			//]]>
			</script>
<script type='text/javascript'>
	jQuery(document).ready( function() {
			jQuery('.notif').hide();
		jQuery('#number').click( function() {
			jQuery('.notif').toggle('slow');
		});
			
			jQuery(".notif").click( function() {
				var id = $(this).attr("id");
				
				jQuery.ajax({
					type: "POST",
					data: ({id: id}),
					url: "bidupdate.php",
					success: function(response) {
					jQuery(".id" + id).hide();
					jQuery("#num_result").fadeIn().html(response);
					}
				});
				
			})
			jQuery(document).ready( function() {
			jQuery('.showoff').hide();
		jQuery('.showme').click( function() {
			jQuery('.showoff').hide();
			jQuery(this).find('ul').toggle('slow');
		});

	});
		
	});
</script>

 

</body>

</html>