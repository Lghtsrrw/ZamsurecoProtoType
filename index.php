<?php
include('databaseConnection/DatabaseQueries.php');

if (isGuest()) {
	header('location: guestHomepage.php');
}elseif (isAgent()) {
	header('location: employeeAgent.php');
}elseif (isSupport()) {
  header('location: dispatch.php');
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

	<div class="btnContainer">
		<fieldset style="width:80%; margin:1% auto; ">

		<!-- logout Button -->
		<div class="clscontainer">
				<button id = "btnLogout" class="mainBtn" style="width:auto; float:right; background-color: red;">Log-out</button>
		</div>

	  <div class="logoimg">
	  <img src="img/logo.png" id="logotitle">
	  <h3>ZAMSURECO-I MOBILE APPLICATION</h3>
	  </div>

		<?php if (isset($_SESSION['success'])) : ?>
		<div class="success" >
			<p>You are logged in as <b><?php echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname']; ?></b></p>
			<p>Account No.: <b><?php echo $_SESSION['user']['AcctNo']; ?></b></p>
		</div>
		<?php endif ?>
		
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
			<!-- bill -->
			<?php displayBill($_SESSION['user']['AcctNo']); ?>
			</table>
			<?php else : ?>
				<p><b>Bills</b></p>
				<p style="font-size: 12px; color: red"> No bills available to display for Account No.: <i><?php echo $_SESSION['user']['AcctNo']; ?></i> </p>
			<?php endif ?>
		</div>

			<!-- condtional: submit Ticket and Tracking No -->
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
		</div>
	</fieldset>

<!-- begin modal -->
	<!-- Complaint Modal -->
	<div id="complaintModal" class="modal">
		<div class="modal-content animate">
			<div class="clscontainer">
				<span class="close" title="Close Modal">&times;</span>
			</div>
			<div class="container" style="padding: 20px">
				<div class="titleHeader">
		      <span class="headerText"><img src="img/logo.png" id="logotitle" style="float:left; height: 50px; width: 50px"></span>
		      <span class="headerText"><h1>Complaint List</h1></span>
		    </div>
				<div class="" style="width:100%">
				<button type="button" class="mainBtn" id="btnCreateComplaint">Create ticket</button>
					<button type="button" class="mainBtn" id="btnTrackComplaint">Track a Complaint</button>
				</div>
				<div class="div4Table">
					<table>
						<?php userComplaintTable($_SESSION['user']['username']); ?>
					</table>
				</div>

			</div>
		</div>
	</div>

	<!-- Track Modal -->
	<div id="trackModal" class="modal">
		<div class="modal-content animate">
			<div class="clscontainer">
				<span class="close" title="Close Modal">&times;</span>
			</div>
			<div class="container" style="overflow-x:auto; padding: 20px">
          <label for="uname"><b>Tracking No.:</b></label>
          <input type="text" placeholder="Enter Tracking No" id="inComplaintNo" name="uname" required>
          <button class="mainBtn" id="btntrack">Track</button>
			</div>
			<hr>
			<div class="divTrackRecords">

			</div>
		</div>
	</div>
</body>
</html>
