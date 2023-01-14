<?php 
    session_start();
    include("functions.php");
    $user_data = check_login();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/a5e5591a7e.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/navbar.css"\>
        <link rel="stylesheet" href="admin.css"\>
        <script src="js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="js/cart.js"></script>
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
        <title>Cart</title>
    </head>
    <body>
        <nav class="navbar">
            <!-- LOGO -->
            <div class="logo">ESHOP</div>

                <!-- NAVIGATION MENU -->
                <ul class="nav-links">

                    <!-- USING CHECKBOX HACK -->
                    <input type="checkbox" id="checkbox_toggle" />

                    <label for="checkbox_toggle" class="hamburger">&#9776;</label>

                    <!-- NAVIGATION MENUS -->
                    <div class="menu">
                        <li><a href="welcome.php">Home</a></li>

                        <?php
                        if($user_data['role'] == 'ADMIN'){
                            echo '<li><a href="administration.php">Admin</a></li>';
                        }
                        else if($user_data['role'] == 'PRODUCTSELLER'){
                            echo '<li><a href="seller.php">Seller</a></li>';
                        }
                        ?>

                        <li><a href="products.php">Products</a></li>
                        
                        <li><a href="logout.php">Logout</a></li>

                        <li><a href="#"><?php echo'('.$user_data['username'] . ', '. $user_data['role'] . ')'?></a></li>
                    </div>

                </ul>
            </div>
        </nav>
        <header id="showcase">
            <p id="message" class="text-dark"></p>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody id="table">
            
                </tbody>
            </table>
            
        <!-- Delete Product From Cart Modal-->
       <div class="modal" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Delete</h3>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this product from the cart?</p>
                        <button type="button" class="btn btn-success" id="delete_product">Delete</button> 
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>