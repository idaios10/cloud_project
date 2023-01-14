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
    $uid = $data->userid;
    // call function in class Cart
    $result = $cart->viewCart($uid);

    // get number of products
    $product_count = count($result);

    // if there are products in the database
    if($product_count > 0){
        $cart = array();
        $cart['data'] = array();

        foreach($result as $doc){
            $cart_item = array(
                'productid' => $doc['productid'],
                'product_name' => $product->findProductName($doc->productid),
                'userid' => $doc['userid'],
                'quantity' => $doc['quantity'],
                'date_of_insertion' => $doc['date_of_insertion'],
                'id' => strval($doc->_id),
                'price' => $product->findPrice($doc->productid)
            );
            //Put each product to result array
            array_push($cart['data'], $cart_item);
        }
            // json encode array
            echo json_encode($cart);
    }
    else{
        // No products
        echo json_encode(
        array('message' => 'No products Found')
      );
    }
?>