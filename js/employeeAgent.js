var arrEmpLocCov = {};
arrEmpLocCov['Area'] = [];
arrEmpLocCov['Brgy'] = [];
arrEmpLocCov['municipalcode'] = [];
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

    if(event.which == "27") {
        event.preventDefault();
        $('.modal').css('display','none')
    }
});

$(document).ready(function(){
  // insert City/Municipal on divMngCmplntDispt Modal location autocomplete
  try {
    const regURL = 'json/refcitymun.json';
    $.getJSON(regURL, function(data){
      $.each(data, function(i, item){
        $.each(item, function(j, desc){

          if(desc.provCode == "0973" &&
            desc.citymunDesc != "KUMALARANG" &&
            desc.citymunDesc != "BAYOG" &&
            desc.citymunDesc != "LAKEWOOD" &&
            desc.citymunDesc != "ZAMBOANGA CITY"
            ){
            $('#empLocaCover').append($("<option>").val(desc.citymunDesc).text(desc.citymunCode));
          }
          if (desc.provCode == "1042" &&
              desc.citymunDesc == "DON VICTORIANO CHIONGBIAN  (DON MARIANO MARCOS)"
          ){
            $('#empLocaCover').append($("<option>").val(desc.citymunDesc).text(desc.citymunCode));
          }

        });
      });
    });
  }catch(e){
    alert(e);
  }

  // Logout Button
  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "empLogin.php?logout='1'";
    }
  });

  // Adding rows and Value to TBl in Dispatch Manage Modal
  $('#idEmpLocat').change(function(){

    displayBrgyCov();

    if ($('#idEmpLocat').val() != "") {
      $('#divcontact').css('display', 'block')
    }else {
      $('#divcontact').css('display', 'none')
    }

    // #region insert value in table
    var _tblLoc = document.getElementById('tblLocaCover').getElementsByTagName('tbody')[0];
    var _tblRow = _tblLoc.insertRow();
    var _tblCell = _tblRow.insertCell(0);
    var citycoverage = $('#idEmpLocat').val();
    var _tblValue = document.createTextNode(citycoverage);
    _tblCell.appendChild(_tblValue);            //appending value to Table
    arrEmpLocCov['Area'].push(citycoverage);  //pushing value in object array
    retrieveMunicipalID(citycoverage);        //Insert municipalslist in the data list
    $('#countthis').val($('#tblLocaCover tr').length - 1);
  })

  $(".close").click(function(){
    $(".modal").css("display","none");
  });
  $(".refresh").click(function(){
    window.location.href = "employeeAgent.php";
  });

  // Load dispatch modal on click 'Dispatch' on Complaint Modal
  $('#btnDispatch').click(function(){
      performDispatch();
  });

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

  $('#btnShowComplaintRec').click(function(){
    hideModals();
    $('#divCmplntHndlr').css("display","block");
  })

  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inSearch').val(value);

    $('#btnDispatch').prop("disabled", false);
  });
  $('#divTbl').on("click",function(){
    $('#tblData tr').removeClass('selected')

    $('#btnDispatch').prop("disabled", true);
  })

  // compplaint Handler Table
  $('body').on("click",'#compHandler tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('#empSupp').val($(this).find('td:first').html());

    $('#btnSelectedEmp').prop('disabled',false);
  });

  $('#complaintReceiver').click(function(){
    $('#btnSelectedEmp').prop('disabled',true)
  })

  $('#complaintReceiver').click(function(){
    $('#compHandler tr').removeClass('selected');
  })

  // when doubleclicking complaint Handler table
  $('body').on("dblclick",'#compHandler tr', function(){
    if(confirm("You sure you want to select this?")){
      console.log('Hello World');
    }
  });

  $('#btnSelectedEmp').click(function(){
    if(confirm("Are you sure you want to assign "+ $('#empSupp').val() + " for this complaint?")){
      $.ajax({
        type: "POST",
        url: 'databaseConnection/DatabaseQueries.php',
        data: { 'complaintno': $('#cdNUM').val(),
                'empidsupp': $('.selected').find('td:first').html()},
        success: function(result){
          console.log(result);
          window.location.href = 'employeeAgent.php';
        }
      })
      $('#complainthandlerBtn').css('display','none')
    }
  })

  $('#btnAssignEmployeeSupport').click(function(){
    if(confirm("Are you sure you want to assign "+ $('#empSupp').val() + " for this complaint?")){
      $.ajax({
        type: "POST",
        url: 'databaseConnection/DatabaseQueries.php',
        data: { 'complaintno': $('#cdNUM').val(),
                'empidsupp': $('#empSupp').val()},
        success: function(result){
          console.log(result);

          var complainantNo = retrieveComplainantContact($('#cdNUM').val());
          sendmessage(complainantNo, "Your complaint ticket witn TN: " +  $('#cdNUM').val() +" has been dispatched to the appropriate personnel for immediate action.");

          window.location.href = 'employeeAgent.php';
        }
      })
    }
  })

  // removing rows in table remove value
  $('body').on("click",'#tblLocaCover tr:has(td)', function(){
    if (confirm("Are you sure you want to remove '"+ $(this).text() +"'?") == true) {

      // remove selected row from the dsptmng modal
      $(this).closest('tr').remove();
      $('#countthis').html($('#tblLocaCover tr').length - 1);
      // remove selected index from the array
      for(var i = 0; i < arrEmpLocCov['Area'].length; i++){
        if(i == arrEmpLocCov['Area'].indexOf($(this).text())){
          arrEmpLocCov['Area'].splice(i,1);
          arrEmpLocCov['municipalcode'].splice(i,1);
        }
      }
      $('#countthis').val($('#tblLocaCover tr').length - 1);
      console.log(arrEmpLocCov);

      $('#divBrgyCov').load(window.location.href + " #divBrgyCov");
      $('#idBrgyCov').css('display','block');
      // change brgycov
      displayBrgyCov();

      for (var i = 0; i < arrEmpLocCov['municipalcode'].length; i++) {
        retrieveMunicipalID(arrEmpLocCov['municipalcode'][i]);
      }
    }
  });

  $('body').on("click",'#tblBrgyCover tr:has(td)', function(){
    if (confirm("Are you sure you want to remove '"+ $(this).text() +"'?") == true) {
      // remove selected row from the dsptmng modal
      $(this).closest('tr').remove();
      // remove selected index from the array
      for(var i = 0; i < arrEmpLocCov['Brgy'].length; i++){
        if(i == arrEmpLocCov['Brgy'].indexOf($(this).text())){
          arrEmpLocCov['Brgy'].splice(i,1);
        }
      }
      console.log(arrEmpLocCov);
    }
  });

  // DOuble-click on selected active complaint
  $('body').on("dblclick",'#tblData tr', function(){
    performDispatch();
  });

  $("#btnBack").click(function(){
    hideModals();
  });

  $('#btnIDSearch').click(function(){
    $('.tblAllData').load("search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });

  $('#idEmpName').change(function(e){
    e.preventDefault();

    if ( $('#idEmpName').val() != "") {
      $('#divareacov').css('display','block')
    }

    var val = $('#idEmpName').val();
    $.ajax({
      url: 'load-empname.php',
      data: 'valempid=' + val,
      success: function(result){
        $('#empname').val(result)
      }
    })
  })

  $('#idEmpOffice').change(function(){
    if ($('#idEmpOffice').val() != "") {
      $('#divempdetails').css('display','block');
    }

    // change brgycov
    displayBrgyCov();

  })

  $('#btnSubmitDsptMng').on("click", function(){
    console.log(JSON.stringify(arrEmpLocCov));
    $.ajax({
      type: "POST",
      url: 'databaseConnection/DatabaseQueries.php',
      data: { 'paramName': JSON.stringify(arrEmpLocCov),
              'areaCovNo': $('#AreaCovID').val() },
      success: function(result){
        console.log(result);
      }
    })
  })

  $('body').on("click",'#tblLocation tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#selectedRow').val(value);

    $('.locationFloatRight').load("databaseConnection/DatabaseQueries.php", {
      locationvalue: $('#selectedRow').val()
    });
  });

  // #tblOffices is declared in DatabaseQueries.php fillCmplntHndlrOffice()
  $('body').on("click",'#tblOffices tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#selectedOffice').val(value);

    $('.divEmpDetails').load("databaseConnection/DatabaseQueries.php", {
      officeval: $('#selectedOffice').val(),
      cityval: $('#selectedRow').val()
    });
  });

  $('#btnSet').click(function(){
    $('#setEmpSupp').css("display", "block");
    $('#complainthandlerBtn').css("display","none")
    $('#divTblComplaineReceiver').css("display","none")
  })

  $('#setEmpID').change(function(){
      $('#btnAssignEmployeeSupport').prop('disabled',false);
      $.ajax({
        type: "POST",
        url: 'databaseConnection/DatabaseQueries.php',
        data: { 'suppempid': $('#setEmpID').val()},
        success: function(result){
          $('#setEmpName').val(result);
        }
      })
      $('#empSupp').val($('#setEmpID').val());
  })

  $('#_noc').change(function(){
    if($('#_noc').val() != "-- complaint --"){
      $('#divoffice').css('display','block');
    }
  })

  $('#idEmpContact').keyup(function(){
    if($('#idEmpContact').val() != "" && $('#idEmpContact').val().length == 11){
      $('#divdsptchmngBtn').css('display', 'block')
    }else {
      $('#divdsptchmngBtn').css('display', 'none')
    }
  })

  $('#idEmpBrgy').click(function(){
    if($(this).val() !== '') {$(this).val('');}
    return false;
  })

  $('#idEmpBrgy').change(function(){

    var _tblLoc = document.getElementById('tblBrgyCover').getElementsByTagName('tbody')[0];
    var _tblRow = _tblLoc.insertRow();
    var _tblCell = _tblRow.insertCell(0);
    var brgycover = $('#idEmpBrgy').val();
    var _tblValue = document.createTextNode(brgycover);
    _tblCell.appendChild(_tblValue);
    arrEmpLocCov['Brgy'].push(brgycover);
  })

  $('#btnEmpSearch').click(function(){
    if ($('#txtEmpSearch').val() != "") {
      $('#txtEmpSearch').css('border-color','#ccc');
      // $('.tblAllData').load("databaseConnection/DatabaseQueries.php", {
      //   employee_tobe_search: $('#txtEmpSearch').val()
      // });

      $.ajax({
        type: 'POST',
        url: 'databaseConnection/DatabaseQueries.php',
        data:{
          'employee_id_search': $('#txtEmpSearch').val()
        },
        success: function(result){
          console.log(result);
          var arrEmployeeSearch = jQuery.parseJSON(result);
          console.log(arrEmployeeSearch);
        }
      })
    }else {
      $('#txtEmpSearch').css('border-color','red');
    }
  })
});
function hideModals(){
  $('#divTbl').css("display","none");
  $('#divRegSupp').css("display","none");
  $('#divEmpList').css("display","none");
  $('#divMngCmplntDispt').css("display","none");
  $('#divCmplntHndlr').css("display","none");
}

