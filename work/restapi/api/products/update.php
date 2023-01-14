<?php

    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');

    include('../../models/Connection.php');
    include('../../models/Product.php');

    // Get connection
    $connection = new Connection();
    $con = $connection->getConnection();

    // Initialize cart Object
    $product = new Product($con);
    $data = json_decode(file_get_contents("php://input"));

    // call function in class Cart
    $result = $product->updateProduct($data);

    if($result == 1){
        echo json_encode(array(
            'message' => 'Product with name = ' . $data->name .' successfully updated'
        ));
    }
    else{
        echo json_encode(array(
            'message' => 'Something went wrong'
        ));
    }
?>