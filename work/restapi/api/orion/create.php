<?php
    // Headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');


    include('../../models/Connection.php');
    include('../../models/Cart.php');


    // Instantialise DB & connect
    $con = new Connection();
    $db = $con->getConnection();

    $cart = new Cart($db);

    $json = json_decode(file_get_contents("php://input"));

    $data = $json->data;

    foreach($data as $row){
        $date = $row->date_of_withdrawal->value;
    }

    // $id = $json->subscriptionId;
    // $arr = array(
    //     'name' => $name,
    //     'username' => $username,
    //     'id' => $id

    // );
    $arr = array(
        'date' => $date
    );
    
    $cart->insert_subAlert("date");

    echo json_encode($arr);



    // if($product->)

?>