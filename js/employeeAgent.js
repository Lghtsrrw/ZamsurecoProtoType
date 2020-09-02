$(document).ready(function(){
  $('#btnComplaints').click(function(){
    $('#divTbl').css("display","block");
  });

  $('#tblData tr').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inSearch').val(value);
    // alert(value);
  });

  $("#btnBack").click(function(){
    $('#divTbl').css("display","none");
  });

  $('#btnIDSearch').click(function(){

    $('#tblData').css("display","none");
    $('#tblSearched').css("display","block  ");

    $('#tblSearchedData').load("ajax/search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });
});
