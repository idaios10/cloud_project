<?php
    session_start();
    include("functions.php");
    $user_data = check_login();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Website</title>
        <script src="https://kit.fontawesome.com/a5e5591a7e.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/navbar.css"\>
        <link rel="stylesheet" href="admin.css"\>
        <script src="js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="js/products.js"></script>
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
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
                            if($user_data['role'] == "ADMIN"){
                                echo '<li><a href="administration.php">Admin</a></li>';
                            }
                            else if($user_data['role'] == "PRODUCTSELLER"){
                                echo '<li><a href="seller.php">Seller</a></li>';
                            }
                        ?>
                        
                        <li><a href="cart.php">Cart</a></li>

                        <li><a href="logout.php">Logout</a></li>

                        <li><a href="#"><?php echo'('.$user_data['username'] . ', '. $user_data['role'] . ')'?></a></li>
                    </div>

                </ul>

            </nav>
        <p id="delete-message" class="text-dark"></p>
        <p id="message" class="text-dark"></p>
        <p id="orion1" class="text-dark"></p>
        <p id="orion2" class="text-dark"></p>
        <header id="showcase">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Product code</th>
                    <th>Seller Name</th>
                    <th>Price</th>
                    <th>Date of Withdrawal</th>
                    <th>Category</th>
                    <th>Add To Cart</th>
                </tr>
            </thead>
            <tbody id="table">
                <!-- Here goes the main body of the table-->
                <!-- view all users is implemented with the use of admin.js file-->
            </tbody>
        </header>
        </table>

    <div class="container mt-3 pb-3 pt-3" style="background-color: rgb(217,235,250); border-radius: 20px;">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                    <input type="search" class="form-control" name="search" id="search" placeholder="Search">
                    <select name="filter" id="filter" class="select form-control-sm">
                        <option value="1" disabled>Choose option</option>
                        <option value="2">Product name</option>
                        <option value="3">Seller name</option>
                        <option value="4">Price</option>
                        <option value="5">Category</option>
                        <option value="6">Product Code</option>
                    </select>
                    <button type="submit" class="btn btn-primary" id="btn_search"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                    Search
                    </button>
            </div>
        </div>
    </div>

</body>
</html>
