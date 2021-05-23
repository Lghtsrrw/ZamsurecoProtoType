<?php 
require '../databaseConnection/DatabaseQueries.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Passsword</title>
    <link href="../bootstrap-5.0.0/css/bootstrap.min.css" rel="stylesheet">
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

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../"><img src="../img/logo.png" alt="" width="25">Collection </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" href="../collection_agent">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="change_password.php">Change Password</a>
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
    
    <main class="container">
      <!-- <div class="border border-primary border-left-0" style="padding:1em; margin: 1em; border-radius:1em"> -->
      <h1>Change password</h1>
      <hr>
      <input type="password" id="newpassword" name="newpassword" placeholder="New-Password"><br>
      <input type="password" id="newrepeatedpassword" name="newrepeatedpassword" placeholder="Repeat-Password" value=""><br>
      <input type="password" id="oldpassword" name="oldpassword" placeholder="Old-Password">
      <hr>
      <label for="" id='notif' style="color:red;"></label>
      <button type="button" id="btnUpdateAPass" name="UpdateSuppPassword" class="mainBtn" style="clear:left; display:inline-block">Save Password</button>
      <!-- </div> -->
    </main>
    <script src="../bootstrap-5.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>  
    <script src="../js/index.js"></script>
</body>
</html>