<?php
    session_start();
    include('functions.php');
    $oauth2token = $_SESSION['token'];
    // if search button is pressed
    //something is posted
    $filter_num = $_POST['filter']; 
    $search = $_POST['search']; // what was given to search
    $filter = find_filter($filter_num); // the filter

    $curl = "http://fiware-pep-proxy:3051/api/products/search.php?search=".$search."&filter=".$filter;

    $ch = curl_init($curl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oauth2token.''
    ));
    
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
    $result = json_decode($response, true);
    $output="";
    if (!empty($result['message']) && $result['message'] == 'No products Found'){
        echo "<tr >
        <td colspan='7'>No Result found !</td>
        </tr>";
    }
    else {
        if(count($result) > 0){
            foreach($result as $products) {	
                foreach($products as $row) {	
                    echo"<tr>
                        <td>".$row['name']. "</td></td>
                        <td>".$row['product_code']."</td></td>
                        <td>".$row['seller_name']."</td></td>
                        <td>".$row['price']."</td></td>
                        <td>".$row['date_of_withdrawal']."</td></td>
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
    }
?>