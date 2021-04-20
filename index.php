<?php
require('databaseConnection/DatabaseQueries.php');

if (isGuest()) {
	header('location: guestHomepage.php');
}elseif (isAgent()) {
	header('location: employeeAgent.php');
}elseif (isSupport()) {
  header('location: dispatch.php');
}elseif(empty(isset($_SESSION['user']))){
	header('location: userauthenticate.php');
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

		<!-- logout Button -->
		<div class="clscontainer">
			<button id = "btnLogout" class="mainBtn" style="width:auto; float:right; background-color: red; ">Log-out</button>
		</div>

		<div class="logoimg">
		<img src="img/logo.png" id="logotitle">
		<h3>ZAMSURECO-I ELECTRIC SERVICE</h3>
		</div>

		<?php if (isset($_SESSION['user']['IDType']) && $_SESSION['user']['IDType'] == 'User') : ?>
		<div class="success" >
			<p>You are logged in as <b><?php echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname']; ?></b></p>
			<p>Account No.: <b><?php echo $_SESSION['user']['AcctNo']; ?></b></p>
		</div>
		<?php elseif(isset($_SESSION['user']['IDType']) && $_SESSION['user']['IDType'] == 'Guest' ): ?>
			<div class="success" >
				<p>You are logged in as <b><?php echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname']; ?></b></p>
				<p>Account No.: <b><?php echo $_SESSION['user']['AcctNo']; ?></b></p>
			</div>
		<?php unset($_SESSION['success']); endif; ?>
		
		<div class="divBtn">
			<button id = "btnComplaints" class="mainBtn">Complaints</button>
			<button id = "btnInquiry" class="mainBtn">Inquiry</button>
			<button id = "btnEvents" class="mainBtn">Events</button>
			<button id = "btnPortal" class="mainBtn">Portal</button>
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

			<!-- Display Bills  -->

			<div id="divBillList" style="">
				<?php if (ifBillExist($_SESSION['user']['AcctNo'])) : ?>

				<p><b>Bills</b>
					<input type="text"  style="width: auto" id="txtbillamount" name="" value="" readonly>
					<button id = "btnPayBills" class="mainBtn" disabled>Pay Bills</button></p>

				<table id='tblBill'>
					<tr>
						<th>Period Covered</th>
						<th>Kwh Used</th>
						<th>On Due</th>
						<th>Before Due</th>
						<th>After Due</th>
						<th>Due Date</th>
						<th>Amount Paid</th>
					</tr>
					<?php displayBill($_SESSION['user']['AcctNo']); ?>
				</table>
				<?php else : ?>
					<p><b>Bills</b></p>
					<p style="font-size: 12px; color: red"> No bills available to display for Account No.: <i><?php echo $_SESSION['user']['AcctNo']; ?></i> </p>
				<?php endif ?>
			</div>

		</div>

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
				<button type="button" class="mainBtn" id="btnTrackComplaint" disabled>Track complaint</button>
				<input type="hidden" placeholder="Enter Tracking No" id="inComplaintNo" name="uname" required>
				</div>
				<div class="div4Table">
					<table id="tblComplaintList">
						<?php userComplaintTable($_SESSION['user']['username']); ?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Payment modal -->
	<div id="paymentModal" class="modal">
		<div class="modal-content animate">
			<div class="clscontainer">
				<span class="close" title="Close Modal">&times;</span>
			</div>
			<div class="container" style="padding: 20px">
				<div class="titleHeader">
		      <span class="headerText"><h1>Payment Method</h1></span>
		    </div>
					<div class="" style="width:100%">

						<form action="upload.php" method="post" enctype="multipart/form-data">
						    Upload your receipt:
						    <input type="file" name="file">
						    <!-- <input type="submit" name="submit" value="Upload"> -->
							<button type="submit" name="submit" class="mainBtn" id="btnPaymentMethod">Upload Receipt</button>
						</form>
					<!-- <button type="button" class="mainBtn" id="btnPaymentMethod">Upload Receipt</button> -->
				</div>

			</div>
		</div>
	</div>

	<!-- Inquiry modal -->
	<div id="inquiryModal" class="modal">
		<div class="modal-content animate">
			<div class="clscontainer">
				<span class="close" title="Close Modal">&times;</span>
			</div>
			<div class="container" style="padding: 20px">
				<div class="titleHeader">
		      <span class="headerText"><h1>Inquiries</h1></span>
		    </div>
					<div class="" style="width:100%">
						<h3>Display List of Inquiry Here.......</h3>
					<!-- <button type="button" class="mainBtn" id="btnPaymentMethod">Upload Receipt</button> -->
					<button id = "btnBills" class="mainBtn">Bills</button>
					<button id = "btnOthers" class="mainBtn">Others</button>
				</div>

			</div>
		</div>
	</div>
	
</body>
</html>
