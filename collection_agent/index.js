$(document).ready(function(){
    $('#btnLogout').click(function(){
        if (confirm("Are you sure you want to Log-out?") == true) {
            window.location.href = "index.php?logout='1'";
        }
    })
});