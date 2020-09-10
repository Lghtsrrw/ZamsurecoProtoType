$(document).ready(function(){

  $('#btnComplaints').click(function(){
    $('#divTbl').css("display","block");
  });

  $('#btnRegSupp').click(function(){
    $('#divRegSupp').css("display","block")
  });

  $("#btnEmpList").click(function(){
    $('#divRegSupp').css("display","none")

    $('#divEmpList').css("display","block")
  })

  $('#btnMngDspt').click(function(){
    $('#divMngCmplntDispt').css("display","block")
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
    $('#divRegSupp').css("display","none");
    $('#divEmpList').css("display","none");
    $('#divMngCmplntDispt').css("display","none")
  });

  $('#btnIDSearch').click(function(){
    $('#tblAllData').load("search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });

});
