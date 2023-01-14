<?php
    session_start();
    include("functions.php");
    $user_data = check_login();
    if (($user_data['role'] != 'PRODUCTSELLER')) {
        # redirect to welcome
        header("Location: welcome.php");
        echo "not product seller";
    }
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
        <script src="js/seller.js"></script>
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

                        <li><a href="products.php">Products</a></li>
                        
                        <li><a href="cart.php">Cart</a></li>

                        <li><a href="logout.php">Logout</a></li>

                        <li><a href="#"><?php echo'('.$user_data['username'] . ', '. $user_data['role'] . ')'?></a></li>
                    </div>

                </ul>

            </nav>
        <p id="message" class="text-dark"></p>
        <header id="showcase">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Product code</th>
                        <th>Price</th>
                        <th>Date of Withdrawal</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="table">
                
                </tbody>
            </table>
        
            <!-- Registration button-->
            <p class="text-center text-muted mt-4 mb-0">
            <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" data-bs-toggle="modal" data-bs-target="#Registration">Add New Product</button>
            </p>
        </header>

        <!-- Registration Modal-->
        <div class="modal" id="Registration">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Registration Form</h3>
                    </div>
                    <div class="modal-body">
                        <p id="msg" class="text-dark"></p>
                        <form>
                            <label class="form-label" for="firstname">Name</label>
                            <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Name" required minlength="4" maxlength="50" />

                            <label class="form-label" for="surname">Product Code</label>
                            <input type="text" id="pcode" name="pcode" class="form-control form-control-lg" placeholder="Product Code" required minlength="4" maxlength="50" />

                            <label class="form-label" for="username">Price</label>
                            <input type="text" id="price" name="price" class="form-control form-control-lg" placeholder="Price" required minlength="4" maxlength="50" />

                            <label class="form-label" for="email">Date of withdrawal</label>
                            <input type="date" id="date" name="date" class="form-control form-control-lg" placeholder="Date of withdrawal" required maxlength="50" />

                            <label class="form-label" for="password">Category</label>
                            <input type="text" id="category" name="category" class="form-control form-control-lg" placeholder="Category" required minlength="4" maxlength="50" />
 
                        </form>    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_register">Add Product</button> 
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Product Modal-->
        <div class="modal" id="update">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Update Product</h3>
                    </div>
                    <div class="modal-body">
                        <p id="up-message" class="text-dark"></p>
                        <form>
                            <input type="hidden" id="up_id"  class="form-control form-control-lg"/>
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="up_name" name="name" class="form-control form-control-lg" placeholder="Name" required minlength="4" maxlength="50" />

                            <label class="form-label" for="surname">Product Code</label>
                            <input type="text" id="up_pcode" name="pcode" class="form-control form-control-lg" placeholder="Product Code" required minlength="4" maxlength="50" />

                            <label class="form-label" for="username">Price</label>
                            <input type="text" id="up_price" name="price" class="form-control form-control-lg" placeholder="Price" required minlength="4" maxlength="50" />

                            <label class="form-label" for="email">Date of withdrawal</label>
                            <input type="date" id="up_date" name="date" class="form-control form-control-lg" placeholder="Date of withdrawal" required maxlength="50" />

                            <label class="form-label" for="category">Category</label>
                            <input type="text" id="up_category" name="category" class="form-control form-control-lg" placeholder="Category" required minlength="4" maxlength="50" />
 

                        </form>    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_update">Update</button> 
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Product Modal-->
        <div class="modal" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Delete Product</h3>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this product?</p>
                        <button type="button" class="btn btn-success" id="delete_product">Delete</button> 
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>