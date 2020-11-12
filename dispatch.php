<?php
require('databaseConnection/DatabaseQueries.php');

if (isLoggedIn()) {
    header('location: index.php');
}elseif (isGuest()) {
  header('location: guestHomepage.php');
}elseif (isAgent()) {
	header('location: employeeAgent.php');
} elseif(empty(isset($_SESSION['user']))){
  header('location: empLogin.php');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
    <link rel="stylesheet" type ="text/css" href="stylesheets/allStyle.css">
  	<script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/dispatch.js"></script>

    <title>Dispatch</title>
    <div style="width:100%; padding:10px">
    </div>
  </head>

  <body style="background-color: #fcffe8">

    <!-- Support Information -->
    <div id="divTicket">
      <!-- logout Button -->
      <div class="clscontainer">
          <button id = "btnLogout" class="mainBtn" style="width:auto; float:right; background-color: red;">Log-out</button>
      </div>


      <!-- display operation success and fail -->
      <?php if(isset($_SESSION['success'])): ?>
      <div id="divSubmitMessage">
        <h3><?php echo $_SESSION['success']; ?></h3>
      </div>
      <?php
      unset($_SESSION['success']);
      endif;
      ?>
      <!-- title -->
      <div class="logoimg">
      <img src="img/logo.png" id="logotitle" style="height:200px; width:200px;">
      <h3>ZAMSURECO-I SUPPORT</h3>
      </div>
      <br>
      <div class="" style="text-align: right; width:100%">
        <label>User ID: <b><?php echo $_SESSION['user']['EmpID']; ?></b></label><br>
        <label>Support Name: <b><?php echo $_SESSION['user']['Fname'] . ' '. $_SESSION['user']['Lname']; ?></b></label><br>
        <button type="button" class="mainBtn2" id="btnChangePass" style="padding:10px; background-color:green">Change Password</button>
      </div>
      <hr>
      <h3>Assigned Complaint</h3>

      <!-- List of Active Complaint -->
      <div id="tblAllData" style="overflow:auto; text-align: center">
        <?php fillAssignedComplaint($_SESSION['user']['EmpID']); ?>
      </div>

      <div style="text-align: right;">
        <button type="button" id="btnStatus" class="mainBtn2" name="button" disabled>Update Status</button>
      </div>
    </div>

    <!-- Modals -->
    <!-- Update-Status modal -->
    <div class="modal" id="divUpdateStatus">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px;">
        <!-- close this modal -->
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <!-- modal title -->
        <h1>Status</h1>
        <div class="" style="overflow:auto">
          <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="">Complanint No: </label><br>
            <input type="text" id="lblComplaintno" name="inSupportComplaintNo" value="" style="width:auto;" readonly>
            <input type="text" id="lblNatureofComplaint" value="" style="width:auto;" readonly>
            <br><br>
            <label for="">Status: </label><br>
            <input type="text" list="listStatus" onclick="javascript: $(this).val('');" id="lblStatus" name="inSupportStatus" value="" style="width:auto;" required>
            <datalist id="listStatus">
              <option value="" style="background-color: orange" value="Pending"></option>
              <option value="" style="background-color: orange" value="Scheduled"></option>
              <option value="" style="background-color: green" value="Resolved"></option>
            </datalist>
            <br><br>
            <label for="" style="display:inline-block;float:left;clear:left">Remarks: </label>
            <textarea  name="inSupportRemarks" maxlength="200" rows="8" required></textarea><br><br>
            <div class="" style="width:100%">
              <button type="submit" id = "btnUpdateStatus" name="btnUpdateStatus" class="mainBtn">Update Status</button>
              <!-- <button id = "btnResolve" style="color:white; background-color:red; float:right" class="mainBtn">Resolve</button> -->
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal" id="divChangePass">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; padding:10px;">
        <!-- close this modal -->
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <!-- modal title -->
        <div class="">
          <h1>Change password</h1>
          <hr>
            <input type="password" id="newpassword" name="newpassword" placeholder="New-Password">
            <input type="password" id="newrepeatedpassword" name="newrepeatedpassword" placeholder="Repeat-Password" value="">
            <input type="password" id="oldpassword" name="oldpassword" placeholder="Old-Password">
            <hr>
            <label for="" id='notif' style="color:red;"></label>
            <button type="button" id="btnUpdateAPass" name="UpdateSuppPassword" class="mainBtn" style="clear:left; display:inline-block">Save Password</button>
        </div>
      </div>
    </div>
  </body>
</html>
