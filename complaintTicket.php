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
    <title>Create a Ticket</title>
</head>
<body>
    <div id="divLogout"style="text-align:right;">
      <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
    </div>
    <div style="width:50%; text-align:center; padding:10px; margin:auto; border: 3px solid green;">
        <h1>Create a Ticket</h1>
        <form action="complaintTicket.php" method="post">
            <label for="description">Description</label><br>
            <textarea style="resize:none;" name="description" id="description" cols="20" rows="5"></textarea><br><br>

            <label for="location">Location</label><br>
            <input type="text" id="location" name="location"><br><br>

            <label for="natureOfComplaint">Nature of Complaint </label><br>
            <select name="_noc" id="_noc" style="width:180px">
                <option value="brownout">Brown Out</option>
                <option value="blackout">Black Out</option>
                <option value="brokenLine">Broken Line</option>
                <option value="fallenPost">Fallen Post</option>
            </select>
        </form>
    </div>
</body>
</html>