<?php
    include("databaseConnection/databaseConnection.php");

    if(empty(isset($_SESSION['user']))){
        header('location: signin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/webStyle.css">
    <title>Create a Ticket</title>
</head>
<body>
    <div id="divLogout">
    <ul>
        <li class = "liBack">
            <a id="btnBack" href="signin.php">Back</a>
        </li>
        
        <li class = "liLogout">
            <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
        </li>
    </ul>
        
        
    </div>
    <div class = "ticket" style="width:30%; text-align:left; padding:10px; margin:auto;border: 3px solid rgb(0, 66, 128);">
        <h1>Create a Ticket</h1>
        <form action="complaintTicket.php" method="post">
            <label for="natureOfComplaint">Nature of Complaint </label><br>
            <select name="_noc" id="_noc" style="width:180px">
                <option value="brownout">Brown Out</option>
                <option value="blackout">Black Out</option>
                <option value="brokenLine">Broken Line</option>
                <option value="fallenPost">Fallen Post</option>
            </select><br><br>

            <label for="description">Description</label><br>
            <textarea style="resize:none;" name="description" id="styled" cols = "60"rows="3"></textarea><br><br><br>

            <label for="location">Location</label><br>
            <input type="text" id="location" name="location"><br>

            <label for="area_landmark"> Area Landmark</label><br>
            <input type="text" id="arealandmark" name="arealandmark"><br><br>

            <button>Submit Ticket</button>
        </form>
    </div>
</body>
</html>