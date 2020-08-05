<?php
include('databaseConnection/databaseConnection.php');

if (!empty(isset($_SESSION['user'])) && $_SESSION['user']['IDType']==='Guest') {
	header('location: guestHomepage.php');
}elseif(empty(isset($_SESSION['user']))){
	header('location: signin.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
    <title>Zamzureco-1</title>
  </head>
  <body>
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php
						echo $_SESSION['success'] . ' as ';
						echo ucfirst($_SESSION['user']['username']);
					?>
				</h3>
			</div>
		<?php endif ?>
    <h1>User's Homepage</h1>

		<a href="index.php?logout='1'" style='color:red;'>Logout</a>
  </body>
</html>
