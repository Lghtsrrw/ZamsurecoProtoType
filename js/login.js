$(document).ready(function() {

  $("#btnLogin").click(function(){
     $("#id01").css("display","block")
  })
  $("#btnRegister").click(function(){
    $("#id02").css("display","block")
  })
  $("#btnTrack").click(function(){
    $("#id03").css("display","block")
  })
  $("#btnGuest").click(function(){
    $("#id04").css("display","block")
  })
  $('#btnTrackNow').click(function(){
    openInNewTab('tracking-complaint.php?TN=' + $('#inputTrackingNo').val());
  })

  $(".close").click(function(){
      $(".modal").css("display","none");
  })
});

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}
