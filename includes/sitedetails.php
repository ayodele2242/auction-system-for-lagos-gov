<?php
		
		include('config/configs.php');
		
		
		
		// Get Settings Data
		$setSql = "SELECT * FROM sitesettings";
		$setRes = mysqli_query($mysqli, $setSql) or die('site setting failed'.mysqli_error());
		$set = mysqli_fetch_array($setRes);
		
		
	
	?>