<?php

session_start();
include('functions.php');
$oath2token = $_SESSION["token"]; // get oauth2token from session variable

//check if logged in. If not redirect to index.php
$user_data = check_login();
// take from ajax product_id
$product_id = $_POST['pid'];
$name = $_POST['name'];
$date = $_POST['date'];
$username = $user_data['username'];
// get user id from user_data 
$user_id = $user_data['id'];
$id = $username.$name.$product_id;
$id = preg_replace('/\s+/', '', $id);


$curl = curl_init();

// set the POST request body and parameters
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://orion-proxy:1027/v2/entities', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "id": "'.$id.'",
    "type": "Product",
    "product": {
        "value": "'.$name.'",
        "type": "text"
    },
    "date_of_withdrawal": {
        "value": "'.$date.'",
        "type": "Date"
    },
    "user": {
        "value": "'.$username.'",
        "type": "text"
    }  
  }',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'X-Auth-Token: '.$oath2token.'',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl); // send request and get response 

curl_close($curl);
echo $response; 
echo "entity created";
?>
