$(document).ready(function(){
  $('#btnComplaints').click(function(){
    $('#divTbl').css("display","block");
  });
  //
  // $('#tblData tr').click(function(){
  //   $(this).addClass('selected').siblings().removeClass('selected');
  //   var value=$(this).find('td:first').html();
  //   $('#inSearch').val(value);
  //   alert(value);
  // });

  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inSearch').val(value);
    // alert(value);
  });

  $("#btnBack").click(function(){
    $('#divTbl').css("display","none");
  });

  $('#btnIDSearch').click(function(){
    $('#tblAllData').load("search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });


});
