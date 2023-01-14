<?php
    class Product {
        private $con;
        private $folder_name = 'products';
        private $dbname = 'products_db';
        

        public $id;
        public $name;
        public $product_code;
        public $price;	
        public $date_of_withdrawal;
        public $seller_name;
        public $category;
        

        public function __construct($db) {
            $this->con = $db;
        }

        /**
         * Function that cretates the Mongodb query to get everything from the collection products
         */
        public function get_all_products(){
            $products = $this->con->products_db->products;

            try { 
                $result = $products->find()->toArray();
            }catch (Exception $ex) {
                echo $ex->getMessage();
                $success = 0;
            }
              return $result;
        }


        public function search($search, $filter){
            $products = $this->con->products_db->products;

            if(empty($search)){
                try{
                    $result = $products->find()->toArray();
                }catch (Exception $ex) {
                    echo $ex->getMessage();
                    $success = 0;
                }
            }

            // if filter = price then search for products less than the price given 
            elseif($filter == "price"){
                $query = "SELECT *
                  FROM products 
                  WHERE price < '$search'";
            }

            // else search the text
            else{
                $result = $products->find(array( $filter => array('$regex' => $search)))->toArray();
            }
            return $result;
       }


       public function findProductName($product_id){
        $products = $this->con->products_db->products;

        $result = $products->findOne(['_id' => new \MongoDB\BSON\ObjectID($product_id)]);
        if($result != null && count($result) > 0)
            return $result['name'];
        return $product_id;
        }
        
        public function findPrice($pid){
            $products = $this->con->products_db->products;
            $res = $products->findOne(['_id' => new \MongoDB\BSON\ObjectID($pid)]);
            if($res && count($res) > 0){
                return $res['price'];
            }
            return $pid;
        }

        public function findWithdrawalDate($pid){
            $products = $this->con->products_db->products;
            $res = $products->findOne(['_id' => new \MongoDB\BSON\ObjectID($pid)]);
            if($res && count($res) > 0){
                return $res['date_of_withdrawal'];
            }
            return $pid;
        }

        public function viewMyProducts($username){
            $products = $this->con->products_db->products;

            $my_products = $products->find(['seller_name' => $username])->toArray();
            return $my_products;
        }


        public function addToProducts($data){
            $products = $this->con->products_db->products;

            // if price is a float number then everything is fine and execute query
            if($this->check_float($data->price)){
                $doc = ["name" => $data->name,"product_code" => $data->product_code, "price" => $data->price, "date_of_withdrawal" => $data->date,"seller_name" => $data->username, "category" => $data->category];
                $products->insertOne($doc);
                return 1;
            }

            // if price not a number then print error message
            else{
                return 0;
                // echo $price ."Price is not a float number";
            }
            return -1;   
        }

        // function that checks if the price parameter given in the form is a number
        public function check_float($price){
            // returns true if it is a number
            if(is_numeric($price)){
                return true;
            }
            // returns false if it isn't a number
            return false;
        }


        public function updateProduct($data){
            $products = $this->con->products_db->products;
            // Execute the query
            $result = $products->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($data->id)],
                ['$set' => ['name' => $data->name, 'product_code' => $data->product_code, 'price' => $data->price, 'date_of_withdrawal' => $data->date, 'category'=> $data->category]]    
            );
            if($result)
                return 1;
            return 0;
        }
        

        public function deleteProduct($id){
            $products = $this->con->products_db->products;
            // Execute the query
            $result = $products->deleteOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);
            if($result)
                return 1;
            return 0;
        }

    }
?>