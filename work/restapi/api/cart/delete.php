<?php

    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');

    include('../../models/Connection.php');
    include('../../models/Cart.php');
    include('../../models/Product.php');

    // Get connection
    $connection = new Connection();
    $con = $connection->getConnection();

    // Initialize cart Object
    $cart = new Cart($con);
    $product = new Product($con);
    $data = json_decode(file_get_contents("php://input"));
    
    // get posted data
    $id = $data->id;
    $quantity = $data->quantity;
    
    // call function in class Cart
    $result = $cart->deleteFromCart($id, $quantity);

    if($result == 0){
        echo json_encode(array(
            'message' => 'Product deleted'
        ));
    }
    elseif($result == 1){
        echo json_encode(array(
            'message' => 'Quantity reduced by 1'
        ));
    }
    else{
        echo json_encode(array(
            'message' => 'Something went wrong'
        ));
    }
?>