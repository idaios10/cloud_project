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
    $data = json_decode(file_get_contents("php://input"),true);
    
    // get posted data
    $id = $data['id'];    
    
    // call function in class Cart
    $result = $product->deleteProduct($id);
    $name = $product->findProductName($id);
    if($result == 1){
        echo json_encode(array(
            'message' => 'Product with name = ' . $name .' successfully deleted'
        ));
    }
    else{
        echo json_encode(array(
            'message' => 'Something went wrong'
        ));
    }
?>