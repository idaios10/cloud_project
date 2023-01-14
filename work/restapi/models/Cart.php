<?php
    class Cart {
        //The connection with the database
        private $con;

        // Constructor of class
        public function __construct($db){
            $this->con = $db;
        }

        // Get current user's cart
        public function viewCart($user_id) {
            $cart = $this->con->products_db->carts;
            $result = $cart->find(['userid' => $user_id])->toArray();
            return $result;
        }

        // add to cart
        public function addToCart($product_id, $user_id, $date){
            $cart = $this->con->products_db->carts;

            // the query to insert new item to cart
            $product = $cart->findOne(array("productid" => $product_id, "userid" => $user_id));

            if (!empty($product) && count($product) > 0){
                $quantity = $product['quantity'];
                $quantity += 1;
                $cart_id = $product['_id'];
                // Execute the query
                $result = $cart->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($cart_id)],
                    ['$set' => ['quantity' => $quantity]]    
                );
                return 1;
            }
            else{
                $doc = ["userid" => $user_id,"productid" => $product_id, "date_of_insertion" => $date, "quantity" => 1];
                // execute query
                $cart->insertOne($doc);
                return 2;
            }
            return -1;
        }

        public function deleteFromCart($id, $quantity){
            $cart = $this->con->products_db->carts;
            // if id has a value
            if(isset($id)){
                if($quantity == 1){
                    // delete from carts
                    $res = $cart->deleteOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);
                    return 0;
                }
                else{
                    // decrement 1 from quantity
                    $quantity -= 1;
                    $res = $cart->updateOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($id)],
                        ['$set' => ['quantity' => $quantity]]    
                    );
                    return 1;
                }
                return -1;
            }
        }


        public function insert_subAlert($date){

            $collection = $this->conn->products_db->subs;
            $query2 = $collection->insertOne(['date' => $date]);
            // try {
            //   $query1= $collection->findOne([
            //     'USERNAME' => $user,
            //     'TITLE' => $title
            //   ]);
            // } catch (Exception $ex) {
            //   echo $ex->getMessage();
            //   return -1;
            // }

            // if($query1 != null){

            //     try {
            //       $query2= $collection->replaceOne([
            //         'TITLE' => $title,
            //         'USERNAME' => $user
            //         ],
            //         ['TITLE' => $title,
            //         'USERNAME' => $user,
            //         'STARTDATE' => $startdate,
            //         'ENDDATE' => $enddate
            //         ]
            //       );
            //     } catch (Exception $ex) {
            //       echo $ex->getMessage();
            //       return -1;
            //     }
        
            //   }
            //   else{
        
            //     try {
            //       $query2 = $collection->insertOne([
            //         'USERNAME' => $user,
            //         'TITLE' => $title,
            //         'STARTDATE' => $startdate,
            //         'ENDDATE' => $enddate
            //       ]);
            //     }catch (Exception $ex) {
            //       echo $ex->getMessage();
            //       return -1;  
            //     } 
        
            //   }
            //   return 1;
        }

    }   

?>