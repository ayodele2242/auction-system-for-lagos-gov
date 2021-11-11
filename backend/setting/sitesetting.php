<?php
include("../../includes/functions.php");
// Edit Website Settings
if (isset($_POST['submit']) && $_POST['submit'] == 'editSettings') {
    if($_POST['installUrl'] == "") {
        echo "w";
    }    
     else {
        $installUrl = $mysqli->real_escape_string($_POST['installUrl']);
        $localization = $mysqli->real_escape_string($_POST['localization']);
        $siteName = $mysqli->real_escape_string($_POST['siteName']);
        $schName = $mysqli->real_escape_string($_POST['schName']);
        $siteEmail = $mysqli->real_escape_string($_POST['siteEmail']);
        $phone = $mysqli->real_escape_string($_POST['phone']);
        $location = $mysqli->real_escape_string($_POST['location']);
        $addr = $mysqli->real_escape_string($_POST['address']);
        $allowRegistrations = $mysqli->real_escape_string($_POST['allowRegistrations']);
        $enableWeather = $mysqli->real_escape_string($_POST['enableWeather']);
        $enableCalendar = $mysqli->real_escape_string($_POST['enableCalendar']);
        $desc = $mysqli->real_escape_string($_POST['description']);
        $kword = $mysqli->real_escape_string($_POST['keywords']);
        $author = $mysqli->real_escape_string($_POST['author']);
        $fb = $mysqli->real_escape_string($_POST['facebook']);
        $tt = $mysqli->real_escape_string($_POST['twitter']);
        $yt = $mysqli->real_escape_string($_POST['youtube']);
        $inst = $mysqli->real_escape_string($_POST['instagram']);

        $stmt = $mysqli->prepare("UPDATE
                                    sitesettings
                                    SET
                                    installUrl = ?,
                                    localization = ?,
                                    siteName = ?,
                                    company_name = ?,
                                    siteEmail = ?,
                                    phone = ?,
                                    location = ?,
                                    address = ?,
                                    allowRegistrations = ?,
                                    enableWeather = ?,
                                    enableCalendar = ?,
                                    description = ?,
                                    keywords = ?,
                                    author = ?,
                                    facebook = ?,
                                    twitter = ?,
                                    youtube = ?,
                                    instagram = ?
                                    "
                                    
        );
        $stmt->bind_param('ssssssssssssssssss',
                            $installUrl,
                            $localization,
                            $siteName,
                            $schName,
                            $siteEmail,
                            $phone,
                            $location,
                            $addr,
                            $allowRegistrations,
                            $enableWeather,
                            $enableCalendar,
                            $desc,
                            $kword,
                            $author,
                            $fb,
                            $tt,
                            $yt,
                            $inst
        );
        $stmt->execute();
        //header("refresh:1;settings"); 
        echo "saved";
        
        $stmt->close();
    }
}


?>