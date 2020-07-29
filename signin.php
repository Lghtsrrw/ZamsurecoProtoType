<?php
  include('databaseConnection/databaseConnection.php');
 ?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $( "#userType" ).click(function(){
        var usertype = $( "#userType" ).val();
          if (usertype == "User") {
            $("#userField").show();
            $("#guestField").hide();
          }else {
            $("#userField").hide();
            $("#guestField").show();
          }
      })
      $("#btnLogin").click(function(){
      	 $("#id01").css("display","block");
         // closeModal();
      });
      $("#btnRegister").click(function(){
        $("#id02").css("display","block");
        // closeModal();
      });
      $("#btnTrack").click(function(){
        $("#id03").css("display","block");
        // closeModal();
      });
      $("#btnGuest").click(function(){
        $("#id04").css("display","block");
        // closeModal();
      });
      $(".close").click(function(){
        $(".modal").css("display","none");
      });
    });
  </script>
  <h2>Zamsureco Login Form</h2>
</head>

<body>
<!-- buttons declaration -->
<button id = "btnLogin" style="width:auto">Login</button>
<button id = "btnRegister" style="width:auto;">Register</button>
<button id = "btnTrack" style="width:auto;">Tracking No</button>
<button id = "btnGuest" style="width:auto;">Enter as Guest</button>
<!-- buttons declaration -->
<!-- Modals declaration -->
<div id="id01" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="imgcontainer">

      <span class="close" title="Close Modal">&times;</span>
      <img src="img/userprofile.jpg" alt="Avatar" class="avatar">
    </div>
    <?php echo display_error(); ?>
    <div class="container">
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
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>
<div id="id02" class="modal">
  <form class="modal-content animate" action="signin.php" method="post">

    <div class="imgcontainer">
      <span class="close" title="Close Modal">&times;</span>
      <!-- <img src="img/userprofile.jpg" alt="Avatar" class="avatar"> -->
    </div>
    <div class="container">
      <h1>Register</h1>
      <p>Please fill in this form to create an account.</p>

      <hr>

      <label for="IDType">Select ID Type: </label>
      <select name="userType" id="userType">
        <option value="User">User</option>
        <option value="Guest">Guest</option>
      </select><br><br>

      <div class="" id="userField">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="confirmpassword">Confirm Password:</label><br>
        <input type="password" id="confirmPass" name="confirmPass" required> <br><br>

        <fieldset style="width:80%;">
          <legend>User's Information</legend>
          <br>
          <label for="fullname">Fullname</label><br>
          <input type="text" id="fname" name="fname" placeholder="Enter First Name" required>
          <input type="text" id="mname" name="mname" placeholder="Enter Middle Name" required>
          <input type="text" id="lname" name="lname" placeholder="Enter Last Name" required><br>

          <label for="Address">Address</label><br>
          <input type="text" id="address" name="address" placeholder="Your Billing Address" required><br>

          <label for="contact">Contact</label><br>
          <input type="text" id="contact" name="contact" placeholder="Your Contact Number" required><br>

          <label for="regAcctNo">Account Number</label><br>
          <input type="text" id="regAcctNo" name="regAcctNo" placeholder="Your Account Number" required><br>

        </fieldset><br>
      </div>
      <div class="" id = "guestField" style="display:none;">
        <label for="username">Guest Name</label><br>
        <input type="text" id="guestname" name="guestname" required><br>

        <label for="gEmail">Email</label><br>
        <input type="text" id="gEmail" name="gEmail" required><br><br>

        <label for="gContact">Contact Number</label><br>
        <input type="text" id="gContact" name="gContact" required><br>

        <label for="gAddress">Address</label><br>
        <input type="text" id="gAddress" name="gAddress" required> <br>
      </div>
      <hr>
      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

      <button type="submit" class="registerbtn" name="register_btn">Register</button>

      <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw"><p>Already have an account? <a href = "#">Sign in</a>.</p></span>
      </div>
    </div>
  </form>
</div>
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
<div id="id04" class="modal">
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="imgcontainer">
      <span class="close" title="Close Modal">&times;</span>
      <!-- <img src="img/userprofile.jpg" alt="Avatar" class="avatar"> -->
    </div>
    <div class="container">
        <label for="uname"><b>Guest Name</b></label>
        <input type="text" placeholder="Enter Name" name="uname" required>
        <label for="ucontact"><b>Contact No</b></label>
        <input type="text" placeholder="Enter Contact No" name="ucontact" required>
        <label for="uaddress"><b>Address</b></label>
        <input type="text" placeholder="Enter Address" name="uaddress" required>
        <label for="uemail"><b>Email Address</b></label>
        <input type="text" placeholder="Enter EMAIL" name="uemail" required>
        <button type="submit">Track</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancel</button>
    </div>

  </form>
</div>
<!-- Modals declaration -->
</body>
</html>
