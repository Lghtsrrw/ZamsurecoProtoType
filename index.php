<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="stylesheets/loginStylesheet.css" rel="stylesheet" type="text/css">
  <script src="js/closingscript.js"></script>
</head>
<body>
<h2>Zamsureco Login Form</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Register</button>

<button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">TrackingNo</button>

<button onclick="document.getElementById('id04').style.display='block'" style="width:auto;">Enter as Guest</button>

<div id="id01" class="modal">
  <form class="modal-content animate" action="/action_page.php" method="post">

    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="img/userprofile.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <button type="submit">Login</button>
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
  <form class="modal-content animate" action="/action_page.php" method="post">

    <div class="container">
      <h1>Register</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" id="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
      <hr>
      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

      <button type="submit" class="registerbtn">Register</button>

      <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw"><p>Already have an account? <a href="#">Sign in</a>.</p></span>

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

    <button type="submit">Track</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancel</button>
  </div>

  </form>
</div>

<script> closeModal('id01'); </script>

<button>Connection</button>
</body>
</html>
