<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');


    include('../../models/User.php');


    // Construct product
    $user = new User();

    $data = json_decode(file_get_contents("php://input")); 

    // Execute query
    $result = $user->confirmUser($data->xtoken, $data->id);
    // if there are products in the database
    if(!empty($result)){
        echo json_encode(array('message' => 'User is confirmed'));
    }
?>