<?php
    session_start(); 
    
    // If user is already logged in then redirect to welcome page
    if(isset($_SESSION['id'])){
        header('Location: welcome.php');
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
        <script src="js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="js/register.js"></script>
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
        <style>
            body{
                background-image: url('images/background.jpg');
            }
</style>
    <body>
        <header id="showcase">
        <p id="error"></p>
        <section class="vh-100 bg-image"
        style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <h2 class="text-uppercase text-center mb-5">Login</h2>
                                    <form id='login_form'>
                                        <!-- <div 
                                        class="alert alert-danger d-none" 
                                        id="error"
                                        ></div> -->

                                        <div class="form-outline mb-4">
                                            <input type="text" id="login_username" name="username" class="form-control form-control-lg" placeholder="Username" />
                                            <label class="form-label" for="form3Example4cdg"></label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="login_password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                            <label class="form-label" for="form3Example4cg"></label>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="button" value="Login" id="loginbtn"
                                            class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Log In</button>
                                        </div>
                                        <p class="text-center text-muted mt-4 mb-0">Do not have an account? 
                                        </p>
                                        <p class="text-center text-muted mt-4 mb-0">
                                            <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" data-bs-toggle="modal" data-bs-target="#Registration">Register</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <header>

        <!-- Registration Modal-->
        <div class="modal" id="Registration">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary">Registration Form</h3>
                    </div>
                    <div class="modal-body">
                        <p id="message" class="text-dark"></p>
                        <form>
                            <label class="form-label" for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control form-control-lg" placeholder="First name" required minlength="4" maxlength="50" />

                            <label class="form-label" for="surname">Surname</label>
                            <input type="text" id="surname" name="surname" class="form-control form-control-lg" placeholder="Surname" required minlength="4" maxlength="50" />

                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username" required minlength="4" maxlength="50" />

                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email" required maxlength="50" />

                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" required minlength="4" maxlength="50" />

                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" placeholder="Confirm" required minlength="4" maxlength="50" />

                            <label class="form-label" for="role">Role</label>
                            <div class="row">
                                <div class="col-12">
                                <select name="role" id="role" class="select form-control-lg">
                                    <option value="1" disabled>Choose option</option>
                                    <option value="ADMIN">Admin</option>
                                    <option value="PRODUCTSELLER">Product seller</option>
                                    <option value="USER">User</option>
                                </select>
                                </div>
                            </div>
                        </form>    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_register">Register</button> 
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_close">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <script>

            $(document).ready(function(){
                $(document).on('click','#loginbtn', function(){
                    var username = $("#login_username").val();
                    var password = $("#login_password").val();
                    if(username == ""){
                        $("#error").html(
                        '<p>Fill in Username!</p>'
                        );
                    }                    
                    else if(password == ""){
                        $("#error").html(
                        '<p>Fill in the Password!</p>'
                        )
                    }
                    else{
                        var login_data = $('#login_form').serialize(); // get form data
                        $.ajax({
                            url:"keyrock_signin.php",
                            method: "POST",
                            data: login_data,
                            success:function(data){
                                console.log(data);
                                if(data == "Log In"){
                                    window.location = "http://localhost/welcome.php";
                                }
                                else if( data == 'error'){
                                    $("#error").html('Wrong combination of Username or Password!');
                                    }
                                    else {
                                    $("#error").html('Fatal Error!');
                                    }
                            }
                        });
                    }
                })
            })
        </script>
    </body>
</html>