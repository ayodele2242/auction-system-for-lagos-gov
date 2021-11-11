<?php
	require_once('../../includes/functions.php');

	$t = date("Y-m-d H:i:s");
	$tv = time(); 
	$id = $_SESSION['id'];
	$fullname = $_SESSION['fname'] ;
	$uname = $_SESSION['uname'];

	$ConsignmentNo = $_POST['ConsignmentNo'];
	$inv = $_POST['Invoiceno'];

	$Shippername = $_POST['Shippername'];
	$Shipperphone = $_POST['Shipperphone'];
	$Shipperaddress = $_POST['Shipperaddress'];
	
	$Receivername = $_POST['Receivername'];
	$Receiverphone = $_POST['Receiverphone'];
	$Receiveraddress = $_POST['Receiveraddress'];
	$city = $_POST['Receivercity'];
	$country = $_POST['country'];
	$mode = $_POST['Mode'];
	
	
	$Shiptype = $_POST['Shiptype'];
	$file =  $_POST['Filetype'];
	$Weight = $_POST['Weight'];
	$Qnty = $_POST['Qnty'];
	$Bookingmode = $_POST['Bookingmode'];
	$Totalfreight = $_POST['Amount'];


	$percelname = $_POST['percel_name'];
	
	
	$Pickupdate = $_POST['Pickupdate'];
	$Comments = $_POST['Comments'];
	
	$status = 'In Transit';
	
	

    	$sql = "INSERT INTO tbl_courier (cons_no, ship_name, phone, city, country, s_add, rev_name, r_phone, r_add, 
		 type, weight, 	invice_no, qty, book_mode, freight, mode, product,product_type,
		 pick_date, status, comments, book_date )
			VALUES(
			'$ConsignmentNo', 
			'$Shippername',
			'$Shipperphone',
			'$city',
			'$country',
			 '$Shipperaddress', 
			 '$Receivername',
			 '$Receiverphone',
			 '$Receiveraddress', 
			 '$Shiptype',
			 '$Weight' , 
			 '$inv',
			 '$Qnty', 
			 '$Bookingmode',
			  '$Totalfreight',
			  '$mode',
			  '$percelname',
				'$file',
				'$Pickupdate',
						   
			   '$status', 
			   '$Comments', NOW())";	
			
	$done =	mysqli_query($mysqli, $sql);

	if($done){
		echo "added";

		mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fullname','Added $percelname with Consignment Code $ConsignmentNo', '$tv', '$id', '$t', '$tv')");
   
	}else{
		echo 'Error occured: '.$mysqli->error;
	}

    
?>