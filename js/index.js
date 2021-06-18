$(document).ready(function() {

  $("#btnComplaints").click(function(){
    $("#complaintModal").css("display","block");
  })

  $('#btnPayBills').click(function(){
    $("#paymentModal").css("display","block");
  })
  $(".close").click(function(){
    $(".modal").css("display","none");
  });

  $("#btnCreateComplaint").click(function(){
    window.location.href = "complaintTicket.php";
  });
  $('#btnInquiry').click(function(){
    $('#inquiryModal').css("display", "block")
  })
  $("#btnTrackComplaint").click(function(){
    window.location.href = 'tracking-complaint.php?TN=' + $('#inComplaintNo').val();
  });

  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "?logout='1'";
        console.log('LogOut!')
    }
  });

  $('body').on("click","#tblComplaintList tr", function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inComplaintNo').val(value);

    $('#btnTrackComplaint').prop('disabled',false);
  })

  $('body').on("click","#tblBill tr", function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:last').html();
    $('#txtbillamount').val(value)
    $('#btnPayBills').prop('disabled', false)

  })

  $('.container').on('click', function() {
    $('#tblComplaintList tr').removeClass('selected');
    $('#btnTrackComplaint').prop('disabled',true);
  })

  $('#btnBills').on('click',function(){
    // console.log("Hellow");
    window.location.href = "user_bills";
  })
});
0