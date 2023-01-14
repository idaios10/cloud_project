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
    
    // get posted data
    $username = $data->username;
    $name = $data->name;
    $product_code = $data->product_code;
    $date = $data->date;
    $price = $data->price;
    $category = $data->category;
    
    // call function in class Cart
    $result = $product->addToProducts($data);

    if($result == 1){
        echo json_encode(array(
            'message' => 'Product with name = ' . $data->name .' successfully added to my products'
        ));
    }
    elseif($result == 0){
        echo json_encode(array(
            'message' => 'Price is not a float number'
        ));
    }
    else{
        echo json_encode(array(
            'message' => 'Something went wrong'
        ));
    }
?>