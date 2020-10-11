<?php
    include("databaseConnection/DatabaseQueries.php");
    if(empty(isset($_SESSION['user']))){
        header('location: signin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
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

    <div id = "divTicket">
      <div class="logoimg">
      <img src="img/logo.png" id="logotitle" style="height:150px; width:150px">
      <h2>COMPLAINT TICKET</h2>
      </div>
        <h5>Ticket No: <?php echo generateTicketID(); ?></h5>
        <?php display_error(); ?>
          <hr>
            <div class="divComplainantInfo" style="border:1px solid #d6b385;margin: 5%  ;">
              <h4 style="text-align:center; color: #3c393c">Update from this ticket will be sent to: </h4>
                <p style="text-align:center; color: #3c393c">
                  <?php
                  $_contact = (isset($_SESSION['user']['Contact']))? $_SESSION['user']['Contact']:"Empty";
                  $_email  = (isset($_SESSION['user']['email']))? $_SESSION['user']['email']:"Empty";
                    echo "Contact No: <i>" . $_contact . "</i><br>";
                    echo "Email: <i>" . $_email . "</i><br>";
                  ?>
                </p>
            </div>
          <hr>

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="natureOfComplaint"><b>Nature of Complaint </b></label><br>
            <select class="_noc" id="_noc" name="ncomplaint"onchange="document.getElementById('idComplaint').value=this.options[this.selectedIndex].text" style="width:100%; height:30px;font-size:15px; text-align: center">
              <option value="" selected="selected" disabled>-- Complaint --</option>
              <?php fillNatureOfComplaint(); ?>
            </select><br><br>
            <input type="hidden" name="inputComplaint" id="idComplaint" value="" />

            <div id="divDescription" style="display:none">
              <label for="description"><b>Remarks</b></label><br>
              <textarea id="descID" name="ndesc" maxlength="200" class="classDescription"></textarea><br><br>
            </div>

            <div class="divAddressSelect">
              <div id = "divRegion" style="display:none">
                <label for="lblRegion"><b>Region</b></label><br>
                <select id = "ddRegion" name="nameregion" class="classregion" onchange="document.getElementById('idRegion').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                <input type="hidden" name="inputRegion" id="idRegion" value="" />
              </div><br>
              <div id = "divProvince" style = "display: none">
                  <label for="lblProvince"><b>Province</b></label><br>
                  <select name="province" id="ddProvince" onchange="document.getElementById('idProvince').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                  <input type="hidden" name="inputProvince" id="idProvince" value="" />
              </div><br>
              <div id = "divMunicipal" style = "display:none">
                  <label for="lblMunicipal"><b>City/Municipal</b></label><br>
                  <select name="municipal" id="ddMunicipal" onchange="document.getElementById('idCityMun').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                  <input type="hidden" name="inputCityMun" id="idCityMun" value="" />
              </div><br>
              <div id = "divBrgy" style = "display:none">
                  <label for="lblBrgy"><b>Barangay</b></label><br>
                  <select name="brgy" id="ddBrgy" onchange="document.getElementById('idBrgy').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                    <input type="hidden" name="inputBrgy" id="idBrgy" value="" />
              </div><br>
              <div id = "divPurok" style = "display:none">
                  <label for="area_landmark" required><b>Purok or Area Landmarks</b></label><br>
                  <input type="text" id="ddPurok" name="purokname">
              </div><br>
            </div>

            <button type="submit" name="nTicketbtn" class="ticketbtn" id="ticketBtnId" style="display:none">Submit Ticket</button>

        </form>
    </div>

</body>
</html>
