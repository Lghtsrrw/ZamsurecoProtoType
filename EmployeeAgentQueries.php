<?php
if(isset($_POST['dsptMngBtn'])){
	// echo "<script>alert('HelloWorld');</script>";
}

if(isset($_POST['areaCovNo'])){
	$newArray = json_decode($_POST['paramName'], true);
	var_dump($newArray);
	echo $_POST['areaCovNo'];
}else {
	echo "No set";
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

function saveAreaCoverage($objName, $areacovNo){
	global $db;

	for($i = 0; $i < count($objName['Area']); $i++){
		$city = $objName['Area'][$i];
		if (mysqli_query($db, "INSERT INTO receiver_area_coverage (area_coverage_no, city_mun) VALUES ( '$areacovNo', '$city')")){
				echo "Success Saving:"  . $city;
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}
?>
