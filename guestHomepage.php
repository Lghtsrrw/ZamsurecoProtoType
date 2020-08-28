<?php
  include('databaseConnection/databaseConnection.php');

  if (isLoggedIn()) {
      header('location: index.php');
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
    <link href="stylesheets/webStyle.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btnComplaint").click(function(){
          window.location.href = "complaintTicket.php";
        });
      });
    </script>
    <title>Welcome Guest</title>
  </head>

  <body>
    <div id="divLogout"style="text-align:right; clear:none;">
      <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
    </div>
    <div class="divGuest">
      <h1>Welcome Guest!</h1>
      <?php if (isset($_SESSION['success'])) : ?>
  			<div class="success" >
          <h3>
            <?php echo $_SESSION['success']; ?>  <br>
          </h3>
          <h5>
            <?php echo 'Email: ' . $_SESSION['user']['email']; ?> <br>
            <?php echo 'Contact: ' . $_SESSION['user']['Contact']; ?> <br>
            <?php echo 'ID: ' . $_SESSION['user']['UserID']; ?> <br>
            <?php echo "User Type: " . $_SESSION['user']['IDType']; ?>
          </h5>
        </div>
      <?php endif ?>

      <button id = "btnComplaint" style="width:auto;">Create a complaint Ticket</button>
    </div>

    <?php if(isset($_GET['submit'])) : ?>
    <div id="divSubmitMessage">
      <h4>TICKET SUBMITTED SUCCESSFULLY</h4>
      <p>Your tracking number is: <a></a><b><?php  echo $_GET['trackno']; ?></b></p>
    </div>
    <?php endif ?>

  </body>
</html>
