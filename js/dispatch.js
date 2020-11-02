$(document).ready(function() {
  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "empLogin.php?logout='1'";
    }
  });
  $('.close').click(function() {
    $('.modal').css('display','none')
  })
  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#lblComplaintno').val(value);
    $('#lblStatus').val('Currently woring on')
    $('#btnStatus').prop("disabled", false);
  });

  $('#btnStatus').click(function(){
    $('#divUpdateStatus').css('display','block')
    $('#lblComplaintno').val($('.selected').find('td:first').html())
    $('#lblStatus').val('Currently working on')

  })

  $('#btnChangePass').click(function(){
    $('#divChangePass').css('display','block')
  })
});
