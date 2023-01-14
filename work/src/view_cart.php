<?php
    session_start();
    include("functions.php");
    $user_data = check_login();
    // Take data needed to send in the request
    $user_id = $user_data['id'];
	$username = $user_data['username'];
    $oath2token = $_SESSION['token'];

    // tranform data into array to encode it later
    $data = array(
        'userid' => $user_id,
    );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/cart/view.php";

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
    echo $response;
    $cart_price = 0;
    if (!empty($result['message']) && $result['message'] == 'No products Found'){
        echo "<tr >
        <td colspan='6'>No Result found !</td>
        </tr>";        
    }
    else {
        if(count($result) > 0){
            foreach($result as $my_cart) {
                foreach($my_cart as $row)	 {	
                    echo '<tr>
                            <td>'. $row['id']. '</td>
                            <td>'. $row['product_name']. '</td>
                            <td>'. $row['date_of_insertion']. '</td>
                            <td>
                            <button class="btn btn-danger" id="btn_delete_from_cart"
                            data-id='.$row['id'].'
                            data-quantity='.$row['quantity'].'>
                                <span class="fa-solid fa-minus"></span>
                            </button>
                            <a class="btn btn-outline-success disabled"  href="#">
                            '. $row['quantity'] .'
                            </a>
                            <button class="btn btn-success" id="btn_add_to_cart"
                            data-pid='.$row['productid'].'>
                                <span class="fa-solid fa-plus"></span>
                            </button>
                            </td>
                            <td>';
                    $price = floatval($row['price'])*$row['quantity'];
                    echo $price;
                    $cart_price+= $price;
                    echo '</td>
                        </tr>';
                }  
            }
        }
	}

           echo'
            <th></th>
            <th></th>
            <th>Total</th>
            <th>'. $cart_price. '</th>
            <th></th>
        </table>';

?>