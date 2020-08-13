<?php
    include("databaseConnection/databaseConnection.php");

    if(empty(isset($_SESSION['user']))){
        header('location: signin.php');
    }

    function populateRegion(){
      global $db;
      $sql = "SELECT regCode, regDesc FROM refRegion";
      $result = mysqli_query($db, $sql);
      while ($row = mysqli_fetch_array($result)) {
        echo "ddRegion.append('<option> ". $row['regDesc'] ."</option>');";
      }
    }

    function populateProvince(){
      global $db;
      if(isset($_POST['_region'])){
        $sql = "SELECT provDesc FROM refProvince rp inner join refregion rg on rp.regCode = rg.regCode where regDesc = " . $_POST['_region']  ;
        $result = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_array($result)) {
          echo "ddProvince.append('<option>". $row['provDesc'] ."</option>');";
        }
      }
      else {
        echo "alert('no data pass in _region from ajax')";
      }

    }

    function populateMunicipal($prov){
      global $db;
      $sql = "SELECT citymunDesc FROM refcitymun rcm inner join refProvince rp on rcm.provCode = rp.provCode where provDesc = '$prov'";
      $result = mysqli_query($db, $sql);
      while ($row = mysqli_fetch_array($result)) {
        echo "ddMunicipal.append('<option>". $row['citymunDesc'] ."</option>');";
      }
    }
    function populateBrgy($citymun){
      global $db;
      $sql = "SELECT brgyDesc FROM refbrgy rb inner join refcitymun rcm on rb.citymunCode = rcm.citymunCode where citymunDesc = '$citymun'";
      $result = mysqli_query($db, $sql);

      while ($row = mysqli_fetch_array($result)) {
        echo "ddBrgy.append('<option>". $row['brgyDesc'] ."</option>');";
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/webStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btnBack").click(function(){
          window.location.href = "signin.php";
        });
        let ddRegion = $('#ddRegion');
        ddRegion.empty();
        ddRegion.append('<option selected ="true" disabled>Choose Region</option>');
        <?php populateRegion(); ?>

        $('#ddRegion').change(function(){
          if($('#ddRegion').val() !== "Choose Region"){
            $('#divProvince').show(); //show hidden select Option for Province
            var _region = $('#ddRegion').val();
            $.ajax({
                type: "POST",
                url: 'complaintTicket.php',
                data: { hakdog : _region },
                success: function(data)
                {
                  alert (hakdog);
                }
            });

          }
        });
        let ddProvince = $('#ddProvince');
        ddProvince.empty();
        ddProvince.append('<option selected = "true" disabled> Choose Province</option>');
        <?php populateProvince(); ?>
      });
    </script>
    <title>Create a Ticket</title>
</head>
<body>
    <div id="divLogout">
    <ul>
        <li class = "liBack">
            <a id="btnBack">Back</a>
        </li>
        <li class = "liLogout">
            <a id="btnLogout" href="index.php?logout='1'" style='color:red;'>Logout</a>
        </li>
    </ul>
    </div>
    <div class = "ticket" style="width:50%; text-align:left; padding:10px; margin:auto;border: 3px solid rgb(0, 66, 128);">
        <h1>Create a Ticket</h1>
        <form action="complaintTicket.php" method="post">
            <label for="natureOfComplaint">Nature of Complaint </label><br>
            <select name="_noc" id="_noc" style="width:100%">
                <option value="brownout">Brown Out</option>
                <option value="blackout">Black Out</option>
                <option value="brokenLine">Broken Line</option>
                <option value="fallenPost">Fallen Post</option>
            </select><br><br>

            <label for="description">Description</label><br>
            <textarea style="resize:none; clear: both;" name="description" id="styled" cols = "60"rows="3"></textarea><br><br><br>

            <label for="lblRegion">Region</label><br>
            <select name="region" id="ddRegion" style="width:100%; height:30px; text-align:CENTER;">
            </select><br>
            <div id = "divProvince" style = "display: none">
                <label for="lblProvince">Province</label><br>
                <select name="province" id="ddProvince" style="width:100%; height:30px; text-align:CENTER;">
                </select>
            </div><br>
            <div id = "divMunicipal" style = "display:none">
                <label for="lblMunicipal">Municipal</label><br>
                <select name="municipal" id="ddMunicipal" style="width:100%; height:30px; text-align:CENTER;">
                </select>
            </div><br>
            <div id = "divBrgy" style = "display:none">
                <label for="lblBrgy">Barangay</label><br>
                <select name="brgy" id="ddBrgy" style="width:100%; height:30px; text-align:CENTER;">
                </select>
            </div><br>
            <div id="divPurok" style = "display:none">
                <label for="area_landmark">Purok</label><br>
                <input type="text" id="arealandmark" name="arealandmark">
            </div><br>


            <label for="area_landmark"> Area Landmark</label><br>
            <input type="text" id="arealandmark" name="arealandmark"><br><br>

            <button>Submit Ticket</button>
        </form>
    </div>
</body>
</html>
