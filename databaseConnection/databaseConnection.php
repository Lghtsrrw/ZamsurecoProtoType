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
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: signin.php");
	}
	// call Logout(); whenever logout button is clicked
	// REGISTER USER
	function register(){
		global $db, $errors;

		// receive all input values from the form
		// $username    =  e($_POST['username']);
		// $email       =  e($_POST['email']);
		// $password_1  =  e($_POST['password1']);
		// $password_2  =  e($_POST['password2']);

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

			if (isset($_POST['userID'])) {
				echo "oops";
				$user_type = e($_POST['userID']);
				$query = "INSERT INTO syst_acct (username, email, IDType, password)
						  VALUES('$username', '$email', '$user_type', '$password')";
				mysqli_query($db, $query);
				$_SESSION['success']  = "New user successfully created!!";
				header('location: home.php');
			}else{
				echo "Wow";
				$query2 = "INSERT INTO user (fname, mname, lname, address, contact, acctNo)
									VALUES('$fname','$mname','$lname','$address','$contact','$regAcctNo')";
				mysqli_query($db, $query2);
				$query = "INSERT INTO syst_acct (username, IDType, password)
									VALUES('$username', 'user', '$password')";
				$results = mysqli_query($db, $query);


				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in ";
				header('location: index.php');
			}
			echo "Out";
		}

	}
	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM syst_acct WHERE userID=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}
	//return guest name from their registration
	function getGuestById($id){
		global $db;
		$query = "SELECT * FROM guest WHERE guestID=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
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

			$query = "SELECT * FROM syst_acct WHERE Username='$username' AND Password='$password1' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['userID'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin/home.php');
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";

					header('location: index.php');
				}
			}else {
				array_push($errors, "Wrong username/password combination ");
			}
		}
	}
	//GUEST USER
	function guest(){
		echo "Error in guest";
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
			echo "Somethings Wroooooooong";
			$query = "INSERT INTO guest (Name, Contact, Address, Email)
								VALUES('$guestname', $gcontact', '$gaddress', '$guestMail')";
								echo $query;
			$results = mysqli_query($db, $query);
			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getGuestById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in ";
			header('location: guesthomepage.php');
			}
				echo "Heeeeeeeenlo";
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
		$_SESSION = array();
		session_destroy();

		header("location: signin.php");
	}
?>
