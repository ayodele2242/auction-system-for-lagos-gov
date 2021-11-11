<?php 
include('../includes/functions.php'); 
if(!isset($_SESSION['id'])){
    header('Location: ../join-ojobs?Sign In details required');
}else{
$id = $_SESSION['id'];
$user = mysqli_query($mysqli, "select * from jobseeker where id='$id' ");
$detail = mysqli_fetch_assoc($user);


//Check if school is empty in uploads table and update it
$sch = mysqli_query($mysqli, "select schools from education where fid = '$id'");
$gsch = mysqli_fetch_assoc($sch);
$schm = $gsch['schools'];
//check if school is empty in uploads
$usch = mysqli_query($mysqli,"select sch from uploads where fid = '$id' and category = 'education'");
$gus = mysqli_fetch_assoc($usch);
$f = $gus['sch'];
if($f == ''){
  mysqli_query($mysqli,"update uploads set sch='$schm' where fid = '$id' and category = 'education'");
}

//For profession update
$pch = mysqli_query($mysqli, "select school from professional where fid = '$id'");
$psch = mysqli_fetch_assoc($pch);
$spr = $psch['school'];
//check if school is empty in uploads
$prsch = mysqli_query($mysqli,"select sch from uploads where fid = '$id' and category = 'profession'");
$pgus = mysqli_fetch_assoc($prsch);
$pr = $pgus['sch'];
if($pr == ''){
  mysqli_query($mysqli,"update uploads set sch='$spr' where fid = '$id' and category = 'profession'");
}

//For award update
$ais = mysqli_query($mysqli, "select award_institution from award where fid = '$id'");
$aw = mysqli_fetch_assoc($ais);
$a = $aw['award_institution'];
//check if school is empty in uploads
$arsch = mysqli_query($mysqli,"select sch from uploads where fid = '$id' and category = 'award'");
$agus = mysqli_fetch_assoc($arsch);
$award = $agus['sch'];
if($award == ''){
 mysqli_query($mysqli,"update uploads set sch='$a' where fid = '$id' and category = 'award'");
}




//User details
$userFullName = $detail['titles'] .' '. $detail['sname'] .' '. $detail['mname'] .' '. $detail['fname'];
$email = $detail['mails'];

//cover letter
$cover_letter = mysqli_query($mysqli, "select * from cover_letter where fid='$id' ");
$cover = mysqli_fetch_assoc($cover_letter);

//Skills
$s = mysqli_query($mysqli, "select * from skills where fid='$id' ");
$skill = mysqli_fetch_assoc($s);




//Log out
if(isset($_GET['logout'])){
    unset($_SESSION['id']);
    if(session_destroy())
    {
    header("Location: ../join-ojobs");
    }
    
    }



    if (isset($_POST['submit']) && $_POST['submit'] == 'editProfile') {

        $id = $_POST['id'];
        $password = $_POST['old_password'];
        $newpassword = $_POST['new_password'];
        $confirmnewpassword = $_POST['con_newpassword'];

        // match user id with the id in the database
        $sql = "SELECT pwd FROM jobseeker WHERE id = '$id'";

        $get = mysqli_query($mysqli, $sql);
        $pw = mysqli_fetch_assoc($get);

        if(empty($_POST['old_password'])){
            $msgBox = alertBox( "Please type your current password", "<i class='fa fa-warning'></i>", "warning");
               
        }else if(empty($newpassword) || empty($confirmnewpassword)){
            $msgBox = alertBox( "Enter your new password and confirmed password", "<i class='fa fa-warning'></i>", "warning");
               
        }else if($pw["pwd"] != encryptIt($password)){
            $msgBox = alertBox("Current password is wrong. Try again. ", "<i class='fa fa-warning'></i>", "warning");   
        }
        else if($pw["pwd"] == encryptIt($newpassword)){
            $msgBox = alertBox( "Your new password is the same as the current one. Enter something else.", "<i class='fa fa-warning'></i>", "warning");
               
        }else if(strlen($newpassword) < 8){
            $msgBox = alertBox("Password must be 8 characters in length ", "<i class='fa fa-warning'></i>", "warning");
               
        }else{
            $ps =  encryptIt($newpassword);
            $sql = "UPDATE jobseeker SET pwd = '$ps' WHERE id = '$id'";
            $let = mysqli_query($mysqli, $sql);
         if($let){
            $msgBox = alertBox( "Password Changed Successfully!", "<i class='fa  fa-check-square'></i>", "success");
            }else{
                $msgBox = alertBox( "Password could not be updated", "<i class='fa fa-warning'></i>", "warning");
            }
        }

    }    

//Next of Kin details
    if (isset($_POST['submit']) && $_POST['submit'] == 'editNextofKin') {
if(empty($_POST['kin_sname']) || empty($_POST['kin_fname']) || empty($_POST['kinphone'])){
    $msgBox = alertBox( "Surname, First Name and Phone number required", "<i class='fa fa-warning'></i>", "warning");

}else{
    $sname = $mysqli->real_escape_string($_POST['kin_sname']);
    $fname = $mysqli->real_escape_string($_POST['kin_fname']);
    $tel = $mysqli->real_escape_string($_POST['kinphone']);
    $email = $mysqli->real_escape_string($_POST['kinmail']);
    $sql = "UPDATE jobseeker SET kin_sname = '$sname', kin_fname = '$fname', kinphone = '$tel', kinmail = '$email' WHERE id = '$id'";
    $let = mysqli_query($mysqli, $sql);
 if($let){
    $msgBox = alertBox( "Updated Successfully!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox( "Details could not be updated", "<i class='fa fa-warning'></i>", "warning");
    }

}

    }


 //Main profile
 if (isset($_POST['submit']) && $_POST['submit'] == 'editMyProfile') {  
   $sn =  $mysqli->real_escape_string($_POST['sname']);
   //$t = $mysqli->real_escape_string($_POST['titles']);
   $fn = $mysqli->real_escape_string($_POST['fname']);
   $mn = $mysqli->real_escape_string($_POST['mname']);
   $gen = $mysqli->real_escape_string($_POST['gender']);
   $ms = $mysqli->real_escape_string($_POST['mstatus']);
   $dob = $mysqli->real_escape_string($_POST['dob']);
   $md = $mysqli->real_escape_string($_POST['mdnane']);
   $lg = $mysqli->real_escape_string($_POST['localg']);
    $st = $mysqli->real_escape_string($_POST['statesng']);
    $ca = $mysqli->real_escape_string($_POST['caddy']);
    $p = $mysqli->real_escape_string($_POST['phone']);
    $re = $mysqli->real_escape_string($_POST['religion']);
    $oc = $mysqli->real_escape_string($_POST['occupation']);
    $pro = $mysqli->real_escape_string($_POST['profession']);

    $updateSQL = "UPDATE jobseeker SET sname='$sn', fname='$fn', mname='$mn', gender='$gen', 
    mstatus='$ms', dob='$dob', mdnane='$md', localg='$lg',stateng='$st',caddy='$ca', phone='$p', religion='$re', 
    occupation='$oc', profession='$pro' WHERE id='$id'";

$pro = mysqli_query($mysqli, $updateSQL);
if($pro){
    header("Location: profile?updated=Updated Successfully! ");
    $msgBox = alertBox( "Updated Successfully!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox( "Details could not be updated. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
    }

 }


//Education

if (isset($_POST['submit']) && $_POST['submit'] == 'addQualification') {  

    $sc = $mysqli->real_escape_string($_POST['schooln']);
    $qua = $mysqli->real_escape_string($_POST['qualification']);
    $c = $mysqli->real_escape_string($_POST['course']);
    $yr = $mysqli->real_escape_string($_POST['year']);
//Check if school and quaification already exist
$get = mysqli_query($mysqli, "select * from education where schools='$sc' and qualification = '$qua' and course = '$c' and years = '$yr' and fid='$id'");
if(mysqli_num_rows($get) > 0){
    $msgBox = alertBox( "Details already exist in the database. Add another one.", "<i class='fa fa-warning'></i>", "warning");
     
}else{
    $j = 0; //Variable for indexing uploaded image 
    
	$path = "../cert/"; //Declaring Path for uploaded images
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {//loop to get individual element from the array

        $validextensions = array("jpeg", "jpg", "png");  //Extensions which are allowed
        $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.) 
        $file_extension = end($ext); //store extensions in the variable
        
		$target_path =  md5(uniqid()) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
        //$n_array = md5(uniqid()) . "." . $ext[count($ext) - 1];
        $j = $j + 1;//increment the number of uploaded images according to the files in array       
      
	  if (($_FILES["file"]["size"][$i] < 3000000) //Approx. 3mb files can be uploaded.
                && in_array($file_extension, $validextensions)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $path. $target_path)) {//if file moved to uploads folder
               //insert into uploads table
               $images[] = $target_path;
                
            } else {//if file was not moved.
                $error = alertBox( "File(s) could not be moved. Please try again.", "<i class='fa fa-warning'></i>", "warning");
           }
        } else {//if file size and file type was incorrect.
            $error = alertBox( "***Invalid file Size or Type*** uploaded", "<i class='fa fa-warning'></i>", "warning");
               
        }
    }
if(!$error){
    $cat = "education";
    $all_images = implode(",",$images);
    mysqli_query($mysqli, "INSERT INTO uploads(fid,category,sch,img_name) VALUES('".$id."','".$cat."','".$sc."','".$all_images."')");

   //Second query, insert into education
   $insert = mysqli_query($mysqli, "INSERT INTO education (fid, schools, qualification, course, years) 
   VALUES ('$id','$sc','$qua', '$c', '$yr')");
                       
   if($insert){
     $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
     }else{
         $msgBox = alertBox( "Details could not be insert to the database. Please try again later.", "<i class='fa fa-warning'></i>", "warning");
     }
  
}
                

}


}


//Professions
    if (isset($_POST['submit']) && $_POST['submit'] == 'addProfession') {  
     
        $scn = $mysqli->real_escape_string($_POST['schoolname']);
        $c = $mysqli->real_escape_string($_POST['courses']);
        $yr = $mysqli->real_escape_string($_POST['year5']); 

        $get = mysqli_query($mysqli, "select * from professional where school='$scn' and course = '$c' and years = '$yr' and fid='$id'");
        if(mysqli_num_rows($get) > 0){
            $msgBox = alertBox( "Details already exist in the database. Add another one.", "<i class='fa fa-warning'></i>", "warning");
             
        }else{   
        
            $j = 0; //Variable for indexing uploaded image 
    
            $path = "../cert/"; //Declaring Path for uploaded images
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {//loop to get individual element from the array
        
                $validextensions = array("jpeg", "jpg", "png");  //Extensions which are allowed
                $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.) 
                $file_extension = end($ext); //store extensions in the variable
                
                $target_path =  md5(uniqid()) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
                //$n_array = md5(uniqid()) . "." . $ext[count($ext) - 1];
                $j = $j + 1;//increment the number of uploaded images according to the files in array       
              
              if (($_FILES["file"]["size"][$i] < 3000000) //Approx. 3mb files can be uploaded.
                        && in_array($file_extension, $validextensions)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $path. $target_path)) {//if file moved to uploads folder
                       //insert into uploads table
                       $images[] = $target_path;
                        
                    } else {//if file was not moved.
                        $error = alertBox( "File(s) could not be moved. Please try again.", "<i class='fa fa-warning'></i>", "warning");
                   }
                } else {//if file size and file type was incorrect.
                    $error = alertBox( "***Invalid file Size or Type*** uploaded", "<i class='fa fa-warning'></i>", "warning");
                       
                }
            }
            if(!$error){
	 $cat = "profession";
	 $all_images = implode(",",$images);
	mysqli_query($mysqli, "INSERT INTO uploads(fid,category,sch,img_name) VALUES('".$id."','".$cat."','".$scn."','".$all_images."')");
                

  $insert = mysqli_query($mysqli, "INSERT INTO professional (fid, school, course, years) VALUES ('$id','$scn','$c','$yr')");
  if($insert){
    $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox( "Details could not be insert to the database. Please try again later.", "<i class='fa fa-warning'></i>", "warning");
    } 
}     
        }                 

}


