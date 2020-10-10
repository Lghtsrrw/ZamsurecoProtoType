$(document).ready(function() {

  // $( window ).load(function() {
  //   $.ajax({
  //     type: "POST",
  //     url: 'databaseConnection/DatabaseQueries.php',
  //     data: { '_acctNo': $('#_idAcctNo').val() },
  //     success: function(result){
  //       return result;
  //     }
  //   })
  // });

  $("#btnComplaints").click(function(){
    window.location.href = "complaintTicket.php";
  });
});
