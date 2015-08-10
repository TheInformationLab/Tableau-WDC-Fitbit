<?php
//CONFIGURE THESE VARIABLED TO YOUR REGISTERED FITBIT APP//

$clientid = 'INSERT YOUR CLIENT ID';
$clientsecret = 'INSERT YOUR CLIENT SECRET';
$redirecturi = 'INSERT YOUR APP REDIRCT URI';

//END CONFIGURATION//

if(isset($_GET['code'])) {
        $code = $_GET['code'];
} else {
        $code = "";
}
if(isset($_GET['access_token'])) {
        $access_token = $_GET['access_token'];
} else {
        $access_token = "";
}
if(isset($_GET['refresh_token'])) {
        $refresh_token = $_GET['refresh_token'];
} else {
        $refresh_token = "";
}
if ($code != "") {
  $url = 'https://api.fitbit.com/oauth2/token';
  $encodedSecret = base64_encode($clientid . ':' . $clientsecret);

  $request_url = $url . '?client_id=' . $clientid . '&grant_type=authorization_code&redirect_uri=' . $redirecturi . '&code=' . $code;

  $options = array(
          'http' => array(
                  'method' => 'POST',
                  'header' => "Authorization: Basic " . $encodedSecret . "\r\n" . "Content-Type: application/x-www-form-urlencoded\r\n"
          ),
  );

  $context  = stream_context_create($options);
  $POSTresult = @file_get_contents($request_url, false, $context);
  if($POSTresult === FALSE)
          {
                  echo "Invalid Code";
          } else {
                  echo $POSTresult;
          }
} elseif ($refresh_token != "") {
  $url = 'https://api.fitbit.com/oauth2/token';
  $encodedSecret = base64_encode($clientid . ':' . $clientsecret);

  $request_url = $url . '?grant_type=refresh_token&refresh_token=' . $refresh_token;

  $options = array(
          'http' => array(
                  'method' => 'POST',
                  'header' => "Authorization: Basic " . $encodedSecret . "\r\n" . "Content-Type: application/x-www-form-urlencoded\r\n"
          ),
  );

  $context  = stream_context_create($options);
  $POSTresult = @file_get_contents($request_url, false, $context);
  if($POSTresult === FALSE)
          {
                  echo "Invalid Refresh";
          } else {
                  echo $POSTresult;
          }
} else {
  $req = $_GET['req'];
  $actType = $_GET['type'];
  $userID = $_GET['userid'];
  switch ($req) {
          case 'activities':
                  $reqURL = 'https://api.fitbit.com/1/user/'.$userID.'/activities/'.$actType.'/date/today/1y.json';
                  break;
          case 'sleep':
                  $reqURL = 'https://api.fitbit.com/1/user/'.$userID.'/sleep/'.$actType.'/date/today/1y.json';
                  break;
          case 'body':
                  $reqURL = 'https://api.fitbit.com/1/user/'.$userID.'/body/'.$actType.'/date/today/1y.json';
                  break;
          case 'foodwater':
                  $reqURL = 'https://api.fitbit.com/1/user/'.$userID.'/foods/log/'.$actType.'/date/today/1y.json';
                  break;
          }
  $options = array(
          'http' => array(
                  'method' => 'GET',
	   'header' => "Authorization: Bearer ".$access_token."\r\n"
          ),
  );
  $context  = stream_context_create($options);
  $GETresult = @file_get_contents($reqURL , false, $context);

  if($GETresult === FALSE)
          {
                  echo "Invalid Request";
          } else {
                  echo $GETresult ;
          }
}
?>
