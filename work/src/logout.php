<?php 
    session_start();
    if(isset($_SESSION['id'])){
        unset($_SESSION['id']);
        unset($_SESSION['username']);
    }

    header("Location: index.php");
    die;
?>