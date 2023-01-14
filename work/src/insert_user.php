<?php
    session_start();
    include("connection.php");
    include("functions.php");
    insert_user($con);
?>