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
<body style="background-color: #edf8ff">

    <div id="divLogout" style="width:100%">
      <h5>
        <a id="btnBack" href="#">BACK</a>
        <a id="btnLogout" href="index.php?logout='1'" style='color:red; float:right'>LOGOUT</a>
      </h5>
    </div>

    <div class = "divTicket">
        <h1>CREATING TICKET</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <hr>
            <div class="divComplainantInfo" style="border:1px solid #d6b385;margin: 5%  ;">
              <h4 style="text-align:center; color: #3c393c">Update from this ticket will be sent to :</h4>
                <p style="text-align:center; color: #3c393c">
                  <?php
                  $_contact = (isset($_SESSION['user']['Contact']))? $_SESSION['user']['Contact']:"Empty";
                  $_email  = (isset($_SESSION['user']['email']))? $_SESSION['user']['email']:"Empty";
                    echo "Contact No: <i>" . $_contact . "</i><br>";
                    echo "Email: <i>" .$_email . "</i><br>";
                  ?>
                </p>

            </div>
          <hr>
            <h5>Ticket No: </h5>
            <label for="natureOfComplaint"><b>Nature of Complaint </b></label><br>
            <select name="_noc" id="_noc" style="width:100%">
              <option value="" selected="selected" disabled>-- Complaint --</option>
              <?php fillNatureOfComplaint(); ?>
            </select><br><br>
            <div class="divDescription">
              <label for="description"><b>Description</b></label><br>
              <textarea id="descID" class="classDescription"></textarea><br><br>
            </div>
            <div class="divAddressSelect">
              <div class="divRegion">
                <label for="lblRegion"><b>Region</b></label><br>
                <select id = "ddRegion" name="nameregion" class="classregion" style="width:100%; height:30px; text-align:left;"></select>
              </div><br>
              <div id = "divProvince" style = "display: none">
                  <label for="lblProvince"><b>Province</b></label><br>
                  <select name="province" id="ddProvince" style="width:100%; height:30px; text-align:left;"></select>
              </div><br>
              <div id = "divMunicipal" style = "display:none">
                  <label for="lblMunicipal"><b>City/Municipal</b></label><br>
                  <select name="municipal" id="ddMunicipal" style="width:100%; height:30px; text-align:left;">
                  </select>
              </div><br>
              <div id = "divBrgy" style = "display:none">
                  <label for="lblBrgy"><b>Barangay</b></label><br>
                  <select name="brgy" id="ddBrgy" style="width:100%; height:30px; text-align:left;"></select>
              </div><br>
              <div id="divPurok" style = "display:none">
                  <label for="area_landmark" required><b>Purok</b></label><br>
                  <input type="text" id="arealandmark" name="arealandmark">
              </div><br>
            </div>

            <button type="submit" class="ticketbtn" id="ticketBtnId">Submit Ticket</button>
        </form>
    </div>
</body>
</html>
