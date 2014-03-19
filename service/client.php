<?php
$con = file_get_contents("https://www.google.com/images/srpr/logo4w.png");
$en = base64_encode($con);
include("lib/nusoap.php");
$wsdl = "http://localhost/service/server.php?wsdl";
$client = new nusoap_client($wsdl, 'wsdl');

$authenticate = array(
    'username' => 'rokon',
    'password' => 'rokon'
);
$result = $client->call('authenticate', $authenticate);
$token = end(explode('-', $result));

$pressStart = array(
    'token' => $token,
    'project_id' => 3,
    'memo' => "New Memo",
);
$result = $client->call('pressStart', $pressStart);
$saveTimeSlot = array(
    'token' => $token,
    'image' => $en,
);
$result = $client->call('saveTimeSlot', $saveTimeSlot);
print_r($result);

function data_uri($base64encoded, $mime)
{
    return ('data:' . $mime . ';base64,' . $base64encoded);
}
?>
<!--<img src="<?php //echo data_uri($result, 'image/png');                  ?>" alt="An elephant" />-->
