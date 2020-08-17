<?php
	session_start();

	/* Database credentials. Assuming you are running MySQL
	server with default setting (user 'root' with no password) */
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'protozmsrc1');

	/* Attempt to connect to MySQL database */
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$db = $mysqli;

	// Check connection
	if($mysqli === false){
	    die("ERROR: Could not connect. " . $mysqli->connect_error);
	}
	// variable declaration
	$username = "";
	$password = "";
	$email    = "";
	$errors   = array();

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}
	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}
	if(isset($_POST['guestbtn'])){
		guest();
	}
	if(isset($_POST['logout'])){
		logout();
	}
	if(isset($_POST['btnComplaint'])){
		header('location: complaintTicket.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: signin.php");
	}
	// call Logout(); whenever logout button is clicked

	// Check if the username is already in the system.
	function checkUsername($_username){
			global $db, $errors;
			$retunval;
			$results = mysqli_query($db, "SELECT username FROM syst_acct where username ='$_username' limit 1");
			if (mysqli_num_rows($results) == 1) {
				array_push($errors, "Sorry this username already exist, try another");
			}
	}

	// REGISTER USER
	function register(){
		global $db, $errors;

		$username = $_POST['username'];
		$email = $_POST['email'];
		$password1 = $_POST['password'];
		$password2 = $_POST['confirmPass'];

		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$regAcctNo = $_POST['regAcctNo'];

		// form validation: ensure that the form is correctly filled
		// if (empty($username)) {
		// 	array_push($errors, "Username is required");
		// }
		// // elseif (!empty($username)){
		// // 	// checkUsername($username);
		// // }
		// if(empty(trim($_POST["regAcctNo"]))){
    //     array_push($errors, "Please enter your Account Number.");
    // }
    // elseif(strlen(trim($_POST["regAcctNo"])) != 10) {
    //     array_push($errors, "Please check your Account Number.");
    // }
		// if (empty($email)) {
		// 	array_push($errors, "Email is required");
		// } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// 	array_push($errors, "Invalid Email address");
    // 	}
		// if (empty($password1)) {
		// 	array_push($errors, "Password is required");
		// }
		// if ($password1 != $password2) {
		// 	array_push($errors, "The two passwords do not match");
		// }
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password1);//encrypt the password before saving in the database

			if (!mysqli_query($db,"INSERT INTO syst_acct (username, password) VALUES ('$username', '$password')")) {
				echo("Error description: " . mysqli_error($db));
		  }else {
		  	echo "<script> alert('Success1'); </script>";
		  }
			if (!mysqli_query($db,"INSERT INTO user (UserID, fname, mname, lname, address, contact, acctNo, email) VALUES('$username','$fname','$mname','$lname','$address','$contact','$regAcctNo','$email')")) {
				echo("Error description: " . mysqli_error($db));
			}else {
				echo "<script> alert('Success2'); </script>";
			}
			if (!mysqli_query($db,"INSERT INTO id_verification (userID, IdType, date_created) VALUES('$username', 'User', now())")) {
				echo("Error description: " . mysqli_error($db));
			}else {
				echo "<script> alert('Success3'); </script>";
			}
			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in ";
			header('location: index.php');
			$mysqli -> close();
		}
	}
	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT sa.username as 'username', u.contact as 'contact', u.email 'email', iv.IDType 'idtype'  FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.UserID inner join user u on iv.userID = u.userID  WHERE sa.userID = " . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
		$mysqli -> close();
	}
	//return guest name from their registration
	function getGuestById($id){
		global $db;
		$query = "SELECT * FROM guest g INNER JOIN id_verification iv ON iv.userID = g.guestNo WHERE g.guestNo = " . $id ;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
		$mysqli -> close();
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = $_POST['username'];
		$password = $_POST['password'];

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password1 = md5($password);

			$query = "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.userID inner join user u on u.userID = sa.username WHERE sa.Username='$username' AND Password='$password1' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: index.php');

			}else {
				array_push($errors, "Wrong username/password combination ");
			}
		}
	}
	//GUEST USER
	function guest(){
		global $db, $errors;
		// grab values
		$guestname = $_POST['guestname'];
		$guestMail = $_POST['gEmail'];
		$gcontact = $_POST['gContact'];
		$gaddress = $_POST['gAddress'];
		// make sure form is filled properly
		if (empty($guestname)) {
			array_push($errors, "Guest Name is required");
		}
		if (empty($guestMail)) {
			array_push($errors, "Your email is required");
		}
		if(!filter_var($guestMail, FILTER_VALIDATE_EMAIL)) {
			array_push($errors, "Invalid Email address");
    	}
		if (empty($gcontact)) {
			array_push($errors, "Your contact is required");
		}
		if (empty($gaddress)) {
			array_push($errors, "Your Address is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {

			$query = "INSERT INTO guest (name, address, contact, email)
			VALUES('$guestname', '$gaddress', '$gcontact', '$guestMail')";
			$results = mysqli_query($db, $query);

			$logged_in_user_id = mysqli_insert_id($db);

			echo "<script type='text/javascript'>alert($logged_in_user_id);</script>";

			$query = "INSERT INTO id_verification (userID, IdType, date_created)
			VALUES('$logged_in_user_id', 'Guest', now())";
			$results = mysqli_query($db, $query);

			$_SESSION['user'] =  getGuestById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in as Guest";

			header('location: guestHomepage.php');
		}else {
			array_push($errors, "Something is wrong");
		}

		$mysqli -> close();
	}

	function isLoggedIn(){
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin(){
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div  class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function logout(){
		session_destroy();
		unset($_SESSION['user']);
		header("location: signin.php");
	}

	function getTicketNo(){

	}
?>
