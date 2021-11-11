<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php');

?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>Notifications </span></h1>         
            </div>



<section class="my-5" >
<div class="removeMessages"></div>
<table id="notify" class="table table-striped">
<thead>
<tr>
<th>#ID</th>
<th>Message Owner</th>
<th>Department</th>
<th>Email</th>
<th>Phone</th>
<th>Message</th>
<th>Time</th>
<th>Action</th>
</tr>
</thead>
</table>
</section>

               

        </div>



        <!-- remove modal -->
 <div class="modal fade " tabindex="-1" role="dialog" id="classModal">
	  <div class="modal-dialog " role="document">
	    <div class="modal-content modal-col-red">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span> Deleting Notification</h4>
	      </div>
	      <div class="modal-body">
	        <p>Do you really want to delete this?</p>
	      </div>
	      <div class="modal-footer">
	        <!--<button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>-->
	        <button type="button" class="btn btn-danger btn-md" id="removeClassBtn"><span class="glyphicon glyphicon-trash"></span> Delete</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- /remove modal -->

     
     <script src="js/notification.js"></script>
<?php include('footer.php'); ?>    

   