<?php

// Include the database config file 
require_once 'DBController.php'; 
/*
ini_set('display_errors', 'on');
error_reporting(E_ALL);
 * 
 */
$test = "";
$email = $_REQUEST["q"];

if ($email !== ""){
    $db_handle = new DBController();
    
    //$query = "SELECT * FROM user_payments WHERE txn_id = '$txn_id'"; 
    //$prevPaymentResult = $db_handle->runBaseQuery($query);
    
    $query = "SELECT member_id FROM steam_clone_members WHERE email = '$email';";
    $result = $db_handle->runBaseQuery($query);
    if (!empty($result)){
        foreach ($result as $row){
            // Fetch all the results from our database
            $test = $row["member_id"];

        }
        if ($test == 0){
            $test = "";
        }
    }
}

echo $test === "" ? "Email does not exist." : "Email exist";

?>