<?php
  include('databaseConnection/databaseConnection.php');

  if (!empty(isset($_SESSION['user']))) {
    if($_SESSION['user']['IDType'] === 'User'){
      header('location: index.php');
    }elseif($_SESSION['user']['IDType'] === 'Guest'){
      header('location: guestHomepage.php');
    }
  }
 ?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="stylesheets/webStyle.css" rel="stylesheet" type="text/css">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/signin.js"></script>
  <h2>Zamsureco Login Form</h2>
</head>

<body>
<?php echo display_error(); ?>
<!-- buttons declaration -->
<div class ="btnContainer">
<fieldset style="width:50%; margin:0px auto;">
  <button id = "btnLogin" style = "width:auto">Login</button>
    <button id = "btnRegister" style = "width:auto">Register</button>
    <button id = "btnTrack" style = "width:auto">Track your complaint</button>
    <button id = "btnGuest" style = "width:auto">Enter as Guest</button>
  </fieldset>
</div>
<!-- buttons declaration end-->

<!-- Modals declaration -->
<!-- modal for LoginPage -->
<div id="id01" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="imgcontainer">

      <span class="close" title="Close Modal">&times;</span>
      <img src="img/userprofile.jpg" alt="Avatar" class="avatar">
    </div>
    <div class="container"> <!-- Check -->
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username">

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password">

      <button type="submit" class="btn" name = "login_btn">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw"><a href="#">Forgot password?</a></span>
    </div>
  </form>
</div>

<!-- modal for Register -->
<div id="id02" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="imgcontainer">
      <span class="close" title="Close Modal">&times;</span>
    </div>
    <div class="container">
      <h1 id = "dynamicRegister">Register</h1>
      <p id = "dynamicInstruct">Please fill in this form to create an account.</p>
      <hr>
      <label for="IDType"><b>Select ID Type:</b></label>
      <select name="userType" id="userType">
        <option value="User">User</option>
        <option value="Guest">Guest</option>
      </select><br><br>

      <div class="" id="userField"> <!-- User form -->
        <label for="username"><b>Username:</b></label><br>
        <input type="text" id="username" placeholder="Enter username" name="username"><br>

        <label for="email"><b>Email:</b></label><br>
        <input type="text" id="email" placeholder="Enter email" name="email"><br><br>

        <label for="password"><b>Password:</b></label><br>
        <input type="password" id="password" placeholder="Enter password" name="password"><br>

        <label for="confirmpassword"><b>Confirm Password:</b></label><br>
        <input type="password" id="confirmPass" placeholder="Re-enter password" name="confirmPass"> <br><br>

        <fieldset style="width:80%;">
          <legend><b>User's Information</b></legend>
          <br>
          <label for="fullname"><b>Fullname</b></label><br>
          <input type="text" id="fname" name="fname" placeholder="Enter First Name">
          <input type="text" id="mname" name="mname" placeholder="Enter Middle Name">
          <input type="text" id="lname" name="lname" placeholder="Enter Last Name"><br>

          <label for="Address"><b>Address</b></label><br>
          <input type="text" id="address" name="address" placeholder="Your Billing Address"><br>

          <label for="contact"><b>Contact</b></label><br>
          <input type="text" id="contact" name="contact" placeholder="Your Contact Number"><br>

          <label for="regAcctNo"><b>Account Number</b></label><br>
          <input type="text" id="regAcctNo" name="regAcctNo" placeholder="Your Account Number"><br>

        </fieldset><br>
      </div>
      <div class="" id = "guestField" style="display:none"><!-- Guest form -->
        <label for="username">Guest Name</label><br>
        <input type="text" id="guestname" name="guestname" ><br>

        <label for="gEmail">Email</label><br>
        <input type="text" id="gEmail" name="gEmail" ><br><br>

        <label for="gContact">Contact Number</label><br>
        <input type="text" id="gContact" name="gContact" ><br>

        <label for="gAddress">Address</label><br>
        <input type="text" id="gAddress" name="gAddress" > <br>
      </div>

      <hr>
      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

      <button type="submit" class="registerbtn" name="register_btn" id="registerbtn">Register</button>
      <button type="submit" class="guestbtn" name="guestbtn" id="guestbtn" style="display:none">Enter as Guest</button>

      <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw"><p>Already have an account? <a href = "#">Sign in</a>.</p></span>
      </div>
    </div>
  </form>
</div>

<!-- modal for complaint-tracking -->
<div id="id03" class="modal">
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="imgcontainer">
      <span class="close" title="Close Modal">&times;</span>
      <!-- <img src="img/userprofile.jpg" alt="Avatar" class="avatar"> -->
    </div>
    <div class="container">
    <label for="uname"><b>Tracking No.:</b></label>
    <input type="text" placeholder="Enter Tracking No" name="uname" required>

    <button type="submit">Track</button>
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
  </div>
  </form>
</div>

<!-- modal for guest -->
<div id="id04" class="modal">
  <form class="modal-content animate" action="signin.php" method="post">
    <div class="imgcontainer">
      <span class="close" title="Close Modal">&times;</span>
    </div>
    <!-- <div class="container">
        <label for="username"><b>Guest Name</b></label><br>
        <input type="text" id="guestname" name="guestname" placeholder="Enter Name" ><br>

        <label for="gEmail"><b>Email</b></label><br>
        <input type="text" placeholder="Enter EMAIL" id="gEmail" name="gEmail" ><br><br>

        <label for="gContact"><b>Contact Number</b></label><br>
        <input type="text" id="gContact" placeholder="Enter Contact No" name="gContact" ><br>

        <label for="gAddress"><b>Address</b></label><br>
        <input type="text" id="gAddress" placeholder="Enter Address" name="gAddress" > <br>

        <button type="submit" class="guestbtn" name="guestbtn" id="guestbtn" style="display:none">Enter as Guest</button>
    </div> -->

    <div class="container" style="background-color:#f1f1f1">
      <button  class="cancelbtn" type="button" onclick="document.getElementById('id04').style.display='none'">Cancel</button>
    </div>

  </form>
</div>
<!-- Modals declaration end-->

</body>
</html>
