<?php

    session_start();
    include('functions.php');
    $userdata = check_login();
    $xtoken = $_SESSION['xtoken'];
    $oath2token = $_SESSION['token'];

    // Take everything that is posted by ajax
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    // $old_role = $_POST['old_role'];

    // tranform data into array to encode it later
    $data = array(
      'xtoken' => $xtoken,
      'id' => $id,
      'username' => $username,
      'email' => $email,
      'role' => $role
  );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/user/update.php";

    $ch = curl_init($curl);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Auth-Token: '.$oath2token.''
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    echo $result['message'];


?>