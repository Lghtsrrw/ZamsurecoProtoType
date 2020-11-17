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

	if (isset($_SESSION['user']) && $_SESSION['user']['IDType'] == 'Guest') {
		// session timeout
		$time = $_SERVER['REQUEST_TIME'];

		$timeout_duration = 1800;

		if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
	    session_unset();
	    session_destroy();
			session_start();
		}

		$_SESSION['LAST_ACTIVITY'] = $time;
		// end of session time
	}
	// variable declaration
	$errors = array();

	// call the userRegister() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		userRegister();
	}

	if(isset($_POST['guestbtn'])){
		guest();
	}

	if (isset($_GET['logout'])) {
		unset($_SESSION['user']);
		session_destroy();
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
	function userRegister(){
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
      array_push($errors, "Please check your Account Number. Account number must be 10-digit");
    }
		if (empty($email)) {
			array_push($errors, "Email is required");
		}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			array_push($errors, "Invalid Email address");
  	}
		if (empty($password1) || strlen(trim($password1)) < 4){
			array_push($errors, "Password must be atleast 8 characters and maximum of 16 characters.");
		}
		if ($password1 != $password2) {
			array_push($errors, "The two passwords do not match");
		}
		if(empty($fname) || empty($lname)){
			array_push($errors,"Fill-up your First name and Last name");
		}
		if(empty($address)){
			array_push($errors, "Fill-up your address");
		}
		if(strlen($_POST["contact"]) != 11 || empty($_POST['contact'])){
				array_push($errors, "Properly fill-up your contact-number");
		}
		// register user if there are no errors in the form
    if (count($errors) == 0) {
			$password = md5($password1);//encrypt the password before saving in the database
			if (mysqli_query($db, "INSERT INTO user (UserID, Fname, Mname, Lname, Address, Contact, AcctNo, email) VALUES('$username','$fname','$mname','$lname','$address','$contact','$regAcctNo','$email')")) {
        console_log("New user created successfully");
			} else {
			  echo "Error:<br>" . mysqli_error($db);
			}
			if (mysqli_query($db, "INSERT INTO id_verification (UserID, IDType, Date_created) VALUES('$username', 'User', now())")) {
        console_log( "New id_verification created successfully");
			} else {
			  echo "Error:<br>" . mysqli_error($db);
			}
			if (mysqli_query($db, "INSERT INTO syst_acct (username, password, userid) VALUES ('$username', '$password', '$username')")) {
			  console_log( "New id_verification created successfully");
			}else {
			  echo "Error:<br>" . mysqli_error($db);
			}
			$_user = getUserById($username);
			$_SESSION['user'] = $_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');
		}
	}

	// return user array from their id
	function getUserById($id){
		global $db;
		$results = mysqli_query($db, "SELECT * FROM syst_acct sa INNER JOIN id_verification iv on sa.userid = iv.userID inner join user u on u.userID = sa.userid WHERE sa.username='$id' LIMIT 1 ");
		if (mysqli_num_rows($results) == 1) {
			$user = mysqli_fetch_assoc($results);
		}
		return $user;
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

			$query = "SELECT * FROM syst_acct sa
								INNER JOIN id_verification iv
								ON sa.userid = iv.userID
								INNER JOIN user u
								ON u.userID = sa.userid
								WHERE sa.username='$username' AND sa.password='$password1' LIMIT 1";
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

			$query = "SELECT * FROM syst_acct sa
								INNER JOIN id_verification iv
								ON sa.username = iv.userID
								INNER JOIN employee emp
								ON emp.empID = sa.userid
								WHERE sa.username='$username'
								AND sa.password='$password1' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
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
			array_push($errors, "<b>GUEST: </b>Guest-name is required");
		}

		if (empty($guestMail)) {
			// array_push($errors, "Your email is required");
			$guestMail='';
		}elseif(!filter_var($guestMail, FILTER_VALIDATE_EMAIL)) {
			array_push($errors, "<b>GUEST: </b>Invalid Email address");
  	}

		if (empty($gcontact) || strlen($gcontact) < 11) {
			array_push($errors, "<b>GUEST: </b>Your contact-number is either missing or invalid. Please properly fill up your contact.");
		}
		if (empty($gaddress)) {
			array_push($errors, "<b>GUEST: </b>Your Address is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {

			$query = "INSERT INTO guest (name, address, contact, email)
								VALUES('$guestname', '$gaddress', '$gcontact', '$guestMail')";
			$results = mysqli_query($db, $query)  or die(mysqli_error($db));

			$logged_in_user_id = mysqli_insert_id($db);

			$query = "INSERT INTO id_verification (userID, IdType, date_created)
								VALUES('$logged_in_user_id', 'Guest', now())";
			$results = mysqli_query($db, $query) or die(mysqli_error($db));

			$_SESSION['user'] =  getGuestById($logged_in_user_id); // put logged in user in session

			$_SESSION['success']  = "You are now logged in as Guest";
			$_SESSION['LAST_ACTIVITY'] = $time;
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

	function isSupport(){
		if (isset($_SESSION['user']) && $_SESSION['user']['IDType'] == 'Support' ) {
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

	function fillNatureOfComplaint(){
			global $db;

			$sql = mysqli_query($db,"SELECT * from complaint_list") or die (mysqli_error($db));

			while ($row = mysqli_fetch_assoc($sql)) {
				echo "<option >". $row['Detail'] ."</option>";
			}
	}

	function generateTicketID(){
		global $db;

		$ticketno = 0;
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%y%m%d') as datenow, lpad(count(*) + 1,3,'0') as complaintcount from complaints limit 1") or die (mysqli_error($db));
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['datenow'] . $result['complaintcount'],9,"0");
		}
		return $ticketno;
	}

	function generateEmployeeID(){
		global $db;
		$ticketno = 0;
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%y%m%d') as datenow, lpad(count(*) + 1,3,'0') as employeecount from employee limit 1") or die (mysqli_error($db));
		$result = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
			$ticketno = str_pad($result['datenow'] . $result['employeecount'],8,"0");
		}
		return 'E' . $ticketno;
	}

	if (isset($_POST['nTicketbtn'])) {
		submitTicket();
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
    $trackno = generateTicketID();

    $empname = $_POST['inputemployeename'];

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

      if ($complaint !== 'Attitude of Employee') {
        $queryAddress = "INSERT INTO address (cRegion, cProvince, cCityMun, cBrgy, cPurok) values ('$region', '$province', '$citymun', '$brgy', '$purok')";
  			$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
  			$addressID = mysqli_insert_id($db);

  			$queryComplaint = "INSERT INTO complaints (complaintNo, description, location, Nature_of_Complaint, Area_Landmark) values ('$trackno', '$description', '$addressID', '$complaint','$purok')";
  			$results = mysqli_query($db,$queryComplaint) or die(mysqli_error($db));
      }else {
  			$queryComplaint = "INSERT INTO complaints (complaintNo, description, location, Nature_of_Complaint, Area_Landmark)
                          VALUES ('$trackno', '$description', '$empname', '$complaint','$purok')";
  			$results = mysqli_query($db,$queryComplaint) or die(mysqli_error($db));
      }

      $user = (isset($_SESSION['user']['UserID']))? $_SESSION['user']['UserID'] : "Empty";
      $queryUserComplaint = "INSERT INTO user_complaint (complaintID, ComplaintNo, Date_Time_Complaint) values ('$user', '$trackno', now())";
      $results = mysqli_query($db,$queryUserComplaint) or die(mysqli_error($db));

      // initiating status for this complaint ticket.
      savetoComplaintStatus($user, 'Waiting for verificaton from Agent', $trackno, 'Ticket has been submitted and is subject for review.');

      $_SESSION['submit'] = "1";
      $_SESSION['trackno'] = $trackno;
      header('location: index.php');
		}
	}

	function fillComplaintTable(){
		global $db;
		$queryAddress = "SELECT *,c.location as 'loca' FROM complaints c
                    LEFT OUTER JOIN address a ON c.location = a.addressNo
                    LEFT JOIN complaint_assign ca ON c.ComplaintNo = ca.complaintno
                    WHERE ca.complaintno is null
                    ORDER BY c.ComplaintNo DESC";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0){
			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['ComplaintNo'] . "</td>";
				echo "<td>" . $row['Nature_of_Complaint'] . "</td>";
				echo "<td>" . $row['Description'] . "</td>";
				echo "<td>" . $row['loca'] . "</td>";
				echo "<td>" . $row['cRegion'] . "</td>";
				echo "<td>" . $row['cProvince'] . "</td>";
				echo "<td>" . $row['cCityMun'] . "</td>";
				echo "<td>" . $row['cBrgy'] . "</td>";
				echo "<td>" . $row['Area_Landmark'] . "</td>";
				echo "</tr>";
			}
		}
	}

	function fillSearchTable($id){
		global $db;
		$queryAddress = "SELECT *,c.location as 'loca' FROM complaints c
										LEFT OUTER JOIN address a ON c.location = a.addressNo
										LEFT JOIN complaint_assign ca ON c.ComplaintNo = ca.complaintno
										WHERE (ca.complaintno is null)
										AND (c.complaintNo LIKE '%" . $id . "%'
										OR description LIKE '%" . $id . "%'
										OR cregion LIKE '%" . $id . "%'
										OR cprovince LIKE '%" . $id . "%'
										OR cCityMun LIKE '%". $id . "%'
										OR cBrgy LIKE '%" . $id . "%'
										OR Nature_of_Complaint LIKE '%". $id ."%')";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0){
			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['ComplaintNo'] . "</td>";
				echo "<td>" . $row['Nature_of_Complaint'] . "</td>";
				echo "<td>" . $row['Description'] . "</td>";
				echo "<td>" . $row['loca'] . "</td>";
				echo "<td>" . $row['cRegion'] . "</td>";
				echo "<td>" . $row['cProvince'] . "</td>";
				echo "<td>" . $row['cCityMun'] . "</td>";
				echo "<td>" . $row['cBrgy'] . "</td>";
        echo "<td>" . $row['Area_Landmark'] . "</td>";
				echo "</tr>";
			}
		}else {
			echo "<h3 style='color:red'>No Result</h3>";
		}
	}

	function fillEmpListTable(){
		global $db;
		$queryAddress = "SELECT EmpID, concat(fname, ' ', mname,' ',lname)as'Name', Area, Dept  FROM employee";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
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

		$username = $_POST['txtEmpUsername'];
		$psw = $_POST['txtEmpPass'];
		echo $psw;
		$password = md5($psw);

		if(empty($_POST['txtFname'])){
			array_push($errors, "Insert your First-name");
		}
		if(empty($_POST['txtMname'])){
			$mname = '';
		}
		if(empty($_POST['txtLname'])){
			array_push($errors, "Insert your Last-name");
		}
		if(empty($_POST['txtArea'])){
			array_push($errors, "Fill in Area-location");
		}
		if(empty($_POST['txtDept'])){
			array_push($errors, "Insert your department");
		}

		if(count($errors) == 0){
			// save to Employee Table
			if ( mysqli_query($db,"INSERT INTO employee values ('$empid', '$fname', '$mname', '$lname', '$area', '$dept')")) {
				echo "New support created";
			}else {
			 echo "Error:<br>" . mysqli_error($db);
			}
			// save to System Account Table
			if (mysqli_query($db, "INSERT INTO syst_acct VALUES ('$username', '$password', '$empid')")) {
				echo "New support account created";
			}else {
				echo "Error:<br>" . mysqli_error($db);
			}
			// save to ID Verification Table
			if (mysqli_query($db, "INSERT INTO id_verification VALUES ('$username', now(), 'Support')")) {
				echo "New support account created";
			}else {
				echo "Error:<br>" . mysqli_error($db);
			}

			$_SESSION['savedsupp'] = $empid;
			header('location: employeeAgent.php');
		}
	}

	function retrieveEmployeeList(){
		global $db;
		$queryAddress = "SELECT *, concat(fname, ' ',mname,' ',lname)as 'name' FROM employee";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
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
		$results = mysqli_query($db, "SELECT date_format(curdate(), '%d%m%y') as 'datenow', lpad(count(*) + 1,2,'0') as 'areacount' from complaint_receiver limit 1") or die (mysqli_error($db));
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
		$results = mysqli_query($db, "SELECT lpad(count(*) + 1,4,'0') as areacount from complaint_receiver limit 1") or die (mysqli_error($db));
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
				$_SESSION['savesupp'] = 'Success';
				header('location: employeeAgent.php');
			} else {
				echo "Error: <br>" . mysqli_error($db);
			}
		}
	}

	function fillCmplntHndlrLocation(){
		global $db;
		$queryAddress = "SELECT DISTINCT city_mun from receiver_area_coverage";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0)
		{
			echo "<table id='tblLocation'>
						<tr>
							<th>City/Municipal</th>
						</tr>";
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<tr>";
				echo "<td>" . $row['city_mun'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else {
			echo "<div style='width:100%; text-align:center'><h5 style='color:red;'>No available data</h5></div>";
		}
	}

	// Check if the location value passed from the client side
	if(isset($_POST['locationvalue']) && !empty($_POST['locationvalue'])){
		fillCmplntHndlrOffice($_POST['locationvalue']);
	}

	function fillCmplntHndlrOffice($cityMun){
		if(!empty($cityMun)){
			global $db;
			$queryAddress = "SELECT DISTINCT office
			-- , rac.area_coverage_no as 'area'
											FROM complaint_receiver cr
											INNER JOIN receiver_area_coverage rac
											ON cr.area_coverage_no = rac.area_coverage_no
											WHERE rac.city_mun = '$cityMun'";
			$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
			if(mysqli_num_rows($results) > 0)
			{
				echo "<fieldset style='height:250px; overflow:auto'>";
				echo "<legend>Office</legend>";
				echo "<div class='div4Table'>";
				echo "<table id='tblOffices'>";
				echo "<tr>";
				echo "<th>Office</th>";
				// echo "<th>Code</th>";
				echo "</tr>";
				while ($row = mysqli_fetch_assoc($results))
				{
					echo "<tr>";
					echo "<td>" . $row['office'] . "</td>";
					// echo "<td>" . $row['area'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
				echo "</fieldset>";
			}
			return true;
		}else {
			return false;
		}
	}

	// Check if the emp support details value passed from the client side
	if(isset($_POST['officeval']) && isset($_POST['cityval'])){
		fillCmplntHndlrEmp($_POST['cityval'],$_POST['officeval']);
		// echo $_POST['officeval']. ' '. $_POST['cityval'];
	}

	function fillCmplntHndlrEmp($city, $val){
		if(!empty($val) && !empty($city)){
			global $db;

			$queryAddress = "SELECT e.EmpID,
															concat(fname,' ',lname)as'fullname',
															office, contact,
															complaintid as 'complainthandling'
											FROM complaint_receiver cr
											INNER JOIN receiver_area_coverage rac
											ON cr.area_coverage_no = rac.area_coverage_no
											INNER JOIN employee e
											ON e.EmpID = cr.empid
											WHERE rac.city_mun = '$city' and cr.office = '$val'";
			$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
			if(mysqli_num_rows($results) > 0)
			{

				echo "<div style='display:block'>";
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
					echo "<td>" . $row['EmpID'] . "</td>";
					echo "<td>" . $row['fullname'] . "</td>";
					echo "<td>" . $row['office'] . "</td>";
					echo "<td>" . $row['contact'] . "</td>";
					echo "<td>" . $row['complainthandling'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
			}else {
				echo "<p style='color:red; float:center'>No assigned complaint yet</p>";
			}
			return true;
		}else {
			echo "Entry Empty";
		}
	}

	if (isset($_POST['_acctNo'])) {
		echo ifBillExist($_POST['_acctNo']);
	}
	function ifBillExist($val){
		global $db;
		$queryAddress = "SELECT * from bill
										WHERE AccountNo = '$val'";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
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
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
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

	function userComplaintTable($val){
		global $db;

		echo "<tr>";
		echo "<th>Complaint No</th>";
		echo "<th>Date created</th>";
			echo "<th>Description</th>";
			echo "<th>Nature of complaint</th>";
			echo "<th>Location ID / Complainee</th>";
			echo "<th>STATUS</th>";
		echo "</tr>";

		$queryAddress = "SELECT c.ComplaintNo as 'No',
														Description,
														Nature_of_Complaint,
														-- CONCAT(cregion, ', ',cprovince,', ',ccitymun,', ',cbrgy) AS 'Location',
                           c.location,
														Date_Time_Complaint,
                            (select Status from complaint_status where complaintno = c.ComplaintNo order by status_datetime desc limit 1)as _Status
										FROM complaints c
										INNER JOIN user_complaint uc ON c.ComplaintNo = uc.ComplaintNo
										LEFT OUTER JOIN address a ON a.addressno = c.location
										INNER JOIN user u ON u.userID = uc.complaintID
										WHERE uc.complaintID = '$val'
										ORDER BY c.ComplaintNo desc";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<tr>";
				echo "<td>". $row['No'] ."</td>";
				echo "<td>". $row['Date_Time_Complaint'] ."</td>";
				echo "<td>". $row['Description'] ."</td>";
				echo "<td>". $row['Nature_of_Complaint'] ."</td>";
				echo "<td>". $row['location'] ."</td>";
				echo "<td>". $row['_Status'] ."</td>";
				echo "<td></td>";
				echo "</tr>";
			}
		}
	}

	function fillAssignedComplaint($val){
		global $db;
		$queryAddress = "SELECT DISTINCT
                            c.complaintno,
														description,
														Nature_of_Complaint,
														concat(cRegion,', ',cProvince,', ', cCityMun,', ',cBrgy)
												AS 'loca',
                            c.location
                        AS 'locaII',
														Area_landmark,
														datetime_assigned,
														empid_agent,
                            (SELECT Status FROM complaint_status cs where cs.complaintno = c.complaintno ORDER BY cs.status_datetime DESC limit 1) as 'Status'
										FROM complaints c
										LEFT OUTER JOIN address a
										ON a.addressno = c.location
										INNER JOIN complaint_assign ca
										ON c.complaintno = ca.complaintno
										WHERE ca.empid_support = '$val'";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0){
			echo "<table border='1' id='tblData'>";
			echo "<tr>";
			echo "<th>Complaint No</th>";
			echo "<th>Description</th>";
			echo "<th>Nature of Complaint</th>";
			echo "<th>Location / Complainee</th>";
			echo "<th>Area Landmark</th>";
			echo "<th>Date Assigned</th>";
			echo "<th>Assignee</th>";
			echo "</tr>";

			while ($row = mysqli_fetch_assoc($results)) {
          if ($row['Status'] !== 'Resolved') {
            echo "<tr>";
    				echo "<td>" . $row['complaintno'] . "</td>";
    				echo "<td>" . $row['description'] . "</td>";
    				echo "<td>" . $row['Nature_of_Complaint'] . "</td>";
    				echo "<td>" . $row['loca'] . ': '. $row['locaII'] . "</td>";
    				echo "<td>" . $row['Area_landmark'] . "</td>";
    				echo "<td>" . $row['datetime_assigned'] . "</td>";
    				echo "<td>" . $row['empid_agent'] . "</td>";
    				echo "</tr>";
          }
			}
			echo "</table>";
		}else {
			echo "<p style='color:red; float:center'>No assigned complaint yet</p>";
		}
	}

	if (isset($_POST['natureofcomplaint']) && isset($_POST['citymunicipal'])) {
		displayPossibleComplaintReceiver($_POST['natureofcomplaint'], $_POST['citymunicipal']);
		// echo $_POST['natureofcomplaint'] . ' '. $_POST['citymunicipal'];
	}
	function displayPossibleComplaintReceiver($nature, $citymun){
		global $db;

		$queryAddress = "SELECT DISTINCT	e.empid 'employee',
																			concat(fname, ' ', lname) as 'name',
																			c.Nature_of_Complaint 'noc',
																			city_mun,
																			brgy
										FROM complaint_receiver cr
										INNER JOIN complaints c
											ON cr.complaintID = c.Nature_of_Complaint
										INNER JOIN receiver_area_coverage rac
											ON cr.area_coverage_no = rac.area_coverage_no
										INNER JOIN employee e
											ON cr.empid = e.EmpID
										WHERE c.Nature_of_Complaint = '$nature'
											AND city_mun = '$citymun'";

		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0){

			echo "<table border='1' id='compHandler'>";
			echo "<tr>";
			echo "<th>Employee ID</th>";
			echo "<th>Employee Name</th>";
			echo "<th>Nature of Complaint</th>";
			echo "<th>City/Municipal</th>";
			echo "<th>Barangay</th>";
			echo "</tr>";

			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['employee'] . "</td>";
				echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['noc'] . "</td>";
				echo "<td>" . $row['city_mun'] . "</td>";
				echo "<td>" . $row['brgy'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else {
				echo "<p style='color:red; float:center'>No possible receiver</p>";
		}
	}

	if (isset($_POST['btnTrackComplaint'])) {
		fillTrackRecord($_POST['btnTrackComplaint']);
	}
	function fillTrackRecord($val){
		global $db;

		$queryAddress = "SELECT Status,
														remarks,
														status_datetime,
														CONCAT(e.fname,' ', e.lname) as 'handler'
										FROM complaint_status cs
										INNER JOIN employee e
										ON cs.empid = e.EmpID
										WHERE complaintno = '$val'";

		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0){

			echo "<table border='1' id='tblData'>";
			echo "<tr>";
			echo "<th>Status</th>";
			echo "<th>Remarks</th>";
			echo "<th>DateTime Updated</th>";
			echo "<th>Employee ID Handler</th>";
			echo "</tr>";

			while ($row = mysqli_fetch_assoc($results)) {
				echo "<tr>";
				echo "<td>" . $row['Status'] . "</td>";
				echo "<td>" . $row['remarks'] . "</td>";
				echo "<td>" . $row['status_datetime'] . "</td>";
				echo "<td>" . $row['handler'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else {
				echo "<p style='color:red; float:center'>No action taken yet.</p>";
		}
	}

	if(isset($_POST['complaintno']) && isset($_POST['empidsupp'])){
		assignEmployeeSupport($_POST['complaintno'], $_POST['empidsupp']);
	}
	function assignEmployeeSupport($val1, $val2){
		global $db;

		$agentid = $_SESSION['user']['EmpID'];

		$queryAssignComplaint = "INSERT INTO complaint_assign (complaintno, empid_agent, empid_support, datetime_assigned) values ('$val1', '$agentid','$val2', now())";
		$results = mysqli_query($db,$queryAssignComplaint) or die(mysqli_error($db ));

    savetoComplaintStatus($agentid, 'Dispatched to personnel-in-charge', $val1, 'Complaint has been dispatched to the appropriate personnel for immediate action.');
		echo "Successfully Assigned";
	}

	function fillEmpSupportList(){
		global $db;

		$queryAddress =	"SELECT * FROM syst_acct sa
										INNER JOIN id_verification iv
										ON sa.username = iv.UserID
										INNER JOIN employee e
										ON sa.userid = e.EmpID
										WHERE IDType = 'Support' ";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo "<option value = '". $row['userid'] ."'>". $row['Fname'].' '. $row['Lname'] ."</option>";
			}
		}
	}

	if (isset($_POST['suppempid'])) {
		$queryAddress = "SELECT * FROM employee WHERE EmpID = '" . $_POST['suppempid'] . "'";
		$results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
		if(mysqli_num_rows($results) > 0)
		{
			while ($row = mysqli_fetch_assoc($results))
			{
				echo $row['Fname'] .' '. $row['Lname'];
			}
		}
	}

	if(isset($_POST['_oldpassword']) && isset($_POST['_newpassword'])){
		updateSupportPassword($_POST['_oldpassword'], $_POST['_newpassword']);
	}

	function updateSupportPassword($val1, $val2){
		global $db;
		if(md5($val1) != $_SESSION['user']['password']){
				echo "InvalidPreviousPassword";
		}else if($val1 == $val2) {
			echo "invalidOldAndNew";
		}else {
			$encryptedPassword = md5($val2);
			$query = "UPDATE syst_acct
								SET password = '$encryptedPassword'
								WHERE username = '".$_SESSION['user']['username']."'";
			$results = mysqli_query($db, $query) or die(mysqli_error($db));
			 $_SESSION['user']['password'] = $encryptedPassword;
			 echo "Updated Successfully";
			$_SESSION['success'] = "Password updated successfully";
			header('location: index.php');
		}
	}

  function savetoComplaintStatus($empid,$status,$complaintno,$remarks){
    global $db;

    $sqlQuery = "INSERT INTO complaint_status
                VALUES ('$empid',now(),'$status','$complaintno','$remarks') ";
    if (mysqli_query($db, $sqlQuery)) {
      console_log("Status has been updated successfully");
    } else {
      echo "Error:<br>" . mysqli_error($db);
    }
  }

  if(isset($_POST['btnUpdateStatus'])){
    savetoComplaintStatus($_SESSION['user']['EmpID'], $_POST['inSupportStatus'], $_POST['inSupportComplaintNo'], $_POST['inSupportRemarks']);
    unset($_POST['btnUpdateStatus']);
  }

  function console_log($data){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  if(isset($_POST['queryBrgy'])){
     retrieveRefBrgy($_POST['queryBrgy']);
     // console_log('Hello World');

  }

  function retrieveRefBrgy($val){
    global $db;
    $arrBrgy = array();
    $sql = mysqli_query($db,"SELECT * from refbrgy where citymunCode = '$val'") or die (mysqli_error($db));
    while ($row = mysqli_fetch_assoc($sql)) {
      // echo $row['brgyDesc'] ;
      array_push($arrBrgy, $row['brgyDesc']);
    	// echo "<option value='". $row[  'brgyDesc'] ."'>";
      // console_log($row['brgyDesc']);
    }
    echo json_encode($arrBrgy);
  }
?>
