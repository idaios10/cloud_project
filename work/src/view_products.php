<?php
    session_start();
    $oath2token = $_SESSION['token'];

    $curl = "http://fiware-pep-proxy:3051/api/products/view_all.php";

    $ch = curl_init($curl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "X-Auth-Token: ".$oath2token.""
    ));
    
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
    $result = json_decode($response, true);
    $output="";  
    if($result && count($result)){
        foreach($result as $products) {
            foreach($products as $row) {	
                echo "<tr>
                        <td>".$row['name']. "</td>
                        <td>".$row['product_code']."</td>
                        <td>".$row['seller_name']."</td>
                        <td>".$row['price']."</td>
                        <td>".$row['date_of_withdrawal']."</td>
                        <td>".$row['category']."</td></td>
                <td>
                    <button class='btn btn-success' id='btn_add_to_cart'
                            data-pid=".$row['id'].">
                        <span class='fa-solid fa-plus'></span>
                    </button>
                </td>
                    </tr>";
            }
        }
    }
    else {
        echo "<tr >
        <td colspan='6'>No Result found !</td>
        </tr>";
}


?>