<?php
  include('databaseConnection/databaseConnection.php');
 ?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="stylesheets/loginStylesheet.css" rel="stylesheet" type="text/css">
  <script src="js/closingscript.js"></script>
  <script src="js/jquery-3.5.1.min.js"></script>
  <h2>Zamsureco Login Form</h2>
</head>

<body>
<!-- buttons declaration -->
<button onclick="document.getElementById('id01').style.display='block';" style="width:auto;">Login</button>
<button onclick="document.getElementById('id02').style.display='block'; closeModal('id02')" style="width:auto;">Register</button>
<button onclick="document.getElementById('id03').style.display='block'; closeModal('id03')" style="width:auto;">Tracking No</button>
<button onclick="document.getElementById('id04').style.display='block'; closeModal('id04')" style="width:auto;">Enter as Guest</button>
<!-- buttons declaration -->
<!-- Modals declaration -->
<div id="id01" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="imgcontainer">

      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
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

    <div class="container">
      <h1>Register</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter username" name="username" value="<?php echo $username; ?>" id="username" required>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" value="<?php echo $email; ?>" id="email" required >

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password1" id="password1" required>

      <label for="psw-repeat"><b>Confirm Password</b></label>
      <input type="password" placeholder="Repeat Password" name="password2" id="password2" required>

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
