<?php
require('../databaseConnection/DatabaseQueries.php');
require('upload.php');

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
    
    <title>Bills Payment</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbar-fixed/">

    <!-- Bootstrap core CSS -->
      <link href="../bootstrap-5.0.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
              <a class="nav-link" href="../user_bills">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user_unpaid.php">Account Payable</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active"  aria-current="page" href="bills_history.php">Bills Payment</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <?php
      if(isset($_GET['message'])):
    ?>
      <script>
        alert($_GET['message']);
      </script>
    <?php
        unset($_GET['message']);
      endif;
    ?>

  <main class="container">
    <p> <?php echo $_SESSION['user']['AcctNo']; ?> </p>
    <h3>Bills Payment</h3>
    <hr>
    <!-- Display Bills  -->
    <!-- <div class="div-unstyles" id="bg-light p-5 rounded" style="width: auto; text-align: left; overflow:auto">
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
    </div> -->
        <!-- End Display Bills -->

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
          <label>Select Receipt Image:</label>
          <input type="file" name="image">
          <input type="submit" name="submit">
        </form>

        <?php 
          // Include the database configuration file  
          require_once '../databaseConnection/databaseQueries.php';
          // Get image data from database 
          $acctNo = $_SESSION['user']['AcctNo'];
          $result = $db->query("SELECT receiptimage FROM receiptimage where acctno = '$acctNo' ORDER BY uploaded DESC"); 
          ?>
          <?php if($result->num_rows > 0){ ?> 
              <div class="gallery"> 
                  <?php while($row = $result->fetch_assoc()){ ?> 
                      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['receiptimage']); ?>" width = '25%' /> 
                  <?php } ?>
              </div> 
          <?php }else{ ?> 
              <p class="status error">Image(s) not found...</p> 
          <?php } ?>

    </main>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="../bootstrap-5.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap-5.0.0/js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>  
    <script src="../js/index.js"></script>
    

  </body>
</html>
