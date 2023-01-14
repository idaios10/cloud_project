<?php 
    // function to check if user is logged in 
    function check_login(){
        
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $username = $_SESSION['username'];
            $role = $_SESSION['role'];
            return array('role'=>$role, 'username'=> $username, 'id' => $id); 
        }
        //else redirect to login
        header("Location: index.php");
    }


    // function to print the navbar for welcome page
    function print_navbar($role, $username){
        // if role == ADMIN show specific sites
        if($role == "ADMIN"){
            echo '      <li><a href="administration.php">Admin</a></li>

                        <li><a href="cart.php">Cart</a></li>

                        <li><a href="logout.php">Logout</a></li>

                        <li><a href="#">('.$username . ', '. $role . ')</a></li>';
        }
        // if role == PRODUCT SELLER show specific sites
        else if($role == "PRODUCTSELLER"){
            echo '      <li><a href="seller.php">Seller</a></li>

                        <li><a href="cart.php">Cart</a></li>

                        <li><a href="logout.php">Logout</a></li>

                        <li><a href="#">('.$username . ', '. $role . ')</a></li>';
        }
        // if role == USER show specific sites
        else if($role == "USER"){
            echo '<li><a href="cart.php">Cart</a></li>

                <li><a href="logout.php">Logout</a></li>

                <li><a href="#">('.$username . ', '. $role . ')</a></li>';
        }
    }

    // Function to Insert User in database
    function insert_user($con){
        // take everything that is posted by ajax
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];
        $role = $_POST['role']; 
        $confirmed = 0;
        $db = $con->products_db;
        // if username already exists print error
        if(check_username($username)){
            echo "This username already exists";
            return;
        }

        // if password matches confirm_password
        if($password == $confirm_password){
            // execute query to insert the new user
            $col = $db->users;
	
	        $doc = ["name" => $firstname,"surname" => $surname, "username" => $username, "email" => $email,"password" => $password, "role" => $role, "confirmed" => $confirmed];
	        $col->insertOne($doc);
            echo "User successfully entered into Database";
        }

        // if it does not match then print error message
        else{
            echo "Passwords does not match";
        }
    }

    // function to check if the username given as arguement already exists in the database
    function check_username($username){
        include("connection.php");
        $user = $db->users->findOne(array("username" => $username));

        // return true if username already exists
        if ($user != null && $user->count() > 0)
            return true;
        // returns false if not
        return false;
    }
 
    // Function that checks if user's role is an ADMIN
    function check_admin($role){
        if($role == "ADMIN"){
            //return true if it is
            return 1;
        }
        // returns false if it's not
        return 0;
    }

    // Function that checks if user's role is PRODUCTSELLER
    function check_seller($role){
        if($role == "PRODUCTSELLER"){
            //return true if it is
            return 1;
        }
        // returns false if it's not
        return 0;
    }

    // check if we do not have empty fields
    function check_boxes($name, $pcode, $price, $date, $category){
        if(!empty($name) && !empty($pcode) && !empty($price) && !empty($date) && !empty($category)){
            return 1;
        }
        return 0;
    }


    // Function to find what role the user has
    // This function was used in the early stages of the project
    // Maybe useless right now
    function find_filter($num){
        switch ($num) {
            case 2:
                $filter = "name";
                break;
            case 3:
                $filter = "seller_name";
                break;
            case 4:
                $filter = "price";
                break;
            case 5:
                $filter = "category";
                break;
            case 6:
                $filter = "product_code";
                break;
        }
        return $filter;
    }

    // Function that deletes a product from the users cart when this product is deleted
    function delete_from_carts($product_id){
        include("connection.php");
        $query = "delete from carts where productid = '$product_id'";
        $result = mysqli_query($con,$query);
    }
    
    // Function that deletes all product from all users carts when a user is deleted
    function delete_user_from_carts($user_id, $con){
        $query = "delete from carts where userid = '$user_id'";
        $result = mysqli_query($con,$query);
        if($result){
            echo $user_id;
        }
    }



    // Function that deletes a user's product from database when this user is deleted
    function delete_my_products($seller_name,$con){
        $query = "SELECT id FROM products WHERE seller_name = '$seller_name'";
        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $pid = $row['id'];
                $query = "DELETE FROM carts WHERE productid = '$pid'";
                $sql = mysqli_query($con,$query);
            }
        }
        $query = "DELETE FROM products WHERE seller_name = '$seller_name'";
        $result = mysqli_query($con,$query);
    }

    function http_parse_headers($raw_headers)
    {
        $headers = array();
        $key = ''; // [+]

        foreach(explode("\n", $raw_headers) as $i => $h)
        {
            $h = explode(':', $h, 2);

            if (isset($h[1]))
            {
                if (!isset($headers[$h[0]]))
                    $headers[$h[0]] = trim($h[1]);
                elseif (is_array($headers[$h[0]]))
                {
                    // $tmp = array_merge($headers[$h[0]], array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1]))); // [+]
                }
                else
                {
                    // $tmp = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [+]
                }

                $key = $h[0]; // [+]
            }
            else // [+]
            { // [+]
                if (substr($h[0], 0, 1) == "\t") // [+]
                    $headers[$key] .= "\r\n\t".trim($h[0]); // [+]
                elseif (!$key) // [+]
                    $headers[0] = trim($h[0]);trim($h[0]); // [+]
            } // [+]
        }

        return $headers;
    }
?>