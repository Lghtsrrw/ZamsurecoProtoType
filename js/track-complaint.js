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
