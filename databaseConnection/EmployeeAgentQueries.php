<?php
if(isset($_POST['dsptMngBtn'])){

}

if(isset($_GET['arrayEmpLocCov'])){
	$newArray = json_decode(stripslashes($_GET['arrayEmpLocCov']));
	echo $newArray;
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
}
?>
