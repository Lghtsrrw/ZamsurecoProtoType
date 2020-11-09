$(document).ready(function(){

  //this opens the Login Modal when btnLogin is clicked
  $("#btnEmpLogin").click(function(){
    window.location.href = "emplogin.php";
   });

  $("#btnLogin").click(function(){
     $("#id01").css("display","block");
   });

  //this opens the Register Modal when btnRegister is clicked
  $("#btnRegister").click(function(){
    $("#id02").css("display","block");
  });

  //this opens the Track Modal when btnTrack is clicked
  $("#btnTrack").click(function(){
    $("#id03").css("display","block");
    // closeModal();
  });

  //this opens the Guest Modal when btnGuest is clicked
  $("#btnGuest").click(function(){
    $("#id04").css("display","block");
    // closeModal();
  });

  //this closes all visible modal with class name 'close'.
  $(".close").click(function(){
    $(".modal").css("display","none");
  });

  $('#btnTrackNow').click(function(){
    openInNewTab('tracking-complaint.php?TrackNo=' + $('#inputTrackingNo').val());
  })
});

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

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
  if( !regex.test(key)){
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
