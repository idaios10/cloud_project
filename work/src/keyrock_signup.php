<?php
include('functions.php');
// get data coming from register.js  
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$role = $_POST['role'];

/***************** ACQUIRE X-Auth-Token *****************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"name\": \"admin@test.com\",
  \"password\": \"1234\"
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json"
));

$response = curl_exec($ch);  
 
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

curl_close($ch);

$data = http_parse_headers($header);
$xtoken = $data['X-Subject-Token'];

/********************** CREATE USER *********************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/users");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS,"{
  \"user\": {
  \"username\": \"".$username."\",
  \"email\": \"".$email."\",
  \"password\": \"".$password."\"
}
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "X-Auth-token: ".$xtoken.""
));



$response = curl_exec($ch);
curl_close($ch);
// echo $response;
/******************** GET THE CREATED USER'S ID **********************/

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://keyrock:3005/v1/users',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    "X-Auth-Token: ".$xtoken.""
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$result = json_decode($response, true);
// echo $response;
foreach($result as $key){
  foreach($key as $doc){

    if($doc['email'] == $email){
      $userid = $doc['id'];
    }

  }
}

  $appID = "c24f30ba-8eca-4933-a840-60812e046d32";
  $roleUserID = "a249042c-2ffd-49ff-a028-31c51a2e638b";
  $roleAdminID = "98d333fc-1431-44bb-bb9d-120efbbe3777";
  $roleSellerID = "5ebdeb0d-f0d1-492a-a34e-5e7194c5b120";
  $orgUsersID = "adf8db42-88f5-4617-8a04-524b9d4cae0e";
  $orgSellersID = "dd2aea84-11c7-4a0b-b60e-a6895c7ed927";
/************************* ASSIGN ORGANIZATION ROLE IN ORGANIZATION ***********************/
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "X-Auth-token: ". $xtoken.""
  ));

  $response = curl_exec($ch);
  curl_close($ch);


  if($role == "USER"){
    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgUsersID."/users/". $userid."/organization_roles/member");
  }
  elseif($role == "PRODUCTSELLER") {
    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgSellersID."/users/". $userid."/organization_roles/member");
  }
  elseif($role == "ADMIN") {
    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgUsersID."/users/". $userid."/organization_roles/owner");
  }

// // echo $userid;
$response = curl_exec($ch);
curl_close($ch);
$result = json_decode($response, true);
echo $response;
// // echo $result;  
//   // foreach($result as $key){
//   //   foreach($key as $doc){
//   //     echo $doc['role_id'];
//   //   }
//   // }

?>