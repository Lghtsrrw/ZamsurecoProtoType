<?php
require_once "../databaseConnection/DatabaseQueries.php";

// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error';
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif','ico'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
            
            $acctNo = $_SESSION['user']['AcctNo'];
        
            // Insert image content into database 
            $insert = $db->query("INSERT into receiptimage (receiptimage, uploaded,acctno,duedate) VALUES ('$imgContent', NOW(), $acctNo, NOW())"); 
            if($insert){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }

        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        }
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
    
    // Display status message
    // $_SESSION['message'] = $statusMsg;
    // if(isset($_SESSION['users'])){
    // }

    header( "Location: bills_history.php?message=$statusMsg" );
}   
?>