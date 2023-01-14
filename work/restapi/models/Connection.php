<?php
    require '/var/www/vendor/autoload.php';

    class Connection {
        private $con;

        function __construct() {
            //Connection to Mongo Database which has data for carts and products
            try {
                $this->con = new MongoDB\Client("mongodb://root:mongopwd@mongo:27017");

            }catch (Exception $e) {
                echo $e->getMessage();
                echo nl2br("n");
            }
        }

        function getConnection() {
            return $this->con;
        }

    }
?>