
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
        ddRegion.append($('<option value = '+desc.regCode+'></option>').text(desc.regDesc));
      });
    });
  });

  // Show 'description' input if the 'complaint' is selected
  $('#_noc').change(function(){
    if($('#_noc').val() !== "-- Complaint --"){
      $('#divDescription').show();
      $('#divRegion').show();
      // $('#ddRegion').val('REGION IX (ZAMBOANGA PENINSULA)');
      // $('#idComplaint').val('09')
      // $('#divProvince').show();
    }
  });

  //Populate Province
  $('#ddRegion').change(function(){
    if($('#ddRegion').val() !== "-- Choose Region --"){
      $('#divProvince').show();

      const provURL = 'json/refprovince.json';
      let ddProvince = $('#ddProvince');
      ddProvince.empty();
      ddProvince.append('<option selected = "true" disabled>-- Choose Province --</option>');
      ddProvince.prop('selectedIndex', 0);

      $.getJSON(provURL, function(data){
        $.each(data, function(i, item){
          $.each(item, function(j, desc){
            if(desc.regCode === ddRegion.val())
            ddProvince.append($('<option value = '+desc.provCode+'></option>').text(desc.provDesc));
          });
        });
      });
    }
  });

  //Populate City/Municipal
  $('#ddProvince').change(function(){
    if($('#ddProvince').text() !== "-- Choose Province --"){
      $('#divMunicipal').show();

      let ddMunicipal = $('#ddMunicipal');
      const muniURL = 'json/refcitymun.json';
      ddMunicipal.empty();
      ddMunicipal.append('<option selected ="true" disabled>-- Choose City/Municipal --</option>');
      ddMunicipal.prop('selectedIndex', 0);

      $.getJSON(muniURL, function(data){
        $.each(data, function(i, item){
          $.each(item, function(j, desc){
            if(desc.provCode === $('#ddProvince').val())
            ddMunicipal.append($('<option value = '+desc.citymunCode+'></option>').text(desc.citymunDesc));
          });
        });
      });
    }
  });
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

  $('#ddPurok').blur(function() {
    if($('#ddPurok').val() !== ""){
    $('#ticketBtnId').show();
    }else{
      $('#ticketBtnId').hide();
    }
  });

});

function showSubmitMessage(){
    $('#divTicket').hide();
    $('#divSubmitMessage').show();
}
