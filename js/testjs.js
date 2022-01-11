$(document).ready(function(){
    $('#btnMngDspt').click(function(){
        // $(".modal").css("display","none");
        // $('#divDispatchModal').css("display","block");
        performDispatch();
        alert("Hello");
      });

      $(".close").click(function(){
        $(".modal").css("display","none");
      })
});

function performDispatch(){
    $('.modal').css("display","none");
    $('#divDispatchModal').css("display", "block")
  
    // diplay this Nature of Complaint 'NOT' equal to "Attitude of Employee"
    if($(".selected").find('td:nth-child(2)').html() != "Attitude of Employee"){
      var comno=$(".selected").find('td:nth-child(1)').html();
      $('#cdNUM').val(comno)
  
      var value=$(".selected").find('td:nth-child(2)').html();
      $('#cdNOC').val(value)
  
      var location = $(".selected").find('td:nth-child(5)').html();
      $('#cdLOC').val(location)
  
      var brgy = $(".selected").find('td:nth-child(6)').html();
      $('#cdbrgy').val(brgy)
    }
    else { //if equal to Attitude of Employee Display This
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