$(document).ready(function(){

  $('#btnComplaints').click(function(){
    $('#divTbl').css("display","block");
  });

  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inSearch').val(value);
  });

  $('body').on("dblclick",'#tblData tr', function(){
    $('#btnDispatch').prop("disabled", false);
  });

  $("#btnBack").click(function(){
    $('#divTbl').css("display","none");
  });

  $('#btnIDSearch').click(function(){
    $('#tblAllData').load("search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });

  $('#btnMngDspt').click(function(){
    window.location.href = "dispatch_management.php";
  });

});
