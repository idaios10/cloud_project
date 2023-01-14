<?php
    session_start();
    include("functions.php");
    $user_data = check_login();
    $oath2token = $_SESSION['token'];

    // take the id of the product that toy want to delete
    $id = $_POST['id'];
    // tranform data into array to encode it later
    $data = array(
        'id' => strval($id)
    );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/products/delete.php";

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
    // -------------Check when cart is done-------------
    // delete_from_carts($id);
?>