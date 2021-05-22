$(document).ready(function() {


  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "dispatch.php?logout='1'";
    }
  });
  $('.close').click(function() {
    $('.modal').css('display','none')
  })
  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected')

    $('#lblComplaintno').val($('.selected').find('td:first').html())
    $('#lblNatureofComplaint').val($('.selected').find('td:nth-child(3)').html())

    $('#btnStatus').prop("disabled", false)
  });

  $('#btnStatus').click(function(){

    $('#divUpdateStatus').css('display','block')
    $('#listStatus').empty()
    if ($('#lblNatureofComplaint').val() === 'Busted fuse link') {
      $('#listStatus').append($("<option>").val('Resolved'))
      $('#listStatus').append($("<option>").val('Pending'))
    }else if ($('#lblNatureofComplaint').val() === 'Leaning pole' || $('#lblNatureofComplaint').val() === 'Rotten wood pole' ||$('#lblNatureofComplaint').val() === 'Stuck up meter') {
      $('#listStatus').append($("<option>").val('Resolved'))
      $('#listStatus').append($("<option>").val('Scheduled'))
    }else {
      $('#listStatus').append($("<option>").val('Resolved'))
    }
  })

  $('#btnUpdateStatus').click(function() {
    retrieveComplainantContact($('#lblComplaintno').val());
  })

  $('#btnChangePass').click(function(){
    $('#divChangePass').css('display','block')
  })

  $('#btnUpdateAPass').click(function(){
    if(checkPasswordValidity()){
      $.ajax({
        type: "POST",
        url: "databaseConnection/DatabaseQueries.php",
        data:{
          '_oldpassword': $('#oldpassword').val(),
          '_newpassword': $('#newpassword').val()
        },
        success: function(result){
          if(result == 'InvalidPreviousPassword'){
            invalidOldPassword();
          }else if (result == 'invalidOldAndNew') {
            invalidOldAndNew();
          }else {
            console.log(result);
            $('.modal').css('display', 'none')
          }
        }
      })
    }
  })
});

function checkPasswordValidity(){
  var returnVal = true;
  var message = '';
  if($('#newpassword').val() == ''){
      $('#newpassword').css('border','1px solid red');
      message = 'Entry cannot be empty';
      returnVal = false;
  }else if ($('#newrepeatedpassword').val() == '') {
    $('#newrepeatedpassword').css('border','1px solid red')
    message = 'Entry cannot be empty';
    returnVal = false;
  }else {
    if($('#newpassword').val() != $('#newrepeatedpassword').val()){
        $('#newpassword').css('border','1px solid red')
        $('#newrepeatedpassword').css('border','1px solid red')
        message += 'Password does not match';
        returnVal = false;
    }
  }
  $('#notif').text(message);
  return returnVal
}

function invalidOldPassword(){
  $('#oldpassword').css('border','1px solid red');
  $('#notif').text("Invalid previous password.");
}
function invalidOldAndNew(){
  $('#oldpassword').css('border','1px solid red');
  $('#newpassword').css('border','1px solid red');
  $('#notif').text("New-password must not be the same as the previous-password.");
}

function sendmessage(cp, txtmessage){
  $.ajax({
    type: "POST",
    url: "smsapi/sms.php",
    data:{
      'phonenumber': cp,
      'message': txtmessage
    },
    success: function(result){
      console.log(result);
    }
  })
}

function retrieveComplainantContact(value){
  var returnValue = '';
  $.ajax({
    type: "POST",
    url: "databaseConnection/DatabaseQueries.php",
    data:{
      'complainantcomplaintno': value
    },
    success: function(result){
        sendmessage(result, `Hey there! You got a response from the personnel in-charged for Complaint No: ${value}`);
        // console.log(result);
    }
  })
}
