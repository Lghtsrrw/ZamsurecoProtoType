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
    window.location.href = 'tracking-complaint.php?TN=' + $('#inComplaintNo').val();
  });

  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "index.php?logout='1'";
    }
  });

  $('body').on("click","#tblComplaintList tr", function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inComplaintNo').val(value);

    $('#btnTrackComplaint').prop('disabled',false);
  })

  $('.container').on('click', function() {
    $('#tblComplaintList tr').removeClass('selected');
    $('#btnTrackComplaint').prop('disabled',true);
  })
});
