<?php
    session_start();
    include('functions.php');
    // get data coming from an HTML form  
    $email = $_POST['username'];
    $password = $_POST['password'];
    /************************** ACQUIRE X-AUTH-TOKEN WITH ADMIN DATA **************************/
    // $str = "48e5c5e2-bca7-470b-b15c-aa1d811b5b00:e1343498-51df-4d8d-aa4f-6d22f293099c";
    // echo base64_encode($str);
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
    /********************************** AUTHENTICATE USER AND GENERATE TOKEN ****************************/

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://keyrock:3005/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'grant_type=password&username='.$email.'&password='.$password.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic YzI0ZjMwYmEtOGVjYS00OTMzLWE4NDAtNjA4MTJlMDQ2ZDMyOmE1NDRhZDY2LWNlNTAtNGUyNi05YTk4LTZjODdjOWM3ODc1NQ==', // this huge string is the base-64(client_id:client_secret) string
        'Accept: application/json'
      ),
    ));

    $response = curl_exec($curl);
    // echo $response;
    curl_close($curl);
    $result1 = json_decode($response);
    if ( $result1 != "Invalid grant: user credentials are invalid") {

      /************************ACQUIRE USERNAME********************************/

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
      $result = json_decode($response, true);
      

      foreach($result as $key){
        foreach($key as $doc){
            // echo $doc['email'];
          if($doc['email'] == $email){
            $userid = $doc['id'];
            $username = $doc['username'];
          }

        }
      }

    //   /***************************ACQUIRE ROLE ***************************/

      $appID = "c24f30ba-8eca-4933-a840-60812e046d32";
      $roleUserID = "a249042c-2ffd-49ff-a028-31c51a2e638b";
      $roleAdminID = "98d333fc-1431-44bb-bb9d-120efbbe3777";
      $roleSellerID = "5ebdeb0d-f0d1-492a-a34e-5e7194c5b120";

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/".$appID."/users/".$userid."/roles");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-token: ".$xtoken.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);
      $result = json_decode($response, true);
      foreach($result as $key){
        foreach($key as $doc){
          $role = $doc['role_id'];
        }
      }


      if ($role == $roleUserID) {
        $role = "USER";
      }
      elseif ($role == $roleAdminID) {
        $role = "ADMIN";
      }
      elseif ($role == $roleSellerID){
        $role = "PRODUCTSELLER";       
      }
      echo $result1->access_token;
      $_SESSION["token"] = $result1->access_token;
      $_SESSION["xtoken"] = $xtoken;
      $_SESSION["id"] = $userid;
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;
      $_SESSION["role"] = $role;
     
      echo 'Log In'; // echo the response message you want for success
    }
    else {
      echo 'error'; // echo the response message you want for error 
    }

       
?>