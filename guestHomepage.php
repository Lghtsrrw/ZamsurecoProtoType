<?php
  include('databaseConnection/databaseConnection.php');

  if (!empty(isset($_SESSION['user'])) && $_SESSION['user']['IDType']==='User') {
      header('location: index.php');
  }elseif(empty(isset($_SESSION['user']))){
    header('location: signin.php');
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
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
    <div id="divLogout"style="text-align:right; clear: none;">
      <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
    </div>

    <h1>Welcome Guest!</h1>
    <?php if (isset($_SESSION['success'])) : ?>
			<div class="success" > <h3> <?php echo $_SESSION['success']; ?> </h3> </div>
    <?php endif ?>

    <button id = "btnComplaint" style="width:auto;">Create a complaint Ticket</button>
  </body>

</html>
