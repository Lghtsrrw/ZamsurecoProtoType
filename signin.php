<?php
require('databaseConnection/DatabaseQueries.php');

  if (isset($_SESSION['user'])) {
    if(isLoggedIn()){
      header('location: index.php');
    }elseif(isGuest()){
      header('location: guestHomepage.php');
    }elseif (isAgent()) {
      header('location: employeeAgent.php');
    }elseif (isSupport()) {
      header('location: dispatch.php');
    }
  }
 ?>

<!DOCTYPE html>
<html >
  <head>
    <title>Login Page</title>
    <link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/signin.js"></script>
  </head>

  <body style="
  background: url('img/payment.png') no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">

    <!-- Trigger Sign Up/ Register modal -->
    <?php if (isset($_GET['register'])): ?>
      <script type="text/javascript">
      $(document).ready(function() {
        $('#btnRegister').click();
      });
      </script>
    <?php endif; ?>
    <!-- Trigger Login modal -->
    <?php if (isset($_GET['login'])): ?>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#btnLogin').click();
        });
      </script>
    <?php endif; ?>
    <!-- buttons declaration -->
    <div class ="btnContainer">
      <fieldset style="width:80%; margin:10% auto; background-color:white; opacity: .9">
        <div class="clscontainer">
            <button id = "btnEmpLogin" class="mainBtn" style="width:auto; float:right; background-color: green;">Log-in as Support</button>
        </div>
        <!-- title -->
        <div class="logoimg">
          <img src="img/logo.png" id="logotitle">
          <h3>ZAMSURECO-I MOBILE APPLICATION</h3>
        </div>

        <!-- displays errors -->
        <?php echo display_error(); ?>

        <!-- buttons -->
        <button id = "btnLogin" class="mainBtn" style="width:auto">LOGIN</button>
        <button id = "btnRegister" class="mainBtn" style="width:auto">REGISTER</button>
        <button id = "btnTrack" class="mainBtn" style="width:auto">TRACK COMPLAINT</button>
        <button id = "btnGuest" class="mainBtn" style="width:auto; background-color:#f1964c; ">LOGIN AS GUEST</button>
      </fieldset>
    </div>
    <!-- buttons declaration end-->

    <!-- Modals declaration -->
    <!-- modal for LoginPage -->
    <div id="id01" class="modal">
      <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class="imgcontainer">
          <img src="img/userprofile.png" alt="Avatar" class="avatar">
          <h1>MCO's Sign-in Page</h1>
        </div>
        <div class="container"> <!-- Check -->
          <input type="text" placeholder="Username" name="username">
          <input type="password" placeholder="Password" name="password">
          <hr>
          <button type="submit" class="mainBtn" name = "login_btn">Login</button>
          <p>Don't have an account? <a href="?register=1">Sign-up Here!</a> </p>
          <!--
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
           -->
        </div>
      </form>
    </div>

    <!-- modal for Register -->
    <div id="id02" class="modal">
      <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class="container">
          <h1 id = "dynamicRegister">Register</h1>
          <p id = "dynamicInstruct">Please fill in this form to create an account.</p>
          <hr>

          <div class="userfieldClass" id="userField"> <!-- User form -->
            <label for="username"><b>Username:</b></label><br>
            <input type="text" id="username" placeholder="Enter username" name="username" required><br>

            <label for="email"><b>Email:</b></label><br>
            <input type="text" id="email" placeholder="Email" name="email" required><br><br>

            <label for="password"><b>Password:</b></label><br>
            <input type="password" id="password" maxlength="16" placeholder="Password" name="password" required><br>

            <label for="confirmpassword"><b>Confirm Password:</b></label><br>
            <input type="password" id="confirmPass" maxlength="16" placeholder="Re-enter password" name="confirmPass" required> <br><br>

            <fieldset style="width:80%;">
              <legend><b>User's Information</b></legend>
              <br>
              <label for="fullname"><b>Fullname</b></label><br>
              <input type="text" id="fname" name="fname" onkeyup="this.value = this.value.toUpperCase();" placeholder="First name" required>
              <input type="text" id="mname" name="mname" onkeyup="this.value = this.value.toUpperCase();" maxlength="1" placeholder="Middle initial">
              <input type="text" id="lname" name="lname" onkeyup="this.value = this.value.toUpperCase();" placeholder="Last name" required><br>

              <label for="Address"><b>Address</b></label><br>
              <input type="text" id="address" name="address" placeholder="Your billing address" required><br>

              <label for="contact"><b>Contact</b></label><br>
              <input type="text" id="contact" onkeypress="validate(event)" maxlength="11" name="contact" placeholder="Your contact-number" required><br>

              <label for="regAcctNo"><b>Account Number</b></label><br>
              <input type="text" onkeypress="validate(event)" id="regAcctNo" maxlength="10" name="regAcctNo" placeholder="Your account-number" required><br>

            </fieldset><br>
          </div>
          <hr>
          <p>Already have an account? <a href="?login=1">Sign-in here!</a>.</p>
          <button type="submit" class="mainBtn" name="register_btn" id="registerbtn" style="width:100%;">Register</button>
        </div>
      </form>
    </div>

    <!-- modal for complaint-tracking -->
    <div id="id03" class="modal">
      <form class="modal-content animate" action="/action_page.php" method="post">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class="container" style="padding-top:2%">
        <h2>TRACKING COMPLAINT</h2>
          <input type="text" placeholder="Enter tracking no." id="inputTrackingNo" name="uname" autocomplete="off" required>
          <button type="button" id="btnTrackNow" class="mainBtn" style="width:100%">Track</button>
        </div>
      </form>
    </div>

    <!-- modal for guest -->
    <div id="id04" class="modal">
      <form class="modal-content animate" action="signin.php" method="post">
        <div class="clscontainer">
          <span class="close" title="Close Modal">&times;</span>
        </div>
        <div class="imgcontainer">
          <img src="img/userprofile.png" alt="Avatar" class="avatar">
        </div>
        <div class="container">
          <label for="username"><b>Guest Name</b></label><br>
          <input type="text" id="mguestname" name="guestname" placeholder="Enter name" required><br><br>

          <label for="gEmail"><b>Email</b></label><label style="color:#A9A9A9;" >  (optional)</label><br>
          <input type="text" placeholder="Enter email" id="mgEmail" name="gEmail" ><br><br>

          <label for="gContact"><b>Contact Number</b></label><br>
          <input type="text" id="mgContact" onkeypress="validate(event)" maxlength="11" placeholder="Enter contact no" name="gContact" required><br><br>

          <label for="gAddress"><b>Address</b></label><br>
          <input type="text" id="mgAddress" placeholder="Enter address" name="gAddress" required> <br>
          <hr>
          <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
          <button type="submit" class="mainBtn" name="guestbtn" id="mguestbtn"style="width:100%;">Enter as Guest</button>
        </div>
      </form>
    </div>
    <!-- Modals declaration end -->
  </body>
</html>
