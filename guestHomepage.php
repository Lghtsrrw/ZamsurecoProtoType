<?php
require('databaseConnection/databaseConnectivity.php');
require('databaseConnection/DatabaseQueries.php');

  if (isLoggedIn()) {
      header('location: index.php');
  }elseif (isAgent()) {
    header('location: employeeAgent.php');
  }elseif (isSupport()) {
    header('location: dispatch.php');
  } elseif(empty(isset($_SESSION['user']))){
    header('location: signin.php');
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="ico" href="/css/master.css">
    <link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btnComplaint").click(function(){
          window.location.href = "complaintTicket.php";
        });
        $('#btnLogout').on("click",function(){
          if (confirm("Are you sure you want to Log-out?") == true) {
              window.location.href = "index.php?logout='1'";
          }
        });
      });
    </script>
    <title>Welcome Guest</title>
  </head>

  <body style="background-color: #fcffe8">

    <!-- Main Body -->
    <div id="divTicket">
      <!-- logo and title -->
      <div class="logoimg">
      <img src="img/logo.png" id="logotitle" style="height:200px; width:200px;">
      <h3>ZAMSURECO-I GUEST</h3>
      </div>
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="success" >
          <h3><?php echo $_SESSION['success']; ?>  <br></h3>
          <h5>
            <?php echo 'Email: ' . $_SESSION['user']['email']; ?> <br>
            <?php echo 'Contact: ' . $_SESSION['user']['Contact']; ?> <br>
            <?php echo 'ID no: ' . $_SESSION['user']['UserID']; ?> <br>
            <?php echo "User Type: " . $_SESSION['user']['IDType']; ?>
            <p>Session end in 30min</p>
          </h5>
        </div>
    	<?php
        endif
      ?>
      <!-- Main Buttons -->
      <div class="divBtn">
        <button id = "btnComplaint" class="mainBtn" style="width:auto;">Create a complaint Ticket</button>
        <button id = "btnLogout" class="mainBtn" style="width:auto; background-color: red;">Log-out</button>
      </div>
    </div>


    <?php if(isset($_GET['submit'])) : ?>
    <div id="divSubmitMessage">
      <h4>TICKET SUBMITTED SUCCESSFULLY</h4>
      <p>Your tracking number is: <a></a><b><?php  echo $_GET['trackno']; ?></b></p>
    </div>
    <?php endif ?>

  </body>
</html>
