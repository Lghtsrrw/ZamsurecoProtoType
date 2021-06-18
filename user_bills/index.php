<?php
require('../databaseConnection/DatabaseQueries.php');

if (isGuest()) {
	header('location: ../guestHomepage.php');
}elseif (isAgent()) {
	header('location: ../employeeAgent.php');
}elseif (isSupport()) {
  header('location: ../dispatch.php');
}elseif(empty(isset($_SESSION['user']))){
	header('location: ../userauthenticate.php');
}
?>

<!doctype>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" type="image/x-ico" href="../img/favicon.ico"/>
    
    <title>Bills</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbar-fixed/">

    <!-- Bootstrap core CSS -->
      <link href="../bootstrap-5.0.0/css/bootstrap.min.css" rel="stylesheet">
	    <!-- <link href="../stylesheets/allStyle.css" rel="stylesheet" type="text/css">  -->

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
    <!-- Custom styles for this template -->
    <link href="navbar-top-fixed.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../"><img src="../img/logo.png" alt="" width="25">MEMBER-CONSUMER BILLS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../user_bills">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user_unpaid.php">Account Payable</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="bills_history.php">Bills Payment</a>
            </li>
          </ul>
          <form class="d-flex">
            <button class="btn btn-outline-danger" type="submit" id="btnLogout" >Logout</button>
          </form>
        </div>
      </div>
    </nav>

    <main class="container">
        <h3>Year of <?php echo date("Y") ?> </h3>
        <hr>
        <!-- Display Bills  -->
        <div class="div-unstyles" id="bg-light p-5 rounded" style="width: auto; text-align: left; overflow:auto">
        <?php if (ifBillExist($_SESSION['user']['AcctNo'])) : ?>
          
            <div id="bg-light p-5 rounded">
              <table id='tblBill' class='table table-striped table-hover' style="display:inline-block; width:auto">
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
            </div>
            <?php else : ?>
              <p><b>Bills</b></p>
              <p style="font-size: 12px; color: red">No bills available to display for Account No.: <i><?php echo $_SESSION['user']['AcctNo']; ?></i> </p>
            <?php endif ?>
        </div>
        <!-- <a class="btn btn-lg btn-primary" href="../components/navbar/" role="button">View navbar docs &raquo;</a> -->
    </main>

  <script src="../bootstrap-5.0.0/js/bootstrap.bundle.min.js"></script>
  <script src="../js/jquery-3.5.1.min.js"></script>  
	<script src="../js/index.js"></script>
  </body>
</html>
