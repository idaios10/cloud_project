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
    $pid = $data->product_id;
    $uid = $data->user_id;
    $date = $data->date;
    
    // call function in class Cart
    $result = $cart->addToCart($pid, $uid, $date);

    if($result == 1){
        echo json_encode(array(
            'message' => 'Product was already in Cart added 1 to quantity'
        ));
    }
    elseif($result == 2){
        echo json_encode(array(
            'message' => 'Product added to Cart',
            'date_of_withdrawal' => $product->findWithdrawalDate($pid),
            'name' => $product->findProductName($pid)
        ));
    }
    else{
        echo json_encode(array(
            'message' => 'Something went wrong'
        ));
    }
?>