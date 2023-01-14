<?php
    // Reduces quantity of product by 1 from cart 
    session_start();
    include("functions.php");
    // check if logged in
    $user_data = check_login();
    // takes id with the use of ajax
    $oath2token = $_SESSION['token'];
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // create array of cart
    $data = array(
        'id' => $id,
        'quantity' => $quantity
    );

    // encode data that are going to be sent in the request
    $json_data = json_encode($data);


    // The request
    $curl = "http://fiware-pep-proxy:3051/api/cart/delete.php";

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