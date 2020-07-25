<?php
	include('databaseConnection/databaseConnection.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: signin.php');
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Zamzureco-1</title>
  </head>
  <body>
    <h1>User's Homepage</h1>

		<a href="index.php?logout='1'" style='color:red;'>Logout</a>
  </body>
</html>
