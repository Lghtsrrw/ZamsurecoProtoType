<?php
include('databaseConnection/databaseConnection.php');

if (!empty(isset($_SESSION['user'])) && $_SESSION['user']['IDType']==='Guest') {
	header('location: guestHomepage.php');
}elseif(empty(isset($_SESSION['user']))){
	header('location: signin.php');
} 
?>  

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btnComplaints").click(function(){
          window.location.href = "complaintTicket.php";
        });
      });
    </script>
	<title>Zamzureco-1</title>
</head>
  <body>
	  <div style="width:100%; text-align:right;">
	  	<a href="index.php?logout='1'" style='color:red;'>Logout</a>
	  </div>
	
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="success" >
				<h3>
					<?php
						echo $_SESSION['success'] . ' as ';
						echo ucfirst($_SESSION['user']['username']);
					?>
				</h3>
			</div>
		<?php endif ?>
    <h1>User's Homepage</h1>

	<button id = "btnComplaints" style="width:auto;">Complaints</button>
	<button id = "btnInquireBill" style="width:auto;">Inquire Bill</button>
	<button id = "btnPayBills" style="width:auto;">Pay Bills</button>
	<button id = "btnEvents" style="width:auto;">Events</button>
	<button id = "btnPortal" style="width:auto;">Portal</button>
  </body>
</html>
