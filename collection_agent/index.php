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

function fillCollectionTable(){
    global $db;
    $queryAddress = "SELECT * FROM receiptimage ";
    $results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
    if(mysqli_num_rows($results) > 0){
      while ($row = mysqli_fetch_assoc($results)) {
        echo "<tr>";
        // echo "<td style='width:auto'><img src='data:image/jpg;charset=utf8;base64,". base64_encode($row['receiptimage']) . "' width = '50%' /></td>";
        echo "<td><img src='data:image/jpg;charset=utf8;base64,". base64_encode($row['receiptimage']) . "' class='img-fluid' alt='Responsive image'></td>";
        echo "<td>" . $row['uploaded'] . "</td>";
        echo "<td>" . $row['acctno'] . "</td>";
        echo "<td>" . $row['duedate'] . "</td>";
        echo "<td><button id='btnVerify'>Verify</button></td>";
        echo "</tr>";
      }
    }
}

?>

<!doctype>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" type="image/x-ico" href="../img/favicon.ico"/>
    
    <title>
      Collection Agent
    </title>

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
    <link href="../user_bills/navbar-top-fixed.css" rel="stylesheet">

    <!-- JS File -->
    <script src="../bootstrap-5.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>  
    <script src="index.js"></script>
    
  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light" tyle="background-color: #e3f2fd;">
      <div class="container-fluid">
        <a class="navbar-brand" href="../"><img src="../img/logo.png" alt="" width="25">Collection </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../collection_agent">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="change_password.php">Change Password</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="verified_list.php">Verified list</a>
            </li>
          </ul>
          <form class="d-flex">
            <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> -->
            <button class="btn btn-outline-dark" id="btnLogout" type="submit">Logout</button>
          </form>
        </div>
      </div>
    </nav>

    <main class="container" >
      
      <div style=" text-align: center; overflow:scroll">
        <table class="table table-striped border-dark" id="tblUnverifiedReceipt">
          <thead>
            <tr>
              <th scope="col">Receipt Image</th>
              <th scope="col">Date Sent</th>
              <th scope="col">Due Date</th>
              <th scope="col">Account No</th>
              <th scope="col">Verification</th>
            </tr>
          </thead>
          <tbody>
            <?php fillCollectionTable(); ?>
          </tbody>
        </table>
      </div>

    </main>
  </body>
</html>
