<?php
require('databaseConnection/DatabaseQueries.php');
    if(empty(isset($_SESSION['user']))){
        header('location: signin.php');
    }

function fillBillReportTable(){
    global $db;
    $queryAddress = "SELECT * from receiptimage";
    $results = mysqli_query($db,$queryAddress) or die(mysqli_error($db));
    if(mysqli_num_rows($results) > 0){
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>";
            echo "<td><img src='data:image/jpg;charset=utf8;base64,". base64_encode($row['receiptimage']) . "' width = '50%' /> </td>";
            echo "<td>" . $row['uploaded'] . "</td>";
            echo "<td>" . $row['acctno'] . "</td>";
            echo "<td>" . $row['duedate'] . "</td>";
            echo "</tr>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/complaintTicket.js"></script>
    <title>Receipt Master-List</title>
</head>

<body style="background-color: #fcffe8">
    <div class="titleHeader" style="">
      <span class="headerText"><img src="img/logo.png" id="logotitle" style="float:left; height: 80px; width: 80px"></span>
      <span class="headerText"><b><label style="font-size:25px">Receipt Master-List</label></b></span>
    </div>

    <div style="border: 1px solid black; border-radius:1em; padding: 1em 3em 1em 3em; ">
        <h2>list of receipt</h2>
        <div class="tblAllData" style="overflow:auto">
          <div id="div4TableEmp">
            <table border ="1" id="tblData">
              <tr>
                <th>Receipt</th>
                <th>Submitted Date</th>
                <th>Account No.</th>
                <th>Due Date</th>
              </tr>
              <?php fillBillReportTable(); ?>
            </table>
          </div>
        </div>
    </div>
</body>
</html>
