$(document).ready(function(){
  //This changes the Register Modal Entry-field by user selection.
  $( "#userType" ).click(function(){
    var usertype = $( "#userType" ).val();
      if (usertype == "User") {
        $("#userField").show();
        $("#guestField").hide();
        $("#dynamicRegister").text("Register");
        $("#dynamicInstruct").text("Please fill in this form to create an account.");
        $("#guestbtn").hide();
        $("#registerbtn").show();
      }else {
        $("#userField").hide();
        $("#guestField").show();
        $("#dynamicRegister").text("Enter as Guest");
        $("#dynamicInstruct").hide();
        $("#registerbtn").hide();
        $("#guestbtn").show();
      }
  })

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
  if( !regex.test(key)){
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
