$(document).ready(function() {

  $("#btnComplaints").click(function(){
    $("#complaintModal").css("display","block");
  });

  $(".close").click(function(){
    $(".modal").css("display","none");
  });

  $("#btnCreateComplaint").click(function(){
    window.location.href = "complaintTicket.php";
  });

  $("#btnTrackComplaint").click(function(){
    $(".modal").css("display","none");
    $("#trackModal").css("display","block");
  });
$('#btntrack').click(function(){
  $('.divTrackRecords').load("databaseConnection/DatabaseQueries.php",{
    btnTrackComplaint: $('#inComplaintNo').val()
  })
})

  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "index.php?logout='1'";
    }
  });
});
