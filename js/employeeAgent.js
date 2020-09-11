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

  $('body').on("dblclick",'#tblLocaCover tr', function(){
    alert('HelloWorld');
    // $(this).addClass('selected').siblings().removeClass('selected');
    document.getElementById("tblLocaCover").deleteRow($('#tblLocaCover tr').index(tr));
  });

  $('#idEmpLocat').change(function(){
    var _tblLoc = document.getElementById('tblLocaCover').getElementsByTagName('tbody')[0];
    var _tblRow = _tblLoc.insertRow();
    var _tblCell = _tblRow.insertCell(0);
    var employeeLocation = $('#idEmpLocat').val();
    var _tblValue = document.createTextNode(employeeLocation);
    _tblCell.appendChild(_tblValue);
    $('#idEmpLocat').val("");
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

  $('body').on("dblclick",'#tblLocaCover tr:has(td)', function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var value=$(this).find('td:first').html();
    alert(value);
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
});
