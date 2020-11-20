
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#sendnow').click(function(){
          $.ajax({
            type: "POST",
            url: "smsapi/sms.php",
            data:{
              'phonenumber': $('#phonenumber').val(),
              'message': $('#message').val()
            },
            success: function(result){
              console.log(result);
            }
          })
        })
      });

    </script>
  </head>
  <body>
      <input type="text" id="phonenumber" name="" value="">
      <input type="text" id="message" name="" value="">
      <button type="button" id="sendnow" name="button"> Send Message</button>
  </body>
</html>
