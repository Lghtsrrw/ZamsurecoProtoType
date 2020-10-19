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
	<script src="js/index.js"></script>
	<title>Zamzureco-1</title>
</head>

<body>

  <div style="width:100%; text-align:right;">
  	<a href="index.php?logout='1'" style='color:red;'>Logout</a>
  </div>

	<?php if (isset($_SESSION['success'])) : ?>
	<div class="success" >
		<p>You are logged in as <b><?php echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname']; ?></b></p>
		<p>Account No.: <b><?php echo $_SESSION['user']['AcctNo']; ?></b></p>
	</div>
	<?php endif ?>

	<div class="btnContainer">
		<fieldset style="width:80%; margin:1% auto; ">
	  <div class="logoimg">
	  <img src="img/logo.png" id="logotitle">
	  <h3>ZAMSURECO-I MOBILE APPLICATION</h3>
	  </div>
	<div class="divBtn">
		<button id = "btnComplaints" class="mainBtn">Complaints</button>
		<!-- <button id = "btnInquireBill" class="mainBtn">Inquire Bill</button> -->
		<button id = "btnPayBills" class="mainBtn">Pay Bills</button>
		<button id = "btnEvents" class="mainBtn">Events</button>
		<button id = "btnPortal" class="mainBtn">Portal</button>
		<!-- Display Bills  -->
		<div id="divBillList" style="width: 100%; text-align: left">

			<?php if (ifBillExist($_SESSION['user']['AcctNo'])) : ?>

			<p><b>Bills</b></p>
			<table id='tblBill'>
			<tr>
			<th>Period Covered</th>
			<th>Kwh Used</th>
			<th>On Due</th>
			<th>Before Due</th>
			<th>After Due</th>
			<th>Due Date</th>
			</tr>
			<?php displayBill($_SESSION['user']['AcctNo']); ?>
			</table>

		<?php else : ?>
			<p><b>Bills</b></p>
			<p style="font-size: 12px; color: red"> No bills available to display for Account No.: <i><?php echo $_SESSION['user']['AcctNo']; ?></i> </p>
		<?php endif ?>
		</div>

		<!-- show submit Ticket and Tracking No -->
		<?php if(isset($_SESSION['submit'])) : ?>
		<div id="divSubmitMessage">
	 	  <p>Ticket successfully submitted.</p>
			<p style="font-size: 10px;">Tracking No: <b><?php echo $_SESSION['trackno']; ?></b></p>
		</div>

		<?php
			unset($_SESSION['submit']);
			unset($_SESSION['trackno']);
			endif
		?>
	</fieldset>
	</div>

	<div id="complaintModal" class="modal">
		<div class="modal-content animate">
			<div class="imgcontainer">
				<span class="close" title="Close Modal">&times;</span>
			</div>
			<div class="" style="padding: 20px">
				<h1>Complaint Record</h1>
				<button type="button" class="mainBtn" id="btnCreateComplaint">Create ticket</button>
				<table>
					<?php userComplaintTable($_SESSION['user']['username']); ?>
				</table>
			</div>
		</div>
	</div>

</body>
</html>
