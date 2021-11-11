<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php'); ?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>Auctions </span></h1>         
            </div>



<section class="my-5" >
<table id="auctions" class="table table-striped table-responsive-md" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>#ID</th>
      <th>Item Image</th>
      <th>Evaluator Clearance</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Contact Number</th>
      <th>Email</th>
      <th>Address</th>
      <th>City</th>
      <th>Item Name</th>
      <th>Brand</th>
      <th>Start Price</th>
      <th>Reserve Price</th>
      <th>Number of View</th>
      <th>Auction Status</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>

  </table>


</section>

               

</div>
     


<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Evaluation Clearance</h4>  
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  


<?php include('footer.php'); ?>    

   