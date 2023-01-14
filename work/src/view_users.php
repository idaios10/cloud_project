<?php
    include("functions.php");
    session_start();
    $xtoken = $_SESSION['xtoken'];
    $oath2token = $_SESSION['token'];
      $data = array(
        'xtoken' => $xtoken,
    );

    $json_data = json_encode($data);
    // The request
    $curl = "http://fiware-pep-proxy:3051/api/user/view.php";

    $ch = curl_init($curl);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Auth-Token: '.$oath2token.''
    ));
    $response = curl_exec($ch);
    // echo $response;
    curl_close($ch);
    $result = json_decode($response, true);
    
  
      foreach($result as $key){
        foreach($key as $row){
          echo "<tr>
          <td>".$row['username']."</td>
          <td>".$row['email']."</td>
          <td>".$row['role']."</td>";
          if($row['role'] == 'not confirmed'){
            echo "  <td><button class='btn btn-success' id='btn_confirm'
                    data-id=".$row['id'].">
                    <span class='fa-solid fa-check'></span>
                    </button></td>";
          }
          else{
            echo "<td>CONFIRMED</td>";
          }
          echo "<td>
                <button class='btn btn-success' id='btn_edit' 
                data-id=".$row['id']."
                data-username=".$row['username']."
                data-email=".$row['email']."
                data-role=". $row['role'].">
                    <span class='fa fa-edit'></span>
                </button>
                </td>
                <td><button class='btn btn-danger' id='btn_delete' 
                data-id1=".$row['id']."
                data-role=".$row['role']."
                data-username=".$row['username']."><span class='fa fa-trash'></span></button</td>
                </tr>";
        }
      }

//     }
//     else {
//         echo "<tr >
//         <td colspan='6'>No Result found !</td>
//         </tr>";
// }

?>