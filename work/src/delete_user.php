<?php
    session_start();
    include("functions.php");
    $user_data = check_login();
    $xtoken = $_SESSION['xtoken'];
    $oath2token = $_SESSION['token'];
    // Take everything that is posted by ajax
    $id = $_POST['id'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    // tranform data into array to encode it later
    $data = array(
      'xtoken' => $xtoken,
      'id' => $id,
      'username' => $username,
      'role' => $role
  );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/user/delete.php";

    $ch = curl_init($curl);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Auth-Token: '.$oath2token.''
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    echo $result['message'];

    // Deletes cart of the user that was deleted
    //// NA TO FTIAKSEIS OTAN KANEIS TA PRODUCTS
    // ----------------------------------------
    // delete_user_from_carts($id, $con);

    // if user deleted was a PRODUCTSELLER then delete his products from the database
    // if($role == "PRODUCTSELLER"){
    //     delete_my_products($username,$con);
    // }

?>