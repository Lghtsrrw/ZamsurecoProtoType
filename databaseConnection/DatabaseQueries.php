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
	$errors = array();

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
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

	// Check if the username is already in the system.
	function checkUsername($_username){
			global $db, $errors;
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

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
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


	if (isset($_POST['btnEmpLogin'])) {
		empLogin();
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

	function generateEmployeeID(){
		global $db;
		$ticketno = 0;
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%y%m%d') as datenow, lpad(count(*) + 1,3,'0') as employeecount from employee limit 1") or die (mysqli_error());
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['datenow'] . $result['employeecount'],8,"0");
		}
		return 'E' . $ticketno;
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
			$queryComplaint = "INSERT INTO complaints (complaintNo, description, location, Nature_of_Complaint, Area_Landmark) values ('$trackno', '$description', '$addressID', '$complaint','$purok')";
			$results = mysqli_query($db,$queryComplaint) or die(mysqli_error());

			$user = (isset($_SESSION['user']['UserID']))? $_SESSION['user']['UserID'] : "Empty";
			$queryUserComplaint = "INSERT INTO user_complaint (complaintID, ComplaintNo, Date_Time_Complaint) values ('$user', '$trackno', now())";
			$results = mysqli_query($db,$queryUserComplaint) or die(mysqli_error());

			$_SESSION['submit'] = "1";
			$_SESSION['trackno'] = $trackno;
			if($_SESSION['user']['IDType'] === 'Guest'){
				header('location: guestHomepage.php');
			}elseif ($_SESSION['user']['IDType'] === "User") {
				header('location: index.php');
			}
		}
	}

	function fillComplaintTable(){
		global $db;
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
		$queryAddress = "SELECT * FROM complaints c
						INNER JOIN address a ON c.location = a.addressNo
						WHERE c.complaintNo LIKE '%" . $id . "%'
						OR description LIKE '%" . $id . "%'
						OR cregion LIKE '%" . $id . "%'
						OR cprovince LIKE '%" . $id . "%'
						OR cCityMun LIKE '%". $id . "%'
						OR cBrgy LIKE '%" . $id . "%'
						OR Nature_of_Complaint LIKE '%". $id ."%'";
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

	function fillEmpListTable(){
		global $db;
		$queryAddress = "SELECT EmpID, concat(fname, ' ', mname,' ',lname)as'Name', Area, Dept  FROM employee";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<tr>";
				echo "<td>" . $row['EmpID'] . "</td>";
				echo "<td>" . $row['Name'] . "</td>";
				echo "<td>" . $row['Area'] . "</td>";
				echo "<td>" . $row['Dept'] . "</td>";
				echo "</tr>";
			}
		}
	}

	if (isset($_POST['btnSaveEmpSupp'])) {
		saveRegisteredEmployeeSupp();
	}

	function saveRegisteredEmployeeSupp(){
		global $db, $errors;

		$empid = generateEmployeeID();
		$fname = $_POST['txtFname'];
		$mname = $_POST['txtMname'];
		$lname = $_POST['txtLname'];
		$area = $_POST['txtArea'];
		$dept = $_POST['txtDept'];

		if(empty($_POST['txtFname'])){
			array_push($errors, "Insert your FirstName");
		}
		if(empty($_POST['txtMname'])){
			array_push($errors, "Insert your Middle Initial");
		}
		if(empty($_POST['txtLname'])){
			array_push($errors, "Insert your LastName");
		}
		if(empty($_POST['txtArea'])){
			array_push($errors, "Fill in Area Location");
		}
		if(empty($_POST['txtDept'])){
			array_push($errors, "Insert your Department");
		}

		if(count($errors) == 0){
			$query = "INSERT INTO employee values ('$empid', '$fname', '$mname', '$lname', '$area', '$dept')";
			$results = mysqli_query($db,$query) or die(mysqli_error());
			$_SESSION['savedsupp'] = $empid;
			header('location: employeeAgent.php');
		}
	}

	function retrieveEmployeeList(){
		global $db;
		$queryAddress = "SELECT *, concat(fname, ' ',mname,' ',lname)as 'name' FROM employee";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<option value=".$row['EmpID'].">" . $row['name'] . "</option>";
			}
		}
	}

	function generateAreaCoverageNo(){
		global $db;
		$ticketno = 0;
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%d%m%y') as datenow, lpad(count(*) + 1,2,'0') as areacount from complaint_receiver limit 1") or die (mysqli_error());
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['datenow'] . $result['areacount'],8,"0");
		}
		return 'A' . $ticketno;
		$mysqli -> close();
	}

	function generateComplaintReceiverNo(){
		global $db;
		$ticketno = 0;
		$results = mysqli_query($db, "SELECT lpad(count(*) + 1,4,'0') as areacount from complaint_receiver limit 1") or die (mysqli_error());
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['areacount'],4,"0");
		}
		return 'C' . $ticketno;
		$mysqli -> close();
		}

	// saving 'Area Coverage Array' on manageDispatch Modal, when pressing  "Save"
	if(isset($_POST['paramName']) && isset($_POST['areaCovNo'])){
			$newArraythis = json_decode($_POST['paramName'], true);
			var_dump($newArraythis);
			printf($_POST['areaCovNo']);
			$areacovthis = $_POST['areaCovNo'];
			saveAreaCoverage( $newArraythis['Area'], $areacovthis);
			print_r('lol');
	}

	// saving Form on manageDispatch Modal, when pressing  "Save"
	if(isset($_POST['dsptMngBtn'])){
			saveComplaintReceiver();
	}
	function saveAreaCoverage($objName, $areacovNo){
		global $db;

		for($i = 0; $i < count($objName); $i++){
			$city = $objName[$i];
			if(mysqli_query($db, "INSERT INTO receiver_area_coverage (area_coverage_no, city_mun) VALUES ( '$areacovNo', '$city')")){
				printf( "Success Saving:"  . $city);
			} else {
				echo "Error: <br>" . mysqli_error($db);
			}
		}
	}

	function saveComplaintReceiver(){
		global $db, $errors;

		$compRecNo = generateComplaintReceiverNo();
		$compID = $_POST['hidComplaintNo'];
		$empid = $_POST['txtEmpID'];
		$empcontact = $_POST['inputEmpContact'];
		$areacovNO = $_POST['hidAreaCovNo'];
		$empoffice = $_POST['inputEmpOffice'];
		$areacovNo = generateAreaCoverageNo();
		$rowareacount = $_POST['rowAreaCov'];

		if($compID === "-- Complaint --"){
			array_push($errors, "Choose your complaint");
		}
		if(empty($_POST['txtEmpID'])) {
			array_push($errors, "Insert Employee ID");
		}
		if(empty($_POST['inputEmpContact'])) {
			array_push($errors, "Input Employee Contact");
		}
		if(empty($_POST['inputEmpOffice'])){
			array_push($errors, 'Input Employee designated office');
		}
		if($rowareacount <= 0){
			array_push($errors, 'select Area Coverage');
		}
		if(empty($areacovNo)) {
			array_push($errors, 'No Value Passed in AreaCovID');
		}

		if(count($errors) == 0){
			$query = "INSERT INTO
							complaint_receiver (
								complaint_receiver_No,
								ComplaintID,
								empid,
								contact,
								area_coverage_no,
								office
							) VALUES (
								'$compRecNo',
								'$compID',
								'$empid',
								'$empcontact',
								'$areacovNo',
								'$empoffice'
							)";
			if (mysqli_query($db, $query)){
				$_SESSION['success'] = 'Success';
				header('location: employeeAgent.php' . "?submit=1&CompRec=" . $compRecNo . "&areaCovno=" . $areacovNo ."");
			} else {
				echo "Error: <br>" . mysqli_error($db);
			}
		}
	}

	function fillCmplntHndlrLocation()
	{
		global $db;
		$queryAddress = "SELECT DISTINCT city_mun from receiver_area_coverage";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<tr>";
				echo "<td>" . $row['city_mun'] . "</td>";
				echo "</tr>";
			}
		}
	}

	// Check if the location value passed from the client side
	if(isset($_POST['locationvalue']) && !empty($_POST['locationvalue'])){
		fillCmplntHndlrOffice($_POST['locationvalue']);
	}

	function fillCmplntHndlrOffice($cityMun)
	{
		if(!empty($cityMun)){
			global $db;
			$queryAddress = "SELECT DISTINCT office, rac.area_coverage_no as 'Area'
											FROM complaint_receiver cr
											INNER JOIN receiver_area_coverage rac
											ON cr.area_coverage_no = rac.area_coverage_no
											WHERE rac.city_mun = '$cityMun'";
			$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
			if(mysqli_num_rows($results) > 0)
			{
				echo "<h3>Offices</h3>";
				echo "<table id='tblOffices'>";
				echo "<tr>";
				echo "<th>Office</th>";
				echo "<th>Code</th>";
				echo "</tr>";
				while ($row = mysqli_fetch_assoc($results))
				{
					echo "<tr>";
					echo "<td>" . $row['office'] . "</td>";
					echo "<td>" . $row['Area'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			return true;
		}else {
			return false;
		}
	}

	// Check if the emp support details value passed from the client side
	if(isset($_POST['officeval']) && isset($_POST['cityval'])){
		fillCmplntHndlrEmp($_POST['cityval'],$_POST['officeval']);
	}

	function fillCmplntHndlrEmp($city, $val){
		if(!empty($val) && !empty($city)){
			global $db;

			$queryAddress = "SELECT e.empid, concat(fname,' ',lname)as'fullname', office, contact, complaintid as 'Complaint Handling'
											FROM complaint_receiver cr
											INNER JOIN receiver_area_coverage rac
											ON cr.area_coverage_no = rac.area_coverage_no
											INNER JOIN EMPLOYEE E
											ON e.EmpID = cr.empid
											WHERE rac.city_mun = '$city' and cr.office = '$val'";
			$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
			if(mysqli_num_rows($results) > 0)
			{
				echo "<table id='tblempDetails'>";
				echo "<tr>";
				echo "<th>Employee ID</th>";
				echo "<th>Fullname</th>";
				echo "<th>Office</th>";
				echo "<th>Contact</th>";
				echo "<th>Complaint Handling</th>";
				echo "</tr>";
				while ($row = mysqli_fetch_assoc($results))
				{
					echo "<tr>";
					echo "<td>" . $row['empid'] . "</td>";
					echo "<td>" . $row['fullname'] . "</td>";
					echo "<td>" . $row['office'] . "</td>";
					echo "<td>" . $row['contact'] . "</td>";
					echo "<td>" . $row['Complaint Handling'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			return true;
		}else {
			return false;
		}
	}

	if (isset($_POST['_acctNo'])) {
		echo getBillExistence($_POST['_acctNo']);
	}

	function ifBillExist($val){
		global $db;
		$queryAddress = "SELECT * from bill
										WHERE AccountNo = '$val'";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) == 0)
		{
			$val = false;
		}else {
				$val = true;
		}
		return $val;
	}

	function displayBill($val){
		global $db;
		$queryAddress = "SELECT distinct * FROM bill
										WHERE AccountNo like '$val'";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error());
		if(mysqli_num_rows($results) > 0)
		{

			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<tr>";
				echo "<td>" . $row['PeriodCovered'] . "</td>";
				echo "<td>" . $row['KwHUsed'] . "</td>";
				echo "<td>" . $row['onDue'] . "</td>";
				echo "<td>" . $row['beforeDue'] . "</td>";
				echo "<td>" . $row['afterDue'] . "</td>";
				echo "<td>" . $row['DueDate'] . "</td>";
				echo "</tr>";
			}
		}
	}
?>
