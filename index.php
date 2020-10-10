<?php
include('databaseConnection/DatabaseQueries.php');

if (isGuest()) {
	header('location: guestHomepage.php');
}elseif (isAgent()) {
	header('location: employeeAgent.php');
}elseif(empty(isset($_SESSION['user']))){
	header('location: signin.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
	<link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
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

	<h1>Homepage</h1>

	<?php if (isset($_SESSION['success'])) : ?>
	<div class="success" >
		<h5>
			Logged in as:
			<?php
			echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname'] . "<br>";
			echo "Email: " . $_SESSION['user']['email'] . "<br>";
			echo "ID: " . $_SESSION['user']['UserID'] . "<br>";
			echo "Contact: " . $_SESSION['user']['Contact'] . "<br>";
			echo "Account No. : " . $_SESSION['user']['AcctNo'] . "<br>";;
			?>
		</h5>
		<input type="hidden" name="_accountno" id="_idAcctNo" value="<?php echo $_SESSION['user']['AcctNo']; ?>">
	</div>
	<?php endif ?>


	<?php if (isset($_SESSION['user']['AcctNo'])) : ?>
		<div id="divBillList">
			<?php displayBill($_SESSION['user']['AcctNo']); ?>
		</div>
	<?php endif ?>

	<div class="divBtn">
		<button id = "btnComplaints" class="mainBtn">Complaints</button>
		<button id = "btnInquireBill" class="mainBtn">Inquire Bill</button>
		<button id = "btnPayBills" class="mainBtn">Pay Bills</button>
		<button id = "btnEvents" class="mainBtn">Events</button>
		<button id = "btnPortal" class="mainBtn">Portal</button>
	</div>


	<!-- show submit Ticket and Tracking No -->
	<?php if(isset($_GET['submit'])) : ?>
	<div id="divSubmitMessage">
 	  <p>Your tracking number is: <b><?php echo  $_GET['trackno']; ?></b> </p>
	</div>
	<?php endif ?>

</body>
</html>
