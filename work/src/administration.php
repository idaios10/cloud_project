<?php 
    //start of session
    session_start();
    //includes needed
    include("functions.php");

    $user_data = check_login();

    // if role not ADMIN then redirect to welcome page
    if (!check_admin($user_data['role'])) {
        # redirect to welcome
        header("Location: welcome.php");
        echo "not an admin";
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
    <head>
        <!-- Every css and js file needed is included with link and script tags -->
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
        <script src="js/admin.js"></script>
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <body>
        <!-- The navbar -->
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
                        <!-- Table headers -->
                        <!-- <th>First Name</th>
                        <th>Surname</th> -->
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Confirm</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="table">
                <!-- Here goes the main body of the table-->
                <!-- view all users is implemented with the use of admin.js file-->
                </tbody>
            </table>
        </header>
        <!-- Edit User Modal-->
        <div class="modal" id="update_user">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Update User</h3>
                    </div>
                    <div class="modal-body">
                        <p id="up-message" class="text-dark"></p>
                        <form>
                            <input type="hidden" id="id"  class="form-control form-control-lg"/>
                            <!-- <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Name" required minlength="4" maxlength="50" />

                            <label class="form-label" for="surname">Surname</label>
                            <input type="text" id="surname" name="pcode" class="form-control form-control-lg" placeholder="Surname" required minlength="4" maxlength="50" /> -->

                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username" required minlength="4" maxlength="50" />

                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email" required maxlength="50" />

                            <label class="form-label" for="category">Role</label>
                            <select name="role" id="role" class="select form-control-lg">
                                <option value="1" disabled>Choose option</option>
                                <option value="ADMIN">Admin</option>
                                <option value="PRODUCTSELLER">Product seller</option>
                                <option value="USER">User</option>
                            </select>

                        </form>    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_update">Update</button> 
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete User Modal-->
        <div class="modal" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Delete User</h3>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                        <button type="button" class="btn btn-success" id="delete_user">Delete</button> 
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>


        <!-- Confirm User Modal-->
        <div class="modal" id="confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Confirm User</h3>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to confirm this user?</p>
                        <button type="button" class="btn btn-success" id="confirm_user">Confirm</button> 
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>