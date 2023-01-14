<?php 
    // Main function to add a product into the current user's cart
    //start of session
    session_start();
    //include needed
    include("functions.php");

    $oath2token = $_SESSION['token'];

    //check if logged in. If not redirect to index.php
    $user_data = check_login();
    // take from ajax product_id
    $product_id = $_POST['pid'];
    //get current date
    $date = date('Y-m-d');
    // get user id from user_data 
    $user_id = $user_data['id'];

    // create array of cart
    $data = array(
        'product_id' => $product_id,
        'user_id' => $user_id,
        'date' => $date
    );

    // encode data that are going to be sent in the request
    $json_data = json_encode($data);


    // The request
    $curl = "http://fiware-pep-proxy:3051/api/cart/add.php";

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

    echo $response;
    
?>