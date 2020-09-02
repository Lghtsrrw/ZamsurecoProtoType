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
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: signin.php");
	}
	if(isset($_POST['nTicketbtn'])){
		submitTicket();
	}

	if (isset($_POST['btnEmpLogin'])) {
		empLogin();
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
		if (empty($username)) {
			array_push($errors, "Username is required");
		}elseif (!empty($username)){
			 checkUsername($username);
		}
		if(empty(trim($_POST["regAcctNo"]))){
        array_push($errors, "Please enter your Account Number.");
    }
    elseif(strlen(trim($_POST["regAcctNo"])) != 10) {
        array_push($errors, "Please check your Account Number.");
    }
		if (empty($email)) {
			array_push($errors, "Email is required");
		} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

			if (mysqli_query($db, "INSERT INTO user (UserID, fname, mname, lname, address, contact, acctNo, email) VALUES('$username','$fname','$mname','$lname','$address','$contact','$regAcctNo','$email')")) {
			  echo "New user created successfully";
			} else {
			  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			if (mysqli_query($db, "INSERT INTO id_verification (userID, IdType, date_created) VALUES('$username', 'User', now())")) {
			  echo "New id_verification created successfully";
			} else {
			  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			if (mysqli_query($db, "INSERT INTO syst_acct VALUES ('$username', '$password')")) {
			  echo "New id_verification created successfully";
			}else {
			  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			$_user = getUserById($username);

			echo "<script> alert('". implode($_user) ."'); </script>";
			$_SESSION['user'] = $_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');
		}
	}
	// return user array from their id
	function getUserById($id){
		global $db;
		$results = mysqli_query($db, "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.userID inner join user u on u.userID = sa.username WHERE sa.Username='$id' LIMIT 1 ");
		if (mysqli_num_rows($results) == 1) {
			$user = mysqli_fetch_assoc($results);
		}
		return $user;
		$mysqli -> close();
	}
	// LOGIN USER
	function login(){
		global $db, $errors;

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

	function emplogin(){
		global $db, $errors;

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

			$query = "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.username = iv.userID inner join employee emp on emp.empID = sa.username WHERE sa.Username='$username' AND Password='$password1' LIMIT 1";
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
		}elseif(!filter_var($guestMail, FILTER_VALIDATE_EMAIL)) {
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

			$query = "INSERT INTO id_verification (userID, IdType, date_created)
			VALUES('$logged_in_user_id', 'Guest', now())";
			$results = mysqli_query($db, $query) or die(mysqli_error());

			$_SESSION['user'] =  getGuestById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in as Guest";

			header('location: guestHomepage.php');
			$mysqli -> close();
		}
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

	function isLoggedIn(){
		if (isset($_SESSION['user']) && $_SESSION['user']['IDType'] == 'User') {
			return true;
		}else{
			return false;
		}
	}

	function isGuest(){
		if (isset($_SESSION['user']) && $_SESSION['user']['IDType'] == 'guest' ) {
			return true;
		}else{
			return false;
		}
	}
	function isAgent(){
		if (isset($_SESSION['user']) && $_SESSION['user']['IDType'] == 'Agent' ) {
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

	function fillNatureOfComplaint(){
			global $db;

			$sql = mysqli_query($db,"SELECT * from complaint_list") or die (mysqli_error());

			while ($row = mysqli_fetch_assoc($sql)) {
				echo "<option value=" . $row['complaintID'] . ">". $row['Detail'] ."</option>";
			}
	}

	function generateTicketID(){
		global $db;

		$ticketno = 0;
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%y%m%d') as datenow, lpad(count(*) + 1,3,'0') as complaintcount from complaints limit 1") or die (mysqli_error());
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['datenow'] . $result['complaintcount'],9,"0");
		}
		return $ticketno;
	}

	function submitTicket(){
		global $db, $errors;

		$complaint = $_POST['inputComplaint'];
		$description = $_POST['ndesc'];
		$region = $_POST['inputRegion'];
		$province = $_POST['inputProvince'];
		$citymun = $_POST['inputCityMun'];
		$brgy = $_POST['inputBrgy'];
		$purok  = $_POST['purokname'];

		if($complaint === "-- Complaint --"){
			array_push($errors, "Choose your complaint");
		}
		if (empty($description)) {
			array_push($errors, "Please add remarks on your complaint.");
		}
		if ($region === "-- Choose Region --" || $province	=== "-- Choose Province --" || $citymun === "-- Choose City/Municipal --" || $brgy === "-- Choose Barangay --" || empty($purok)) {
			array_push($errors, "Please properly fill out your address.");
		}

		if(count($errors) == 0){
			$queryAddress = "INSERT INTO address (cRegion, cProvince, cCityMun, cBrgy, cPurok) values ('$region', '$province', '$citymun', '$brgy', '$purok')";
			$results = mysqli_query($db,$queryAddress) or die(mysqli_error());

			$addressID = mysqli_insert_id($db);

			$trackno = generateTicketID();
			$queryComplaint = "INSERT INTO complaints (complaintNo, description, location, Nature_of_Complaint) values ('$trackno', '$description', '$addressID', '$complaint')";
			$results = mysqli_query($db,$queryComplaint) or die(mysqli_error());

			$user = (isset($_SESSION['user']['UserID']))? $_SESSION['user']['UserID'] : "Empty";
			$queryComplaint = "INSERT INTO user_complaint (complaintID, ComplaintNo, Date_Time_Complaint) values ('$user', '$trackno', now())";
			$results = mysqli_query($db,$queryComplaint) or die(mysqli_error());

			$_SESSION['success'] = 'Success';
			if($_SESSION['user']['IDType'] === 'Guest'){
				header('location: guestHomepage.php' . "?submit=1&trackno=". $trackno ."");
			}elseif ($_SESSION['user']['IDType'] === "User") {
				header('location: index.php' . "?submit=1&trackno=". $trackno ."");
			}
		}
	}


	function fillComplaintTable(){
		global $db;
		// $queryColumn = "SELECT Count(*) as 'complaintColumn' from information_schema.columns where complaints c inner join address a on c.location = a.addressNo "
		$queryAddress = "SELECT * FROM complaints c inner join address a on c.location = a.addressNo";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0){
			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['ComplaintNo'] . "</td>";
				echo "<td>" . $row['Nature_of_Complaint'] . "</td>";
				echo "<td>" . $row['Description'] . "</td>";
				echo "<td>" . $row['cRegion'] . "</td>";
				echo "<td>" . $row['cProvince'] . "</td>";
				echo "<td>" . $row['cCityMun'] . "</td>";
				echo "<td>" . $row['cBrgy'] . "</td>";
				echo "</tr>";
			}
		}
	}

	function fillSearchTable($id){
		global $db;
		// $queryColumn = "SELECT Count(*) as 'complaintColumn' from information_schema.columns where complaints c inner join address a on c.location = a.addressNo "
		$queryAddress = "SELECT * FROM complaints c inner join address a on c.location = a.addressNo where c.complaintID = " . $id;
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0){
			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['ComplaintNo'] . "</td>";
				echo "<td>" . $row['Nature_of_Complaint'] . "</td>";
				echo "<td>" . $row['Description'] . "</td>";
				echo "<td>" . $row['cRegion'] . "</td>";
				echo "<td>" . $row['cProvince'] . "</td>";
				echo "<td>" . $row['cCityMun'] . "</td>";
				echo "<td>" . $row['cBrgy'] . "</td>";
				echo "</tr>";
			}
		}
	}
?>
