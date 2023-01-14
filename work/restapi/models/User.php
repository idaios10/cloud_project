<?php
    class User {
        // Constructor of class
        public function __construct(){

        }

        function getUsers($xtoken){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://keyrock:3005/v1/users',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "X-Auth-Token: ".$xtoken.""
                ),
            ));
        
            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response, true);
            $users = array();
            $users['data'] = array();
            foreach($result as $key){
                foreach($key as $doc){
                  $userid = $doc['id'];
                  $username = $doc['username'];
                  $email = $doc['email'];
                  $role = $this->findRole($xtoken, $userid);
                  $item = array(
                    'id' => $userid,
                    'username' => $username,
                    'email' => $email,
                    'role' => $role
                  );
                  array_push($users['data'], $item);
                }
            }
            return $users;
        }


        function updateUser($data){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/users/". $data->id."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"user\": {
                \"username\": \"". $data->username."\",
                \"email\": \"". $data->email. "\"
            }
            }");
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-Auth-token: ". $data->xtoken. ""
            ));
            
            $response = curl_exec($ch);
            curl_close($ch);
            $role_id = $this->find_roleID($data->role);
            $old_role = $this->findRole($data->xtoken, $data->id);
            $old_role_id = $this->find_roleID($old_role);
            if($old_role != 'not confirmed'){

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/c24f30ba-8eca-4933-a840-60812e046d32/users/".$data->id."/roles/".$old_role_id."");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "X-Auth-token: ". $data->xtoken.""
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                echo $response;
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/c24f30ba-8eca-4933-a840-60812e046d32/users/".$data->id."/roles/".$role_id."");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "X-Auth-token: ". $data->xtoken
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
            return $response;
        }


        function deleteUser($xtoken, $id){
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/users/".$id."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Auth-token: ". $xtoken. ""
            ));
            
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

        function confirmUser($xtoken, $id){
            $appID = "c24f30ba-8eca-4933-a840-60812e046d32";
            $roleUserID = "a249042c-2ffd-49ff-a028-31c51a2e638b";
            $roleAdminID = "98d333fc-1431-44bb-bb9d-120efbbe3777";
            $roleSellerID = "5ebdeb0d-f0d1-492a-a34e-5e7194c5b120";
            $orgUsersID = "adf8db42-88f5-4617-8a04-524b9d4cae0e";
            $orgSellersID = "dd2aea84-11c7-4a0b-b60e-a6895c7ed927";
            // Id of the user you want to confirm
            $role = $this->createRoleFromOrganization($id, $xtoken, $orgUsersID, $orgSellersID);
            $roleID = $this->find_roleID($role);
            if($role == "USER"){
                $orgID = $orgUsersID;
                $role_org = 'member';
            }elseif($role == "ADMIN"){
                $orgID = $orgUsersID;
                $role_org = 'owner';
            }
            elseif($role == "PRODUCTSELLER"){
                $orgID = $orgSellersID;
                $role_org = 'member';
            }
            if(!empty($orgID)){
                $this->deleteUserFromOrganization($id, $orgID, $role_org, $xtoken);
                $this->addUserToApplication($id, $roleID, $xtoken);
                
                // Print message if everything is fine
                return "User Confirmed";
            }
            return null;
        }

        function findRole($xtoken, $userid){
            $appID = "c24f30ba-8eca-4933-a840-60812e046d32";
            $roleUserID = "a249042c-2ffd-49ff-a028-31c51a2e638b";
            $roleAdminID = "98d333fc-1431-44bb-bb9d-120efbbe3777";
            $roleSellerID = "5ebdeb0d-f0d1-492a-a34e-5e7194c5b120";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/".$appID."/users/".$userid."/roles");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-Auth-token: ".$xtoken.""
            ));
            
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);
            foreach($res as $r){
                foreach($r as $roleid){
                    if(!empty($roleid['role_id']))
                        $role = $roleid['role_id'];
                    else
                        return 'not confirmed';
                }
            }
            if ($role == $roleUserID) {
                $role = "USER";
            }
            elseif ($role == $roleAdminID) {
                $role = "ADMIN";
            }
            elseif ($role == $roleSellerID){
                $role = "PRODUCTSELLER";       
            }
            else {
                $role = '';
            }
            return $role;
        }


        function find_roleID($role){
            $roleUserID = "a249042c-2ffd-49ff-a028-31c51a2e638b";
            $roleAdminID = "98d333fc-1431-44bb-bb9d-120efbbe3777";
            $roleSellerID = "5ebdeb0d-f0d1-492a-a34e-5e7194c5b120";
    
            if($role == 'USER'){
                return $roleUserID;
            }
            elseif($role == 'PRODUCTSELLER'){
                return $roleSellerID;
            }
            elseif ($role == "ADMIN") {
                return $roleAdminID;
            }else{
                return -1;
            }
        }


        function createRoleFromOrganization($id, $xtoken, $orgUsersID, $orgSellersID){
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgUsersID."/users");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Auth-token: ". $xtoken.""
            ));
            
            $response = curl_exec($ch);
            curl_close($ch);
    
            $result = json_decode($response, true);
            foreach($result as $key){
                foreach($key as $doc){
                    if($doc['user_id'] == $id){
                        if($doc['role'] == 'owner'){
                            return "ADMIN";
                        }
                        elseif($doc['role'] == 'member'){
                            return "USER";
                        }
                    }
                }
            }
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgSellersID."/users");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Auth-token: ". $xtoken.""
            ));
            
            $response = curl_exec($ch);
            curl_close($ch);
    
            $result = json_decode($response, true);
            foreach($result as $key){
                foreach($key as $doc){
                    if($doc['user_id'] == $id){
                        if($doc['role'] == 'member'){
                            return "PRODUCTSELLER";
                        }
                    }
                }
            }
            return null;
        }


        function deleteUserFromOrganization($id, $orgID, $role_org, $xtoken){
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/organizations/". $orgID."/users/". $id."/organization_roles/". $role_org."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Auth-token: ". $xtoken.""
            ));
    
            $response = curl_exec($ch);
            curl_close($ch);
        }
    
        function addUserToApplication($id, $role_id, $xtoken){
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/c24f30ba-8eca-4933-a840-60812e046d32/users/".$id."/roles/".$role_id."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-Auth-token: ". $xtoken
            ));
    
            $response = curl_exec($ch);
            curl_close($ch);
        }

    }   

?>