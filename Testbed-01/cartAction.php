<?php 

session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

$userId = $_SESSION['member_id'];


// Initialize shopping cart class 
require_once 'Cart.inc.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'DBController.php'; 
 
// Default redirect page 
$redirectLoc = 'index.php'; 
 
// Process request based on the specified action 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $productID = $_REQUEST['id']; 
         
        $db_handle = new DBController();
        
        $query = "SELECT * FROM apps_list WHERE appid = " . $productID;
        
        
        
        $result = $db_handle->runBaseQuery($query);
        if (!empty($result)){
            foreach ($result as $row){
                // Fetch all the results from our database
                
                $itemData['id'] = $row['appid'];
                $itemData['name'] = $row['name'];
                $itemData['price'] = $row['price'];
                $itemData['image'] = $row["image"];
                $itemData['publisher'] = $row['publisher'];
            }
        }
        
        
        if(empty($itemData)){
            
        }
        
        // Insert item to cart 
        $insertItem = $cart->insert($itemData); 
         
        // Redirect to cart page 
        $redirectLoc = $insertItem?'viewCart.php':'index.php'; 
        
        
        
    }
    elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ 
        // Update item data in cart 
        $itemData = array( 
            'rowid' => $_REQUEST['id'], 
            'qty' => $_REQUEST['qty'] 
        ); 
        $updateItem = $cart->update($itemData); 
         
        // Return status 
        echo $updateItem?'ok':'err';die; 
    }
    elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ 
        // Remove item from cart 
        $deleteItem = $cart->remove($_REQUEST['id']); 
         
        // Redirect to cart page 
        $redirectLoc = 'viewCart.php'; 
    }
    elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){
        //$redirectLoc = 'orderSuccess.php'; 
        $redirectLoc = $_SESSION["temp_link"];
        
        
        
        if ($_POST["isgift"]){
            $values = array_values($_POST['isgift']);
            
            $errorMsg = '';
            
            //Email address
            if (empty($_POST["email"]))
            {
                $errorMsg .= "Email is required.<br>";
            }
            else
            {
                $email = sanitize_input($_POST["email"]);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $errorMsg .= "Invalid email format.<br>";
                }
            }
            unset($isagift);
            $isagift = array();
            
            foreach($values as $test){
                if ($test == "For Me!"){
                    $test = "";
                }
                else{
                    $db_handle = new DBController();
                    $query = "SELECT member_id FROM steam_clone_members WHERE email = '" . $email. "'";
                    $result = $db_handle->runBaseQuery($query);
                    if (!empty($result)){
                        //echo "<script>alert('hello world')</script>";
                        foreach ($result as $row){
                            // Fetch all the results from our database
                            $test = $row["member_id"];
                            
                        }
                    }else{
                        $errorMsg .= "Email does not exist.<br>";
                    }
                }
                array_push($isagift, $test);
            }
            
            // Store post data 
            $_SESSION['postData'] = $_POST; 
 
            
        }
        
        if(empty($errorMsg)){
            // Insert order info in the database  
            $config = parse_ini_file('../../private/db-config.ini');
            $db = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']);

            
         
                
            $orderID = $_REQUEST['orderid'];

            // Retrieve cart items 
            $cartItems = $cart->contents(); 
            
            if(empty($cartItems)){
                echo "<script>alert('test123')</script>";
            }
            
            // Prepare SQL to insert order items 
            $sql = ''; 
                
            if(!empty($_POST["isgift"])){
                
                $it = new MultipleIterator;
                $a1 = new ArrayIterator($cartItems);
                $a2 = new ArrayIterator($isagift);
                $it->attachIterator($a1);
                $it->attachIterator($a2);
                

                foreach($it as $e){ 
                   $sql .= "INSERT INTO order_items (payment_id, product_id, quantity, gift_id) VALUES ('".$orderID."', '".$e[0]['id']."', '1', '".(int)$e[1]."');"; 
                }
            }
            else{
                foreach($cartItems as $item){ 
                    $sql .= "INSERT INTO order_items (payment_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '1');"; 
                }  
            }
            /*
            //foreach($values as $test)
            foreach($cartItems as $item){ 
                $sql .= "INSERT INTO order_items (payment_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '1');"; 
            }
             * 
             */ 

            // Insert order items in the database
            $insertOrderItems = $db->multi_query($sql); 
            
            if($insertOrderItems){ 
                // Remove all items from cart 
                $cart->destroy(); 

                // Redirect to the status page 
                //$redirectLoc = 'orderSuccess.php?id='.$orderID;
                $redirectLoc = 'index.php';
                unset($_SESSION['isgift']);
            }
            // Unable to execute Query
            else{                                                              
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'An internal error has occurred, please contact our support, and try again.'.$orderID; 
            } 
//            }else{ 
//                $sessData['status']['type'] = 'error'; 
//                $sessData['status']['msg'] = 'Some problem occurred, please try again.2'; 
//            }      
        } else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = 'Please correct the following mistakes.<br>'.$errorMsg;
        } 
        $_SESSION['sessData'] = $sessData; 
    } 
} 
else{
   $redirectLoc = 'checkout.php';  
}

function sanitize_input($data) 
{
    $data = trim($data);   
    $data = stripslashes($data);
    $data = htmlspecialchars($data);   
    return $data; 
}

// Redirect to the specific page 
header("Location: $redirectLoc"); 
exit();

?>
