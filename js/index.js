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
});

function closeModal(){

}
