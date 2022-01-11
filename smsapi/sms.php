<?php

function itexmo($number,$message,$apicode,$passwd){
  $url = 'https://www.itexmo.com/php_api/api.php';
  $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
  $param = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($itexmo),
    ),
  );
  $context  = stream_context_create($param);
  return file_get_contents($url, false, $context);
}

if(isset($_POST['phonenumber']) && isset($_POST['message'])){
  $result = itexmo($_POST['phonenumber'], $_POST['message'], 'ST-SYEDR506553_3Y6IB', '4]d7tw$iq#');
  if ($result == ""){
  echo "iTexMo: No response from server!!!
  Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.
  Please CONTACT US for help. ";
  }else if ($result == 0){
  echo "Message Sent!";
  }
  else{
  echo "Error Num ". $result . " was encountered!";
  }
}
?>
