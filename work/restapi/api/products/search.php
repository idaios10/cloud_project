<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');


    include('../../models/Product.php');
    include('../../models/Connection.php');

    $connection = new Connection();
    $con = $connection->getConnection();

    // Construct product
    $product = new Product($con);

    $search = $_GET['search'];
    $filter = $_GET['filter'];
    // Execute query
    $result = $product->search($search, $filter);
    // get number of products
    $product_count = count($result);

    // if there are products in the database
    if($product_count > 0){
        $products_array = array();
        $products_array['data'] = array();

        foreach($result as $doc){
            $prod = array(
                'name' => $doc['name'],
                'product_code' => $doc['product_code'],
                'price' => $doc['price'],
                'date_of_withdrawal' => $doc['date_of_withdrawal'],
                'seller_name' => $doc['seller_name'],
                'category' => $doc['category'],
                'id' => strval($doc->_id)
            );
            //Put each product to result array
            array_push($products_array['data'], $prod);
        }
            // json encode array
            echo json_encode($products_array);
    }
    else{
        // No products
        echo json_encode(
        array('message' => 'No products Found')
      );
    }

?>