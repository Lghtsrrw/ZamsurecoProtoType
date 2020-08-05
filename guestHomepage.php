<?php
  include('databaseConnection/databaseConnection.php');

  if (!empty(isset($_SESSION['user'])) && $_SESSION['user']['IDType']==='User') {
      header('location: index.php');
  }elseif(empty(isset($_SESSION['user']))){
    header('location: signin.php');
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="ico" href="/css/master.css">
    <title>Welcome Guest</title>
    <h1>Welcome Guest!</h1>
  </head>
  <body>
    <?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

    <a href="index.php?logout='1'" style='color:red;'>Logout</a>
  </body>
</html>
