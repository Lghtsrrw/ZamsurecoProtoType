<?php
include('databaseConnection/DatabaseQueries.php');
if (isLoggedIn()) {
    header('location: index.php');
}elseif (isGuest()) {
  header('location: guestHomepage.php');
} elseif(empty(isset($_SESSION['user']))){
  header('location: empLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/dispatch_management.js"></script>
    <title>Manage Dispatch</title>
  </head>
  <body style="background-color: #fcffed;">
    <div id="divTicket">
        <a id="btnBack" href="" onclick="javascript:history.go(-1)" style="float:right;">BACK</a>
      <h2>Dispatch Management</h2>
      <div id="divTicket">
        <form class="frmDsptMng" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <b><label for="">Complaint</label></b>
          <select value ="" class="_noc" id="_noc" name="ncomplaint" onchange="document.getElementById('idComplaint').value=this.options[this.selectedIndex].text" style="width:100%; height:30px;font-size:15px; text-align: center">
            <option value = "-- complaint --" selected="selected" disabled>-- Complaint --</option>
            <?php fillNatureOfComplaint(); ?>
          </select><br><br>
          <input type="hidden" name="inputComplaint" id="idComplaint" value="" />
          <b><label for="">Employee ID</label></b>
          <input type="text" name="inputComplaint" id="idEmpName" value="">

          <b><label for="">Employee Name</label></b><br>
          <input type="text" name="inputComplaint" id="fname"  disabled>
          <input type="text" name="inputComplaint" id="mname" disabled>
          <input type="text" name="inputComplaint" id="lname" disabled>

          <button type="submit" id = "btnUpdateDsptMng" class="mainBtn" >Update</button>
          <button type="submit" id = "btnRemoveDsptMng" class="mainBtn" >Remove</button>
        </form>
      </div>
    </div>

    <div id="divTicket" style="margin-top: 10px">

    </div>

  </body>
</html>
