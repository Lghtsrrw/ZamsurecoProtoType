$(document).ready(function(){
  $('#btnComplaints').click(function(){
    $('#divTbl').css("display","block");
  });

  $('#tblData tr').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    alert(value);
  });

  $("#btnBack").click(function(){
    $('#divTbl').css("display","none");
  });
});
