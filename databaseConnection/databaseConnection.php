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

	if(isset($_POST['btnregion'])){
		$regionname = $_POST['region'];
			echo "<script>alert('". $regionname ."');</script>";
		// populateProvince($_POST['region_select']);
	}else {
		// code...
	}
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
		global $db;
		$query = "SELECT username FROM syst_acct where username =" . $_username;
		$result = mysqli_query($db, $query);
		if(!$result->mysqli_num_rows === 0){
			array_push($errors, "Sorry ". $_username ." is already in use, please try another. ");
		}else {
			// code...
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
		if (empty($username)) {
			array_push($errors, "Username is required");
		}else {
			// checkUsername($username);
		}
		if(empty(trim($_POST["regAcctNo"]))){
        array_push($errors, "Please enter your Account Number.");
    }
    elseif(strlen(trim($_POST["regAcctNo"])) != 10) {
        array_push($errors, "Please check your Account Number.");
    }

		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			array_push($errors, "Invalid Email address");
    	}
		if (empty($password1)) {
			array_push($errors, "Password is required");
		}
		if ($password1 != $password2) {
			array_push($errors, "The two passwords do not match");
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password1);//encrypt the password before saving in the database

			if (!mysqli_query($db,"INSERT INTO syst_acct (username, password) VALUES('$username', '$password')")) {
				echo("Error description: " . mysqli_error($db));
		  }
			if (!mysqli_query($db,"INSERT INTO user (UserID, fname, mname, lname, address, contact, acctNo) VALUES('$username','$fname','$mname','$lname','$address','$contact','$regAcctNo')")) {
				echo("Error description: " . mysqli_error($db));
		  }
			if (!mysqli_query($db,"INSERT INTO id_verification (userID, IdType, date_created) VALUES('$username', 'User', now())")) {
				echo("Error description: " . mysqli_error($db));
		  }
			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in ";
			header('location: index.php');
		}
		$mysqli -> close();
	}
	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.UserID WHERE sa.username = " . $id;
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

			$query = "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.userID WHERE Username='$username' AND Password='$password1' LIMIT 1";
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
		// grap form values
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

			// // get id of the created user
			// $logged_in_user_id = mysqli_insert_id($db);

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

	// escape string
	// function e($val){
	// 	global $db;
	// 	return mysqli_real_escape_string($db, trim($val));
	// }

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
	
	function populateRegion(){
		global $db;
		$sql = "SELECT regCode, regDesc FROM refRegion";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)) {
			echo "ddRegion.append('<option> ". $row['regDesc'] ."</option>');";
		}
	}

	function populateProvince($reg){
		global $db;
			$sql = "SELECT provDesc FROM refProvince rp inner join refregion rg on rp.regCode = rg.regCode where regDesc = '$reg'";
			$result = mysqli_query($db, $sql);
			while ($row = mysqli_fetch_array($result)) {
				echo "ddProvince.append('<option>". $row['provDesc'] ."</option>');";
			}
	}
	function populateMunicipal($prov){
		global $db;
		$sql = "SELECT citymunDesc FROM refcitymun rcm inner join refProvince rp on rcm.provCode = rp.provCode where provDesc = '$prov'";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)) {
			echo "ddMunicipal.append('<option>". $row['citymunDesc'] ."</option>');";
		}
	}
	function populateBrgy($citymun){
		global $db;
		$sql = "SELECT brgyDesc FROM refbrgy rb inner join refcitymun rcm on rb.citymunCode = rcm.citymunCode where citymunDesc = '$citymun'";
		$result = mysqli_query($db, $sql);

		while ($row = mysqli_fetch_array($result)) {
			echo "ddBrgy.append('<option>". $row['brgyDesc'] ."</option>');";
		}
	}
?>
