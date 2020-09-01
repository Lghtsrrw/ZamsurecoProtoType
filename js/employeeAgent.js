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
    $('#divTbl').css("display","block");
    $('#divTbl tr').remove();
  });
});
