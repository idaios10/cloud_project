<?php
    session_start();
    include("functions.php");
	$user_data = check_login();
	$username = $user_data['username'];
	$oath2token = $_SESSION['token'];

    // take everything that is posted by ajax
    $name = $_POST['name'];
    $pcode = $_POST['pcode'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $category = $_POST['category'];

    // tranform data into array to encode it later
    $data = array(
        'username' => $username,
        'name' => $name,
        'product_code' => $pcode,
        'price' => $price,
        'date' => $date,
        'category' => $category
    );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/products/add.php";

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