//Working Experience

if (isset($_POST['submit']) && $_POST['submit'] == 'addWork') {  
    
    $emp = $mysqli->real_escape_string($_POST['employer'] );
    $pos = $mysqli->real_escape_string($_POST['position'] );
    $jt = $mysqli->real_escape_string($_POST['job_type']);
    $sd = $mysqli->real_escape_string($_POST['sdate']);

    $insert = mysqli_query($mysqli, "INSERT INTO `work` (fid, employer, position,job_type, sdate) VALUES ('$id','$emp', '$pos', '$jt','$sd')");
    
    if($insert){
        $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        }                       
    
  }
  //Training
  if (isset($_POST['submit']) && $_POST['submit'] == 'addTraining') {  

    $t = $mysqli->real_escape_string($_POST['training']);
    $y = $mysqli->real_escape_string($_POST['year3']);

    $insert = mysqli_query($mysqli, "INSERT INTO training (fid, programme, years) VALUES ('$id', '$t', '$y')");
    
    if($insert){
        $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        } 

}
//Skils
if (isset($_POST['submit']) && $_POST['submit'] == 'addSkill') {  
    $s = $mysqli->real_escape_string($_POST['skill']);
$insert = mysqli_query($mysqli, "INSERT INTO skills (fid, skill) VALUES ('$id', '$s')");
if($insert){
    $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
    } 

}