function validate(evt) {
  var theEvent = evt || window.event;
  // Handle paste
  if (theEvent.type === 'paste') {
      key = Event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key)){
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function retrieveMunicipalID(_value){
  // insert City/Municipal code to array
  try {
    const regURL = 'json/refcitymun.json';
    $.getJSON(regURL, function(data){
      $.each(data, function(i, item){
        $.each(item, function(j, desc){
          if(desc.citymunDesc == _value && desc.provCode == "0973"){
            // arrEmpLocCov['municipalcode'].push(desc.citymunCode);
            $('#_municode').val(desc.citymunCode);
            arrEmpLocCov['municipalcode'].push(desc.citymunCode);
            appendBrgy(desc.citymunCode);
          }else if(desc.citymunDesc == _value && desc.provCode == "1042"){
            $('#_municode').val(desc.citymunCode);
            arrEmpLocCov['municipalcode'].push(desc.citymunCode);
            appendBrgy(desc.citymunCode);
          }
        });
      });
    });
  }catch(e){
    alert(e);
  }
}

function performDispatch(){
  $('.modal').css("display","none")
  $('#divDispatchModal').css("display", "block")

  // diplay this Nature of Complaint not equal to "Attitude of Employee"
  if($(".selected").find('td:nth-child(2)').html() != "Attitude of Employee"){
    var comno=$(".selected").find('td:nth-child(1)').html();
    $('#cdNUM').val(comno)

    var value=$(".selected").find('td:nth-child(2)').html();
    $('#cdNOC').val(value)

    var location = $(".selected").find('td:nth-child(5)').html();
    $('#cdLOC').val( location )

    var brgy = $(".selected").find('td:nth-child(6)').html();
    $('#cdbrgy').val(brgy)
  }else { //if equal to Attitude of Employee Display This
    var comno=$(".selected").find('td:nth-child(1)').html();
    $('#cdNUM').val(comno)

    var value=$(".selected").find('td:nth-child(2)').html();
    $('#cdNOC').val(value)

    $('#attitude').css('display','block')
    $('#nonAttitude').css('display','none')

    var complainee=$(".selected").find('td:nth-child(4)').html();
    $('#cdcomplainee').val(complainee)

  }


  $('#btnDispatch').prop("disabled", true);

  $('#divTblComplaineReceiver').load("databaseConnection/DatabaseQueries.php", {
    natureofcomplaint: $('#cdNOC').val(),
    citymunicipal: $('#cdLOC').val(),
    crbrgy: $('#cdbrgy').val(),
    complainee: $('#cdcomplainee').val()
  });
}

function appendBrgy(muni){
  if($('#idEmpOffice').val() == "TSD")
  {
    $.ajax({
      type: "POST",
      url: 'databaseConnection/DatabaseQueries.php',
      data: { 'queryBrgy': muni },
      success: function(result){
        console.log(result);
        var arrjsBrgy = jQuery.parseJSON(result);
        for (var i = 0; i < result.length; i++) {
          $('#empBrgyCover').append($("<option>").val(arrjsBrgy[i]));
        }
      }
    })
  }
}

function displayBrgyCov(){
  if($('#idEmpOffice').val() == "TSD"){
    $('#idBrgyCov').css("display","block");
  }else {
    $('#idBrgyCov').css("display","none");
  }
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
      console.log(result);
      returnValue = result;
    }
  })

  return returnValue;
}
