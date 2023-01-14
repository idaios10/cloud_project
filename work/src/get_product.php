<?php
    include("connection.php");
    include("functions.php");
    $product_id = $_POST['product_id'];
    $query = "SELECT * FROM products WHERE id='$product_id'";
    $result = mysqli_query($con, $query);
    while($row=mysqli_fetch_assoc($result)){
        $product = "";
        $product[0] = $row['id'];
        $product[1] = $row['name'];
        $product[2] = $row['product_code'];
        $product[3] = $row['price'];
        $product[4] = $row['date_of_withdrawl'];
        $product[5] = $row['seller_name'];
        $product[6] = $row['category'];
    }
    echo ($product);
?>