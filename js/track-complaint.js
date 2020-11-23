$(document).ready(function() {
    $("#btnBack").click(function(){
      history.go(-1);
    });
});

function displayComplainantInfo(val){
  $.ajax({
    type: "POST",
    url: 'databaseConnection/DatabaseQueries.php',
    data: { 'complainantInfo': val },
    success: function(result){
      var arrcom = jQuery.parseJSON(result);
      $('#cname').text(arrcom[0]);
      $('#aname').text(arrcom[1]);
      $('#sname').text(arrcom[2]);
      $('#ccont').text(arrcom[3]);
      $('#cemail').text(arrcom[4]);

    }
  })
}

function displayTicket(val){
  $.ajax({
    type: "POST",
    url: 'databaseConnection/DatabaseQueries.php',
    data: { 'complaintdetails': val },
    success: function(result){
      var arrcom = jQuery.parseJSON(result);
      $('#ticketno').text(arrcom[0]);
      $('#naturecomp').text(arrcom[2]);
      $('#complaintDescription').text(arrcom[1]);
      $('#location').text(arrcom[3]);
      $('#arealandmark').text(arrcom[4]);
    }
  })
}
