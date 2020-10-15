
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
        $('#divTbl').css("display","none");
        $('#divRegSupp').css("display","none");
        $('#divEmpList').css("display","none");
        $('#divMngCmplntDispt').css("display","none")
    }
});

$(document).ready(function(){

var arrEmpLocCov = {};
arrEmpLocCov['Area'] = [];
arrEmpLocCov['municipalcode'] = [];
  // insert City/Municipal on divMngCmplntDispt Modal location autocomplete
  try {
    const regURL = 'json/refcitymun.json';
    $.getJSON(regURL, function(data){
      $.each(data, function(i, item){
        $.each(item, function(j, desc){
          if(desc.provCode == "0973" && desc.citymunDesc != "KUMALARANG" && desc.citymunDesc != "BAYOG" && desc.citymunDesc != "LAKEWOOD"){
            $('#empLocaCover').append($("<option>").val(desc.citymunDesc).text(desc.citymunCode));
          }
        });
      });
    });
  } catch (e) {
    alert(e);
  }

  // Adding rows and Value to TBl in Dispatch Manage Modal
  $('#idEmpLocat').change(function(){
    var _tblLoc = document.getElementById('tblLocaCover').getElementsByTagName('tbody')[0];
    var _tblRow = _tblLoc.insertRow();
    var _tblCell = _tblRow.insertCell(0);
    var _tblCell2 = _tblRow.insertCell(1);
    var MuniCov = $('#idEmpLocat').val()
    var MuniCov2 = retrieveMunicipalID(MuniCov)
    var _tblValue = document.createTextNode(MuniCov);
    var _tblValue2 = document.createTextNode(MuniCov2);
    _tblCell.appendChild(_tblValue); 
    _tblCell2.appendChild(_tblValue2);

    arrEmpLocCov['Area'].push(MuniCov);
    console.log(arrEmpLocCov);

    $('#idEmpLocat').val("");
    $('#countthis').val($('#tblLocaCover tr').length - 1);
  })

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
  });

  $('body').on("click",'#tblLocaCover tr:has(td)', function(){
    alert(retrieveMunicipalID($('#idEmpLocat').text()))
    if (confirm("Are you sure you want to remove '"+ $(this).text() +"'?") == true) {
      // remove selected row from the dsptmng modal
      $(this).closest('tr').remove();
      $('#countthis').html($('#tblLocaCover tr').length - 1);
      // remove selected index from the array
      for(var i = 0; i < arrEmpLocCov['Area'].length; i++){
        if(i == arrEmpLocCov['Area'].indexOf($(this).text())){
          arrEmpLocCov['Area'].splice(i,1);
        }
      }
      console.log(arrEmpLocCov);
    }
  });

  $('body').on("dblclick",'#tblData tr', function(){
    $('#btnDispatch').prop("disabled", false);
  });

  $("#btnBack").click(function(){
    hideModals();
  });

  $('#btnIDSearch').click(function(){
    $('#tblAllData').load("search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });

  $('#idEmpName').change(function(e){
    e.preventDefault();
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
    if($('#idEmpOffice').val() == "TSD"){
      $('#idBrgyCov').css("display","block");
    }else{
      $('#idBrgyCov').css("display","none");
    }
  })

  $('#btnSubmitDsptMng').on("click", function(){
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
    console.log("No error");
  });

  $('body').on("click",'#tblOffices tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#selectedOffice').val(value);

    $('.divEmpDetails').load("databaseConnection/DatabaseQueries.php", {
      officeval: $('#selectedOffice').val(),
      cityval: $('#selectedRow').val()
    });
  });


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
  var muncode;
  try {
    const regURL = 'json/refcitymun.json';
    $.getJSON(regURL, function(data){
      $.each(data, function(i, item){
        $.each(item, function(j, desc){
          if(desc.citymunDesc == _value){
            muncode = desc.citymunCode;
          }else{
            console.log(muncode);
          }
        });
      });
    });
  } catch (e) {
    alert(e);
  }
  return muncode;
}

function appendBrgy(_value){
  // insert brgy on divMngCmplntDispt Modal location autocomplete
  try {
    const regURL = 'json/refbrgy.json';
    $.getJSON(regURL, function(data){
      $.each(data, function(i, item){
        $.each(item, function(j, desc){
          if(desc.provCode == "0973" && desc.citymunDesc != "KUMALARANG" && desc.citymunDesc != "BAYOG" && desc.citymunDesc != "LAKEWOOD"){
            $('#empLocaCover').append($("<option>").text(desc.citymunDesc));
          }
        });
      });
    });
  } catch (e) {
    alert(e);
  }
}
