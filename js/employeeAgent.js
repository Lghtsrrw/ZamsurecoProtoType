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


  // insert City/Municipal on divMngCmplntDispt Modal location autocomplete
  try {
    const regURL = 'json/refcitymun.json';
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

  // Adding rows and Value to TBl in Dispatch Manage Modal
  $('#idEmpLocat').change(function(){
    var _tblLoc = document.getElementById('tblLocaCover').getElementsByTagName('tbody')[0];
    var _tblRow = _tblLoc.insertRow();
    var _tblCell = _tblRow.insertCell(0);
    var employeeLocation = $('#idEmpLocat').val();
    var _tblValue = document.createTextNode(employeeLocation);
    _tblCell.appendChild(_tblValue);

    $('#empIDList').find("option[value='"+ employeeLocation +"']").remove();
    $('#idEmpLocat').val("");
    $('#countthis').html($('#tblLocaCover tr').length - 1);
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

  $('body').on("click",'#tblData tr', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    $('#inSearch').val(value);
  });

  $('body').on("click",'#tblLocaCover tr:has(td)', function(){
    if (confirm("Are you sure you want to remove?") == true) {
    $(this).closest('tr').remove();

    $('#countthis').html($('#tblLocaCover tr').length - 1);
    }
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
    $('#tblAllData').load("php/search-complaint.php", {
      complaintNo_tobesearch: $('#inSearch').val()
    });
  });

  $('#idEmpName').change(function(e){
    e.preventDefault();
    var val = $('#idEmpName').val();
    $.ajax({
      url: 'php/load-empname.php',
      data: 'valempid=' + val,
      success: function(result){
        $('#empname').val(result)
      }
    })
  })
});

function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
