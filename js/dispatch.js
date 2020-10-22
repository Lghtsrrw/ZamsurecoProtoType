$(document).ready(function() {
  $('#btnLogout').on("click",function(){
    if (confirm("Are you sure you want to Log-out?") == true) {
        window.location.href = "empLogin.php?logout='1'";
    }
  });
});
