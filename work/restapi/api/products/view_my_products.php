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
    // call function in class Cart
    $result = $product->viewMyProducts($username);

    // get number of products
    $product_count = count($result);

    // if there are products in the database
    if($product_count > 0){
        $my_products = array();
        $my_products['data'] = array();

        foreach($result as $doc){
            $item = array(
                'name' => $doc['name'],
                'product_code' => $doc['product_code'],
                'price' => $doc['price'],
                'date_of_withdrawal' => $doc['date_of_withdrawal'],
                'username' => $doc['seller_name'],
                'id' => strval($doc->_id),
                'category' => $doc['category']
            );
            //Put each product to result array
            array_push($my_products['data'], $item);
        }
            // json encode array
            echo json_encode($my_products);
    }
    else{
        // No products
        echo json_encode(
        array('message' => 'No products Found')
      );
    }
?>