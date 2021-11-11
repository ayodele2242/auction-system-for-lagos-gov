<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php'); ?>
<?php
ob_start();

$look_for_category = "SELECT * FROM product_category";
$view_category = mysqli_query($mysqli,$look_for_category) or die("Some error has been occured! .".mysqli_error($mysqli));
	//$got_categories = mysqli_fetch_assoc($view_category);


	if(isset($_POST['cattoedit'])){
		$categoryToEdit = $_POST['categoryToEdit'];
		$catname = $_POST['catname'];

		$edit_this_category = "UPDATE product_category SET name = '$categoryToEdit' WHERE category_Id = '$catname'";
		$edited_this_category = mysqli_query($mysqli,$edit_this_category) or die("Category cannot be added.".mysqli_error($mysqli));
		$message = 'Successfully edited the category with the name "'.$categoryToEdit.'".';
		
	}
	
	if(isset($_POST['deleteCat'])){
		$idToDelete = $_POST['idToDelete'];
		$deletecat = "DELETE FROM product_category WHERE category_Id = '$idToDelete'";
		$deleted_category = mysqli_query($mysqli,$deletecat) or die("Some error has been occured! .".mysqli_error($mysqli));
		$message = 'Category has been deleted';
	}
	if(isset($_POST['addCategory'])){
		$catToAdd = $_POST['categoryToAdd'];
		
		$check_for_category = "SELECT * FROM product_category WHERE name = '$catToAdd'";
		$checked_category = mysqli_query($mysqli,$check_for_category) or die("Some error has been occured! .".mysqli_error($mysqli));
		$che_categories = mysqli_fetch_assoc($checked_category);
		
		if($che_categories['name'] == $catToAdd){
			$message = 'Category with this "'.$catToAdd.'" name already exists in the database.'; 
		}
		else{
			$add_this_category = "INSERT INTO product_category (name) VALUES ('$catToAdd')";
			$added_this_category = mysqli_query($mysqli,$add_this_category) or die("Category cannot be added.".mysqli_error($mysqli));
			$message = 'Successfully Added the category with the name "'.$catToAdd.'".';
		}
		
	}

?>  
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h2><span>Categories</span></h2>         
            </div>


<?php
		if(isset($message)){ echo '<div class="alert alert-primary" role="alert">
		  <strong>Note: </strong>
			' .$message. '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
  </button></div>'; }
?>

<div class="clearfix">
<div class="col-md-12 mb-2">
	<div class="mt-2 border p-3">
		<div class="form-group">
		<form method="POST">
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control mb-2" id="exampleFormControlInput1" name="categoryToAdd" placeholder="Category" required>
						
                    </div>
                    <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm my-2 my-sm-0 mt-3" name="addCategory" type="submit"><span class="mr-sm-2"><i class="fa fa-plus-circle mr-sm-2 fa-lg"></i>Add</span></button>
        </div>
				</div>
		</form>
		</div>
	</div>
	
	<div class="mt-2 border p-3">
		<div class="form-group">
		<h3 class="font-weight-light text-success">All Categories</h3><hr/>
		<form method="POST">
				<div class="row">
					<div class="col-md-6">
						<table class="table table-striped">
						 <!-- <thead>
							<tr>
							  <th scope="col">Sr. no.</th>
							  <th scope="col">Category</th>
							  <th scope="col">Edit</th>
							  <th scope="col">Delete</th>
							</tr>
						  </thead>-->
						  <tbody>
						  <?php
						  $count = 1;
						  while($got_cat = mysqli_fetch_array($view_category)){ ?>
							<tr>
							  <td scope="row"><?php echo $count; ?></td>
							  <td>
								<form method="POST">
									<input type="hidden" name="catname" value="<?php echo $got_cat['category_Id']?>"/>
									<input type="text" class="form-control mb-2" id="exampleFormControlInput1" name="categoryToEdit" value="<?php echo $got_cat['name']?>" required>
								
								</td>
								<td><button class="btn btn-primary btn-sm" type="submit" name="cattoedit"><i class="fa fa-edit mr-sm-2 fa-lg"></i>Update</button></td>
								</form>
								<form method="POST">
								<input type="hidden" value="<?php echo $got_cat['category_Id']?>" name="idToDelete"/>
								<td><button class="btn btn-danger btn-sm" type="submit" name="deleteCat"><i class="fa fa-trash mr-sm-2 fa-lg"></i>Delete</button></td>
								</form>
							</tr>
						  <?php
							$count = $count + 1; 
						  }
						  ?>
						  </tbody>
						</table>
					</div>
				</div>
		</form>
		</div>
	</div>
</div>		

</div>

        

        </div>


<?php include('footer.php'); ?>    

   