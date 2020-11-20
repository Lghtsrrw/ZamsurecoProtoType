
$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
        if($('#ddPurok').val() !== ""){
        $('#ticketBtnId').show();
      }else {
        $('#ticketBtnId').hide();
      }
    }
});
$(document).ready(function(){
  //back to previous page when btnBack is click
  $("#btnBack").click(function(){
    history.go(-1);
  });

  // populate Region
  const regURL = 'json/refregion.json';
  var regCode = "";
  let ddRegion = $('#ddRegion');
  ddRegion.empty();
  ddRegion.append('<option selected ="true" disabled>-- Choose Region --</option>');
  ddRegion.prop('selectedIndex', 0);

  $.getJSON(regURL, function(data){
    $.each(data, function(i, item){
      $.each(item, function(j, desc){
        ddRegion.append($('<option></option>').text(desc.regDesc));
      });
    });
  });

  // Show 'description' input if the 'nature of complaint' is selected

  $('#idComplaint').on('change',function(){
    if($('#idComplaint').val() !== "" && $('#idComplaint').val() === "Attitude of Employee"){
      $('#divDescription').show();

      $('#divAddressSelect').hide();
      $('#divEmployeeSelect').show();

      $('#lblPurok').text('Employee Office');
      $('#ddPurok').prop('placeholder','Employee Office')
      $('#ddPurok').attr("autofocus", true);
    }
    else {
      $('#divDescription').show();

      $('#divAddressSelect').show();
      $('#divEmployeeSelect').hide();

      $('#lblPurok').text('Purok or Area Landmarks');
      $('#ddPurok').prop('placeholder','')

      if($('#idProvince').val() !== ""){
        $('#divMunicipal').show();

        let ddMunicipal = $('#ddMunicipal');
        const muniURL = 'json/refcitymun.json';
        ddMunicipal.empty();
        ddMunicipal.append('<option selected ="true" disabled>-- Choose City/Municipal --</option>');
        ddMunicipal.prop('selectedIndex', 0);

        $.getJSON(muniURL, function(data){
          $.each(data, function(i, item){
            $.each(item, function(j, desc){
              if(desc.provCode == "0973" &&
                desc.citymunDesc != "KUMALARANG" &&
                desc.citymunDesc != "BAYOG" &&
                desc.citymunDesc != "LAKEWOOD" &&
                desc.citymunDesc != "ZAMBOANGA CITY"
                ){
                ddMunicipal.append($('<option value = '+desc.citymunCode+'></option>').text(desc.citymunDesc));
              }

              if (desc.provCode == "1042" &&
                  desc.citymunDesc == "DON VICTORIANO CHIONGBIAN  (DON MARIANO MARCOS)"
              ){
                ddMunicipal.append($('<option value = '+desc.citymunCode+'></option>').text(desc.citymunDesc));
              }
            });
          });
        });
      }
    }

  })

  //Populate Brgy
  $('#ddMunicipal').change(function(){
    if($('#ddMunicipal').text() !== "-- Choose City/Municipal --"){
      $('#divBrgy').show();

      let ddBrgy = $('#ddBrgy');
      const brgyURL = 'json/refbrgy.json';
      ddBrgy.empty();
      ddBrgy.append('<option selected ="true" disabled>-- Choose Barangay --</option>');
      ddBrgy.prop('selectedIndex', 0);

      $.getJSON(brgyURL, function(data){
        $.each(data, function(i, item){
          $.each(item, function(j, desc){
            if(desc.citymunCode === $('#ddMunicipal').val())
            ddBrgy.append($('<option value = '+desc.brgyCode+'></option>').text(desc.brgyDesc));
          });
        });
      });
      $('#lblLoadingBgrgy').css('display','none');
    }
  });

  //show purok input on brgy change
  $('#ddBrgy').change(function(){
    if($('#ddBrgy').val() !== "-- Choose Barangay --"){
      $('#divPurok').show();
      $('#ddPurok').attr("autofocus", true);
    }
  });

  $('#inempname').blur(function() {
    if($('#inempname').val() !== ""){
      $('#divPurok').show();
    }else{
      $('#divPurok').hide();
    }
  });
  $('#inempname').change(function(){

    if($('#inempname').val() !== ""){
      $('#divPurok').show();
    }else {
      $('#divPurok').hide();
    }
  })

  $('#ddPurok').keyup(function(){
    if($('#ddPurok').val() !== ""){
    $('#ticketBtnId').show();
    }else{
      $('#ticketBtnId').hide();
    }
  })

  $('#ticketBtnId').click(function(){
    sendmessage($('#lblcontact').text(), "Complaint Ticket: " + $('#trackingno').html() + " has been submitted and is subject for review.");
  })
});
// Functions declaration area
function showSubmitMessage(){
    $('#divTicket').hide();
    $('#divSubmitMessage').show();
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
