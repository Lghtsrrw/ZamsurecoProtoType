<?php
require('databaseConnection/DatabaseQueries.php');
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

<body style="background-color: #fcffe8">
  <div id="divLogout" style="width:100%">
    <h5>
      <a id="btnBack" href="#">BACK</a>
      <a id="btnLogout" href="index.php?logout='1'" style='color:red; float:right'>LOGOUT</a>
    </h5>
  </div>
  <div id = "divTicket">
    <div class="titleHeader" style="">
      <span class="headerText"><img src="img/logo.png" id="logotitle" style="float:left; height: 80px; width: 80px"></span>
      <span class="headerText"><b><label style="font-size:25px">Create ticket</label></b></span>
    </div>
      <?php display_error(); ?>
        <p style="color:#383838">Ticket No: <b><?php echo generateTicketID(); ?></b></p>
        <hr>
          <div class="divComplainantInfo" style="border:2px dashed #d6b385;padding: 2%">
            <p style="color: #3c393c">Update from this ticket will be sent to: </p>
              <p style="color: #3c393c">
                <?php
                $_contact = (isset($_SESSION['user']['Contact']))? $_SESSION['user']['Contact']:"No Record";
                $_email  = (isset($_SESSION['user']['email']))? $_SESSION['user']['email']:"No Record";
                  echo "Contact No: <i><b>" . $_contact . "</b></i><br>";
                  echo "Email Address: <i><b>" . $_email . "</b></i><br>";
                ?>
              </p>
          </div>
        <hr>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <label for="natureOfComplaint"><b>Nature of Complaint </b></label><br>

          <input
            type="text"
            name="inputComplaint"
            id="idComplaint"
            list="_noclist"
            onclick="javascript:if($(this).val() !== '') {$(this).val('');} return false;"
            placeholder="Choose complaints"
            value=""
            autocomplete="off"
          />
          <datalist id="_noclist">
            <?php fillNatureOfComplaint(); ?>
          </datalist>

          <div id="divDescription" style="display:none">
            <label for="description"><b>Remarks</b></label><br>
            <textarea id="descID" name="ndesc" maxlength="200" class="classDescription"></textarea><br><br>
          </div>

          <div id="divAddressSelect" style="display:none">
            <div id = "divRegion">
              <input
                type="text"
                name="inputRegion"
                id="idRegion"
                list="ddRegion"
                placeholder="Region"
                value="REGION IX (ZAMBOANGA PENINSULA)"
                autocomplete="off"
                readonly
              />
              <datalist id="ddRegion"></datalist>
            </div>
            <div id = "divProvince" >
                <input
                  type="text"
                  name="inputProvince"
                  id="idProvince"
                  list="ddProvince"
                  placeholder="Enter province"
                  value="ZAMBOANGA DEL SUR"
                  autocomplete="off"
                  readonly
                />
                <datalist id="ddProvince"></datalist>

            </div><br>
            <div id = "divMunicipal">
                <label for="lblMunicipal"><b>City / Municipal</b></label><br>
                <select name="municipal" id="ddMunicipal" onchange="document.getElementById('idCityMun').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                <input type="hidden" name="inputCityMun" id="idCityMun" value="" />
            </div><br>
            <div id = "divBrgy" style = "display:none">
                <label for="lblBrgy"><b>Barangay</b></label> <label for="lblBrgy" id="lblLoadingBgrgy" style="color:red"> Loading...</label> <br>
                <select name="brgy" id="ddBrgy" onchange="document.getElementById('idBrgy').value=this.options[this.selectedIndex].text" style="width:100%; height:30px; text-align:left;"></select>
                <input type="hidden" name="inputBrgy" id="idBrgy" value="" />
            </div><br>

          </div>
          <div id="divEmployeeSelect" style="display:none">
            <fieldset>
              <legend>Employee Detail</legend>
              <input type="text" id="inempname" onkeyup="this.value = this.value.toUpperCase();" placeholder="Employee Name" name="inputempname" value="" required>
            </fieldset>
          </div>
          <div id="divPurok" style = "display:none">
              <label for="area_landmark" id="lblPurok" required><b>Purok or Area Landmarks</b></label>
              <input type="text" id="ddPurok" name="purokname">
          </div><br>
          <button type="submit" name="nTicketbtn" class="mainBtn" id="ticketBtnId" style="display:none">Submit Ticket</button>
      </form>
  </div>

</body>
</html>
