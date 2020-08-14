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
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/complaintTicket.js"></script>
    <title>Create a Ticket</title>
</head>
<body>
    <div id="divLogout">
    <ul>
        <li class = "liBack">
            <a id="btnBack">Back</a>
        </li>
        <li class = "liLogout">
            <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
        </li>
    </ul>
    </div>
    <div class = "divTicket" style="width:50%; padding:10px; margin:auto;border: 3px solid rgb(0, 66, 128);">
        <h1>Create a Ticket</h1>
        <form action="complaintTicket.php" method="post">
            <label for="natureOfComplaint">Nature of Complaint </label><br>
            <select name="_noc" id="_noc" style="width:100%">
                <option value="brownout">Brown Out</option>
                <option value="blackout">Black Out</option>
                <option value="brokenLine">Broken Line</option>
                <option value="fallenPost">Fallen Post</option>
            </select><br><br>

            <label for="description">Description</label><br>
            <textarea style="resize:none; clear: both;" name="description" id="styled" cols = "60"rows="3"></textarea><br><br><br>


            <div class="divAddressSelect">
              <div class="divRegion">
                <label for="lblRegion">Region</label><br>
                <select id = "ddRegion" name="nameregion" class="classregion" style="width:100%; height:30px; text-align:CENTER;">
                </select>
              </div><br>
              <div id = "divProvince" style = "display: none">
                  <label for="lblProvince">Province</label><br>
                  <select name="province" id="ddProvince" style="width:100%; height:30px; text-align:CENTER;">
                  </select>
              </div><br>
              <div id = "divMunicipal" style = "display:none">
                  <label for="lblMunicipal">Municipal</label><br>
                  <select name="municipal" id="ddMunicipal" style="width:100%; height:30px; text-align:CENTER;">
                  </select>
              </div><br>
              <div id = "divBrgy" style = "display:none">
                  <label for="lblBrgy">Barangay</label><br>
                  <select name="brgy" id="ddBrgy" style="width:100%; height:30px; text-align:CENTER;">
                  </select>
              </div><br>
              <div id="divPurok" style = "display:none">
                  <label for="area_landmark" required>Purok</label><br>
                  <input type="text" id="arealandmark" name="arealandmark">
              </div><br>
            </div>

            <button>Submit Ticket</button>
        </form>
    </div>
</body>
</html>
