<?php 
    session_start();
    include("functions.php");
    $user_data = check_login();
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="welcome.css"/>
    <link rel="stylesheet" href="css/navbar.css"/>
        <title>Welcome</title>
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
                    <?php print_navbar($user_data['role'], $user_data['username'])?>
                </div>

            </ul>

        </nav>

        <header id="showcase">
            <h1>Welcome to the Eshop</h1>
            <a href="products.php" class="button">Shop Now</a>
        </header>

    </body>
</html>