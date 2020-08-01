<?php
  include('databaseConnection/databaseConnection.php');

  if (!empty(isset($_SESSION['user']))) {
    header('location: index.php');
  }
 ?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      //This changes the Register Modal Entry-field by user selection.
      $( "#userType" ).click(function(){
        var usertype = $( "#userType" ).val();
          if (usertype == "User") {
            $("#userField").show();
            $("#guestField").hide();
            $("#dynamicRegister").text("Register");
            $("#dynamicInstruct").text("Please fill in this form to create an account.");
            $("#guestbtn").hide();
            $("#registerbtn").show();
          }else {
            $("#userField").hide();
            $("#guestField").show();
            $("#dynamicRegister").text("Enter as Guest");
            $("#dynamicInstruct").hide();
            $("#registerbtn").hide();
            $("#guestbtn").show();
          }
      })

      //this opens the Login Modal when btnLogin is clicked
      $("#btnLogin").click(function(){
      	 $("#id01").css("display","block");
       });
      //this opens the Register Modal when btnRegister is clicked
      $("#btnRegister").click(function(){
        $("#id02").css("display","block");
      });
      //this opens the Track Modal when btnTrack is clicked
      $("#btnTrack").click(function(){
        $("#id03").css("display","block");
        // closeModal();
      });
      //this opens the Guest Modal when btnGuest is clicked
      $("#btnGuest").click(function(){
        $("#id04").css("display","block");
        // closeModal();
      });
      //this closes all visible modal with class name 'close'.
      $(".close").click(function(){
        $(".modal").css("display","none");
      });
    });
  </script>
  <h2>Zamsureco Login Form</h2>
</head>

<body>
<?php echo display_error(); ?>
<!-- buttons declaration -->
<button id = "btnLogin" style="width:auto">Login</button>
<button id = "btnRegister" style="width:auto;">Register</button>
<button id = "btnTrack" style="width:auto;">Tracking No</button>
<button id = "btnGuest" style="width:auto;">Enter as Guest</button>
<!-- buttons declaration end-->
<!-- Modals declaration -->
<div id="id01" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="imgcontainer">

      <span class="close" title="Close Modal">&times;</span>
      <img src="img/userprofile.jpg" alt="Avatar" class="avatar">
    </div>
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
    </div>
    <div class="container">
      <h1 id = "dynamicRegister">Register</h1>
      <p id = "dynamicInstruct">Please fill in this form to create an account.</p>
      <hr>
      <label for="IDType">Select ID Type: </label>
      <select name="userType" id="userType">
        <option value="User">User</option>
        <option value="Guest">Guest</option>
      </select><br><br>

      <div class="" id="userField">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="confirmpassword">Confirm Password:</label><br>
        <input type="password" id="confirmPass" name="confirmPass"> <br><br>

        <fieldset style="width:80%;">
          <legend>User's Information</legend>
          <br>
          <label for="fullname">Fullname</label><br>
          <input type="text" id="fname" name="fname" placeholder="Enter First Name">
          <input type="text" id="mname" name="mname" placeholder="Enter Middle Name">
          <input type="text" id="lname" name="lname" placeholder="Enter Last Name"><br>

          <label for="Address">Address</label><br>
          <input type="text" id="address" name="address" placeholder="Your Billing Address"><br>

          <label for="contact">Contact</label><br>
          <input type="text" id="contact" name="contact" placeholder="Your Contact Number"><br>

          <label for="regAcctNo">Account Number</label><br>
          <input type="text" id="regAcctNo" name="regAcctNo" placeholder="Your Account Number"><br>

        </fieldset><br>
      </div>
      <div class="" id = "guestField" style="display:none">
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
        <button type="submit">Enter as Guest</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancel</button>
    </div>

  </form>
</div>
<!-- Modals declaration end-->
</body>
</html>