//Association

if (isset($_POST['submit']) && $_POST['submit'] == 'addAssociate') {
    // Validation
    
        $taskStatus = $mysqli->real_escape_string($_POST['schoolname2']);
        $taskPercent = $mysqli->real_escape_string($_POST['courses2']);
        $taskStart = $mysqli->real_escape_string($_POST['year2']);
       

        $stmt = mysqli_query($mysqli, "INSERT INTO association (fid, name, position, years)
        VALUES ('$id','$taskStatus','$taskPercent','$taskStart' )");

       if($stmt){
    $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
    } 
    
}

if (isset($_POST['submit']) && $_POST['submit'] == 'addJob') {
    $job = $mysqli->real_escape_string($_POST['job_interest']);
    $stmt = mysqli_query($mysqli, "INSERT INTO desired_job (fid, job_interest) VALUES ('$id', '$job')");

    if($stmt){
        $msgBox = alertBox("Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        } 
                
}

//Award
if (isset($_POST['submit']) && $_POST['submit'] == 'addAward') {

    $an =  $mysqli->real_escape_string($_POST['award_name']);
    $ai =  $mysqli->real_escape_string($_POST['award_institution']);
    $yr=   $mysqli->real_escape_string($_POST['year']);

    $get = mysqli_query($mysqli, "select * from award where award_name ='$an' and award_institution = '$ai' and year = '$yr' and fid='$id'");
    if(mysqli_num_rows($get) > 0){
        $msgBox = alertBox( "Details already exist in the database. Add another one.", "<i class='fa fa-warning'></i>", "warning");
         
    }else{   

        $j = 0; //Variable for indexing uploaded image 
    
        $path = "../cert/"; //Declaring Path for uploaded images
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {//loop to get individual element from the array
    
            $validextensions = array("jpeg", "jpg", "png");  //Extensions which are allowed
            $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.) 
            $file_extension = end($ext); //store extensions in the variable
            
            $target_path =  md5(uniqid()) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
            //$n_array = md5(uniqid()) . "." . $ext[count($ext) - 1];
            $j = $j + 1;//increment the number of uploaded images according to the files in array       
          
          if (($_FILES["file"]["size"][$i] < 3000000) //Approx. 3mb files can be uploaded.
                    && in_array($file_extension, $validextensions)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $path. $target_path)) {//if file moved to uploads folder
                   //insert into uploads table
                   $images[] = $target_path;
                    
                } else {//if file was not moved.
                    $error = alertBox( "File(s) could not be moved. Please try again.", "<i class='fa fa-warning'></i>", "warning");
               }
            } else {//if file size and file type was incorrect.
                $error = alertBox( "***Invalid file Size or Type*** uploaded", "<i class='fa fa-warning'></i>", "warning");
                   
            }
        }
        if(!$error){
	 $cat = "award";
	 $all_images = implode(",",$images);
	mysqli_query($mysqli,"INSERT INTO uploads(fid,category,sch,img_name) VALUES('".$id."','".$cat."','".$ai."','".$all_images."')");

       $stmt = mysqli_query($mysqli, "INSERT INTO award (fid, award_name, award_institution,year) VALUES ('$id', '$an', '$ai','$yr')");

  if($stmt){
    $msgBox = alertBox( "Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
    }else{
        $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
    } 
}
}
}


if (isset($_POST['submit']) && $_POST['submit'] == 'addAgency') {
    $job = $mysqli->real_escape_string($_POST['agency']);
    $stmt = mysqli_query($mysqli, "INSERT INTO recruitment_agency (fid, agency) VALUES ('$id', '$job')");

    if($stmt){
        $msgBox = alertBox("Successfully Inserted!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox("Details could not be insert to the database. " . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        } 
                
}

if (isset($_POST['submit']) && $_POST['submit'] == 'addCover') {
    $c =  $mysqli->real_escape_string($_POST['letter']);
      
      $update = mysqli_query($mysqli, "INSERT INTO cover_letter(fid, letter) VALUES('$id', '$c')");
                           
      if($update){
        header("Location: education?Action=Inserted Successfully! ");
           $msgBox = alertBox( "Inserted Successfully!", "<i class='fa  fa-check-square'></i>", "success");
          }else{
              $msgBox = alertBox("Details could not be inserted. "  . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
          }
    }

if (isset($_POST['submit']) && $_POST['submit'] == 'upCover') {
  $c =  $mysqli->real_escape_string($_POST['letter']);
    
    $update = mysqli_query($mysqli, "UPDATE cover_letter SET letter = '$c' WHERE fid='$id'");
                         
    if($update){
        header("Location: education?updated=Updated Successfully! ");
        $msgBox = alertBox( "Updated Successfully!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox("Details could not be updated. "  . $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        }
  }



}//if sesssion checking ends


?>