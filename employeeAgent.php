<?php
include('databaseConnection/DatabaseQueries.php');

if (isLoggedIn()) {
    header('location: index.php');
}elseif (isGuest()) {
  header('location: guestHomepage.php');
}elseif (isSupport()) {
  header('location: dispatch.php');
} elseif(empty(isset($_SESSION['user']))){
  header('location: empLogin.php');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/employeeAgent.js"></script>
    <title>Employee</title>
  </head>

  <body style="background-color: #fcffed">
    <?php display_error(); ?>

    <div id="divTicket">
      <!-- logout Button -->
      <div class="clscontainer">
          <button id = "btnLogout" class="mainBtn" style="width:auto; float:right; background-color: red;">Log-out</button>
      </div>

      <div class="logoimg">
      <img src="img/logo.png" id="logotitle" style="height:200px; width:200px;">
      <h3>ZAMSURECO-I  AGENT</h3>
      </div>

      <!-- Show current user -->
      <?php if (isset($_SESSION['success'])) : ?>
    			<h5>
    				Logged in as:
    				<?php
    				echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname'] . "<br>";
            echo "User Type: " . $_SESSION['user']['IDType'] . "<br>";
    				?>
    			</h5>
      <?php
      unset($_SESSION['success']);
      endif
       ?>

      <!-- Button declaration -->
      <button id = "btnComplaints" class="mainBtn">Complaint List</button>
      <button id = "btnCrew" class="mainBtn">Update Complaint Status</button>
      <button id = "btnRegSupp" class="mainBtn">Register Support</button>
      <button id = "btnMngDspt" class="mainBtn">Dispatch Management</button>
      <br>
    </div>

    <!-- Display process success of failure -->

    <?php if(isset($_SESSION['savesupp'])) : ?>
    <div id="divSubmitMessage" style="margin-top: 20px">
      <h4>COMPLAINT RECEIVER UPDATED</h4>
    </div>
    <?php endif ?>

    <!-- modal section -->
    <!-- List of Active Complaint -->
    <div class="modal" id="divTbl" >
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <h3>Active Complaint</h3>
        <div class="" style="width:100%; clear: none">
          <input type="text" name="" placeholder="Search" value="" class="cSearch" id="inSearch" style="width:auto;">
          <button type="button" name="btnSearch" id="btnIDSearch" class="mainBtn" style="height:42px;">Search</button>
          <button type="button" id="btnDispatch" class="mainBtn" style="height:42px;" disabled>Dispatch</button>
        </div>

        <div class="tblAllData" style="overflow:auto">
          <div id="div4Table" >
            <table border="1" id="tblData">
              <tr>
                <th>Complaint No</th>
                <th>Nature of Complaint</th>
                <th>Description</th>
                <th>Region</th>
                <th>Province</th>
                <th>City/Mun</th>
                <th>Barangay</th>
              </tr>
              <?php fillComplaintTable(); ?>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Support Registration Modal  -->
    <div class="modal" id="divRegSupp">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px;">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <h1>Employee Registration Form</h1>
        <button id = "btnEmpList" class="mainBtn">Employee List</button>
        <form class="frmEmpReg" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <h5>Registration ID: <?php echo generateEmployeeID(); ?></h5>
          <b><label for="">First Name</label></b><br>
          <input type="text" name="txtFname" onkeyup="this.value = this.value.toUpperCase();"><br>
          <b><label for="">Middle Name</label></b><br>
          <input type="text" name="txtMname" onkeyup="this.value = this.value.toUpperCase();" maxlength="1"><br>
          <b><label for="">Last Name</label></b><br>
          <input type="text" name="txtLname" onkeyup="this.value = this.value.toUpperCase();">
          <b><label for="">Area</label></b><br>
          <input type="text" name="txtArea" onkeyup="this.value = this.value.toUpperCase();">
          <b><label for="">Department</label></b><br>
          <input type="text" name="txtDept" onkeyup="this.value = this.value.toUpperCase();" >
          <div class="divBtn" style="text-align: left;">
            <fieldset>
              <legend>Account</legend>
              <b><label for="">Username</label></b>
              <input type="text" name="txtEmpUsername" value="">
              <b><label for="">Password</label></b>
              <input type="password" name="txtEmpPass" value="1234" disabled>
            </fieldset>
          <button type="submit" name="btnSaveEmpSupp" class="mainBtn" style="width:100%">SAVE</button>
          </div>
        </form>
      </div>
    </div>

    <!-- List of Registered-Support Modal-->
    <div class="modal" id="divEmpList">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px;">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <h2>Employee List</h2>
        <div class="div4Table">
          <table id="tblEmpList">
            <tr>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Area</th>
              <th>Department</th>
            </tr>
            <?php fillEmpListTable(); ?>
          </table>
        </div>
      </div>
    </div>

    <!-- Dispatch Mananagement Dispatch modal -->
    <div class="modal" id="divMngCmplntDispt">
      <div class="modal-content animate"  id="divIdTblComplaint" style="overflow-x:auto; padding:10px">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <h2>Dispatch Management</h2>
        <form class="frmDsptMng" id="dsptMngForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

          <b><label for="">Complaint</label></b>
          <select value ="" class="_noc" id="_noc" name="ncomplaint" onchange="document.getElementById('hididComplaint').value=this.options[this.selectedIndex].text" style="width:100%; height:30px;font-size:15px; text-align: center">
            <option value = "-- complaint --" selected="selected" disabled>-- Complaint --</option>
            <?php fillNatureOfComplaint(); ?>
          </select><br><br>
          <input type="hidden" name="hidComplaintNo" id="hididComplaint" value="">

          <!-- Office -->
          <fieldset>
            <legend><b>Office</b></legend>
            <input type="Text" onclick="javascript:if($(this).val() !== '') {$(this).val('');} return false;" placeholder="Select Office" name="inputEmpOffice" list="officeList" id="idEmpOffice" value="" autocomplete="off">
            <datalist id="officeList">
                <option value="DLS">
                <option value="MSD">
                <option value="HR">
                <option value="CAD">
                <option value="TSD">
            </datalist>
          </fieldset>

          <!-- Employee Details -->
          <fieldset>
            <legend><b>Employee ID</b></legend>
            <input type="text" onclick="javascript:if($(this).val() !== '') {$(this).val('');} return false;"  list ='empIDList' placeholder="Search or select employee ID" name="txtEmpID" id="idEmpName" value="" autocomplete="off">
            <datalist id="empIDList">
              <?php retrieveEmployeeList(); ?>
            </datalist>
            <input type="text" name="txtEmpName" id="empname" value="" disabled><br><br>
          </fieldset>

          <!-- Area Coverage -->
          <fieldset>
              <legend><b>Area Coverage</b></legend>
            <!-- Municipal/City Coverage -->
            <fieldset>
              <legend>Municipal/City Coverage</legend>
              <input type="hidden" id = "AreaCovID" name="hidAreaCovNo" value="<?php echo generateAreaCoverageNo(); ?>">
              <input type="text" onclick="javascript:if($(this).val() !== '') {$(this).val('');} return false;" list ='empLocaCover' name="inputComplaint" id="idEmpLocat" value="" autocomplete="off">
              <datalist id="empLocaCover"></datalist>
              <table id="tblLocaCover">
                <th>Locations</th>
              </table>
              <input type="hidden" id="_municode" value="">
              <input type="hidden" name="rowAreaCov" id="countthis" value="0">
              <p style="font-size: 10px; color:#999;">Click on the rows to remove entry.</p>
            </fieldset>

            <!-- Barangay Coverage -->
            <fieldset id="idBrgyCov" style="display:none">
              <legend>Barangay Coverage</legend>
              <input type="hidden" id = "BrgyCovID" name="hidAreaCovNo" value="<?php echo generateAreaCoverageNo(); ?>">
              <input type="text" onclick="javascript:if($(this).val() !== '') {$(this).val('');} return false;" list ='hidABrgyCovNo' name="inputComplaint" id="idEmpBrgy" value="" autocomplete="off">
              <input type="hidden" name="hidABrgyCovNo" value="<?php generateAreaCoverageNo(); ?>">
              <datalist id="empBrgyCover"></datalist>
              <table id="tblBrgyCover">
                <th>Locations</th>
              </table>
              <p style="font-size: 10px; color:#999;">Click on the rows to remove entry.</p>
            </fieldset>
          </fieldset>

          <!-- Contacts Field -->
          <fieldset>
            <legend><b>Contact</b></legend>
            <input type="text" onkeypress="validate(event);" maxlength="11" name="inputEmpContact" id="idEmpContact" value="" autocomplete="off">
          </fieldset>

          <button type="submit" id="btnSubmitDsptMng" name="dsptMngBtn" class="mainBtn" >Update</button>
          <button type="button" id="btnShowComplaintRec" class="mainBtn" >Complaint Handlers</button>
        </form>
      </div>
    </div>

    <!-- Complaint Handlr Modal -->
    <div class="modal" id="divCmplntHndlr">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px;">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class="">
          <h2>Complaint Handler</h2>
            <div class="locationFloatLeft" style="width:50%; float: left;">
              <fieldset style="height:250px;overflow-x:auto;">
                <legend>Location</legend>
                <div class="div4Table">
                  <?php fillCmplntHndlrLocation(); ?>
                </div>
                  <input type="hidden" id="selectedRow" value="">
                  <input type="hidden" id="selectedOffice" value="">
              </fieldset>
            </div>
            <div class="locationFloatRight" style="width:50%; float: right;">
              <!-- Automated Entry in js file using AJAX -->
            </div>
            <div class="divEmpDetails" style="width:100%; overflow: auto;height:auto;;float: bottom;">
              <!-- Automated Entry in js file using AJAX -->
            </div>
        </div>
      </div>
    </div>

    <!-- Dispatch Modal -->
    <div class="modal" id="divDispatchModal">
      <div class="modal-content animate" id="divIdTblComplaint" style="padding:10px;">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class=""style="overflow-x:auto;">
          <h2>DISPATCH</h2>
          <div id="complaintDetails" class="divDispatchModalStyle" style="float:left" >
            <p><b>DETAILS</b></p>
            <label class="detailsLabels" >COMPLAINT NO</label><br>
            <input type="text" name="" id="cdNUM"  value="" disabled>
            <label class="detailsLabels" >NATURE OF COMPLAINT</label><br>
            <input type="text" name="" id="cdNOC"value="" disabled>
            <label class="detailsLabels" >CITY/MUNICIPAL</label><br>
            <input type="text" name="" id="cdLOC" value="" disabled>
            <label class="detailsLabels" >BARANGAY</label>
            <input type="text" name="" id="cdbrgy" value="" disabled>
          </div>
          <div id="complaintReceiver" class="divDispatchModalStyle" style="float:right;">
            <p><b>COMPLAINT RECEIVER</b></p>
            <!-- this div is autoGenerated in DatabaseQueries.php  -->
            <div id="divTblComplaineReceiver">
            </div>
            <input type="hidden" id="empSupp" value="">
            <!-- hidden Div -->
            <div id="setEmpSupp" style="display:block">
              <div class="clscontainer">
                <span  onclick="$('#setEmpSupp').css('display','none')" title="Close Modal" style="position: absolute;right: 1%;top: auto;color: #000;font-size: 35px;font-weight: bold;">&times;</span>
              </div>
              <fieldset>
                <legend><b>Set Employee Support</b></legend>
                <br>
                <label for="">Employee ID</label>
                <input type="text" list="setEmpIDList" id="setEmpID" value="">
                <datalist id="setEmpIDList">
                  <?php fillEmpSupportList(); ?>
                </datalist>
                <label for="">Employee Name</label>
                <input type="text" id="setEmpName" value="" disabled>

                <button type="button" id="btnSettingEmployeeSupport" class="mainBtn">Set Support</button>
              </fieldset>
            </div>
            <div style="position: relative; bottom:3px; left:2%;">
              <button type="button" id="btnSelectedEmp" class="mainBtn" disabled>Select</button>
              <button type="button" id="btnSet" class="mainBtn" >Set...</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
