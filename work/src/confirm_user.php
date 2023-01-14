<?php
    // File used to confirm a user
    session_start();
    include("functions.php");
    $xtoken = $_SESSION['xtoken'];
    $oath2token = $_SESSION['token'];
    $id = $_POST['id'];
    // tranform data into array to encode it later
    $data = array(
        'xtoken' => $xtoken,
        'id' => $id
    );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/user/confirm.php";

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