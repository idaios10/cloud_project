<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');


    include('../../models/User.php');


    // Construct product
    $user = new User();

    $data = json_decode(file_get_contents("php://input"),true);
    
    // get posted data
    $xtoken = $data['xtoken'];    

    // Execute query
    $result = $user->getUsers($xtoken);

    // get number of products
    $user_count = count($result);
    // if there are products in the database
    if(!empty($user_count) && $user_count > 0){
        // json encode array
        echo json_encode($result);
    }
    else{
        // No products
        echo json_encode(
        array('message' => 'No Users Found')
      );
    }

?>