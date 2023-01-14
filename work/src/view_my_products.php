<?php
	session_start();
    include("functions.php");
	$user_data = check_login();
	$username = $user_data['username'];
	$oath2token = $_SESSION['token'];

	// tranform data into array to encode it later
	$data = array(
		'username' => $username,
	);

	$json_data = json_encode($data);
	// The request
	$curl = "http://fiware-pep-proxy:3051/api/products/view_my_products.php";

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


    if (!empty($result['message']) && $result['message'] == 'No products Found'){
		echo "<tr >
		<td colspan='6'>No Result found !</td>
		</tr>";
	}
	else {
		if(count($result) > 0){
			foreach($result as $my_products) {		
				foreach($my_products as $row) {		
					echo "<tr>
						<td>".$row['name']. "</td>
						<td>".$row['product_code']."</td>
						<td>".$row['price']."</td>
						<td>".$row['date_of_withdrawal']."</td>
						<td>".$row['category']."</td>
						<td>
							<button class='btn btn-success' id='btn_edit' 
							data-id=".$row['id']."
							data-name=".$row['name']."
							data-pcode=".$row['product_code']."
							data-price=".$row['price']."
							data-date=".$row['date_of_withdrawal']."
							data-category=".$row['category'].">
								<span class='fa fa-edit'></span>
							</button>
						</td>
						<td><button class='btn btn-danger' id='btn_delete' 
						data-id1=".$row['id']."><span class='fa fa-trash'></span></button</td>
					</tr>";
				}
			}
		}

	}
?>