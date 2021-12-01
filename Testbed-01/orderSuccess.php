<?php 
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
*/
//if(!isset($_REQUEST['id'])){ 
//    header("Location: index.php"); 
//} 

session_start();
require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

// Include PHPMailer function file
include_once 'email.php';

// Include PayPal configuration file 
include_once 'paypal_config.php';  

// Include the database config file 
require_once 'DBController.php'; 

// Initialize shopping cart class 
include_once 'Cart.inc.php'; 
$cart = new Cart; 

// Ensure only logged in users can access this page
$userId = $_SESSION['member_id'];
if (empty($userId)){
    echo "<script>alert('You are not authorized!');</script>";
    header("Location: index.php");
}


// If transaction data is available in the URL 
if ($_SERVER["REQUEST_METHOD"] == "GET"){    
// Get transaction information from URL 
    $item_number = $_GET['item_number'];  
    $txn_id = $_GET['tx']; 
    $payment_gross = $_GET['amt']; 
    $currency_code = $_GET['cc']; 
    $payment_status = $_GET['st']; 
    $payment_date = $_GET['payment_date'];
    $buyer_name = $_GET['address_name'];
    $buyer_email = $_GET['payer_email'];

    $db_handle = new DBController();
    
    // Transaction History redirect from Accounts Page clause
    $payment_id = $_GET['id'];
    if(!empty($payment_id)){
        $query = "SELECT * FROM user_payments WHERE payment_id = '$payment_id'";
        $payment_history = $db_handle->runBaseQuery($query);
        foreach ($payment_history as $row) {
            $txn_id  = $row['txn_id'];
        }
} else {
    header("Location: ./index.php");
}
}

?>

<!DOCTYPE html>
<html lang="EN">
<title>GamesDex: Order Successful</title>
<meta name="Successful Order" content="width=device-width, initial-scale=1.0">
<?php
    include "head.inc.php";
?>

<body class="bg-dark">
    <?php
            include "nav.inc.php";
        ?>
    
    <main class="container jumbotron text-center mb-0 ord-container">
        <h1>Your Order Details</h1>
        <div class="col-12">
            <?php 
                // Check if transaction data exists with the same TXN ID. 
                if(!empty($txn_id)){ 
                    $query = "SELECT * FROM user_payments WHERE txn_id = '$txn_id'"; 
                    $prevPaymentResult = $db_handle->runBaseQuery($query);
                    
                    if(!empty($prevPaymentResult)){ 
                        foreach ($prevPaymentResult as $paymentrow) { 
                            $payment_gross = $paymentrow['payment_gross']; 
                            $payment_status = $paymentrow['payment_status'];
                            $payment_date = $paymentrow['payment_date'];
                            $buyer_name = $paymentrow['buyer_name'];
                            $buyer_email = $paymentrow['buyer_email'];
                        } 
                    }else{ 
                        // Insert tansaction data into the database 
                        $query = "INSERT INTO user_payments(item_number,txn_id,payment_gross,currency_code,payment_status, payment_date, buyer_name , buyer_email, customer_id)"
                                . "VALUES('".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."','".$payment_date."','".$buyer_name."','".$buyer_email."','".$userId."')";
                        $insert = $db_handle->runBaseQuery($query);
                        
                        $query = "SELECT * FROM user_payments WHERE txn_id = '$txn_id'";
                        $result = $db_handle->runBaseQuery($query);
                        foreach ($result as $row) {
                            $payment_id = $row['payment_id'];
                        }
                        
                        $gamekey = generateGameKey();
                        
                        //get cart items from session 
                        $cartItems = $cart->contents(); 
                        
                        
                        $message = "<html>
                                    <head>
                                    <title>Heyy</title>
                                    </head>
                                    <body>                
                                    <div style='width:800px;background:#fff;border-style:groove;'>
                                    <div style='width:50%;text-align:left;'><a href='your website url'> <img 
                                    src=\"cid:logo_p2t\" height=60 width=200;'></a></div>
                                    <hr width='100%' size='2' color='#A4168E'>
                                    <div style='width:50%;height:20px; text-align:right;margin-
                                    top:-32px;padding-left:390px;'><a href='your url' style='color:#00BDD3;text-
                                    decoration:none;'> 
                                    My Bookings</a> | <a href='your url' style='color:#00BDD3;text-
                                    decoration:none;'>Dashboard </a> </div>
                                    <h2 style='width:50%;height:40px; text-align:right;margin:0px;padding-
                                    left:390px;color:#B24909;'>Booking Confirmation</h2>
                                    <div style='width:50%;text-align:right;margin:0px;padding-
                                    left:390px;color:#0A903B'> Booking ID:1150 </div>
                                    <h4 style='color:#ea6512;margin-top:-20px;'> Hello, " .$buyer_name."
                                    </h4>
                                    <p>Thank You for booking with us.Your Booking Order is Confirmed Now. Please 
                                    find the trip details along with the invoice. </p>
                                    <hr/>
                                    <div style='height:210px;'>
                                    <table cellspacing='0' width='100%' >
                                    <thead>
                                    <col width='80px' />
                                    <col width='40px' />
                                    <col width='40px' />
                                    <tr>          
                                    <th style='color:#0A903B;text-align:center;'>" .$txn_id."</th>                           
                                    <th style='color:#0A903B;text-align:left;'>Traveller Info</th>
                                    <th style='color:#0A903B;text-align:left;'>Your Pickup Details: </th>                                                                            
                                    </tr>
                                    </thead>
                                    <tbody>   
                                    <tr>
                                    <td style='color:#0A903B;text-align:left;padding-bottom:5px;text-
                                    align:center;'><img src=\"cid:logo_p2t1\" height='90' width='120'></td>
                                    <td style='text-align:left;'>" .$txn_id." <br> " .$txn_id." 
                                    <br> " .$txn_id." <br>" .$txn_id." </td>
                                    <td style='text-align:left;'>" .$txn_id." <br> Pickuptime:" 
                                    .$txn_id." <br> Pickup Date:" .$txn_id." 
                                    <br> Dropoff: " .$txn_id."</td>
                                    </tr>   
                                    <tr>
                                    </tbody> 
                                    </table>                        
                                    <hr width='100%' size='1' color='black' style='margin-top:10px;'>                          
                                    <table cellspacing='0' width='100%' style='padding-left:300px;'>
                                    <thead>                                                                       
                                    <tr>                                        
                                    <th style='color:#0A903B;text-align:right;padding-bottom:5px;width:70%'>Base 
                                    Price:</th>
                                    <th style='color:black;text-align:left;padding-bottom:5px;padding-
                                    left:10px;width:30%'>" .$payment_gross."</th>
                                    </tr>
                                    <tr>                                        
                                    <th style='color:#0A903B;text-align:right;padding-bottom:5px;'>GST(5%):</th>
                                    <th style='color:black;text-align:left;padding-bottom:5px;padding-
                                    left:10px;'>" .$txn_id."</th>                                        
                                    </tr>
                                    <tr>                                        
                                    <th style='color:#0A903B;text-align:right;'>Total Price:</th>
                                    <th style='color:black;text-align:left;padding-bottom:5px;padding-
                                    left:10px;'>" .$payment_gross."</th>                                        
                                    </tr>
                                    </thead>   
                                    </table>             
                                    </div> 
                                    </div>              
                                    </body>
                                    </html>";

                        
                        
                        
                        // Send email receipt to customer
                        SendEmail($buyer_email, $buyer_name, $txn_id, $message);
                    } 

            ?>
                <div class="col-md-12">
                    <span class="ord-success-text" data-aos="fade-right" data-aos-duration="1500">Your order has been placed
                    successfully!</span>
                </div>

                <!-- Order status & shipping info -->
                <div class="row ord-addr-info ord-info">
                    <div class="col-lg-6">
                        <span><b>Transaction ID:</b></span>
                        <span><?php echo $txn_id; ?></span>
                    </div>
                    <div class="col-lg-6">
                        <span><b>Paid Amount:</b></span>
                        <span><?php echo $payment_gross; ?></span>
                    </div>
                    <div class="col-lg-6">
                        <span><b>Payment Status:</b></span>
                        <span><?php echo $payment_status; ?></span>
                    </div>
                    <div class="col-lg-6">
                        <span><b>Placed On:</b></span>
                        <span><?php echo $payment_date; ?></span>
                    </div>
                    <div class="col-lg-6">
                        <span><b>Buyer Name:</b></span>
                        <span><?php echo $buyer_name; ?></span>
                    </div>
                    <div class="col-lg-6">
                        <span><b>Email:</b></span>
                        <span><?php echo $buyer_email; ?></span>
                    </div>
                </div>
            
                <!-- Order items -->
                <div class="row col-lg-12">
                    <table class="table text-light">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Sub Total</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Get order items from the database 
                            $query ="SELECT i.*, p.name, p.price FROM order_items as i LEFT JOIN apps_list as p ON p.appid = i.product_id WHERE i.payment_id = '$payment_id'"; 
                            $result = $db_handle->runBaseQuery($query);
                            if(!empty($result)){  
                                //while($item = mysqli_fetch_assoc($result)){
                                foreach ($result as $item) {
                                    $price = $item["price"]; 
                                    $quantity = $item["quantity"]; 
                                    $sub_total = $price * $quantity;
                                    $remarks = $item['gift_id'];
                            ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>           <!-- List name from query -->
                                <td><?php echo '$'.$price; ?></td>              <!-- List name from price -->
                                <td><?php echo $quantity; ?></td>               <!-- List name from quantity -->
                                <td><?php echo '$'.$sub_total; ?></td>          <!-- List name from subtotal -->
                                <td><?php 
                                    //echo "<script>alert(" . $remarks . ");</script>";
                                    if($remarks != 0 && !is_null($remarks)){
//                                      //echo "<script>alert('You are authorized!');</script>";
                                        $query = "SELECT * FROM steam_clone_members where member_id =". $remarks;
                                        $result = $db_handle->runBaseQuery($query);
                                        if (!empty($result)){
                                            foreach ($result as $row) {
                                                $gift = $row["fname"] . " " . $row["lname"];
                                            }
                                        }
                                        echo "A Gift to ". $gift;
                                    }?>
                                </td>
                            </tr>
                                <?php
                                    } 
                                } else if($cart->total_items() > 0){                   // Grab all items again from user's cart to display
                                    foreach($cartItems as $item){
                                    ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>           <!-- List name from cart -->
                                <td><?php echo '$'.$item["price"]; ?></td>      <!-- List name from price -->
                                <td><?php echo $item["quantity"]; ?></td>       <!-- List name from quantity -->
                                <td><?php echo '$'.$item["subtotal"]; ?></td>   <!-- List name from subtotal -->
                                <td><?php 
                                    //echo "<script>alert(" . $remarks . ");</script>";
                                    if($item['gift_id'] != 0 && !is_null($item['gift_id'])){
//                                        //echo "<script>alert('You are authorized!');</script>";
                                        $query = "SELECT * FROM steam_clone_members where member_id =".$item['gift_id'];
                                        $result = $db_handle->runBaseQuery($query);
                                        if (!empty($result)){
                                            foreach ($result as $row) {
                                                $gift = $row["fname"] . " " . $row["lname"];
                                            }
                                        }
                                        echo "A Gift to ". $gift;
                                    }?>
                                </td>
                            </tr>
                            <?php
                                } }?>
                        </tbody>
                    </table>
                </div>
        </div>
        <form method="post" action="cartAction.php">
        <input type="hidden" name="action" value="placeOrder"/>
        <input type="hidden" name="orderid" value="<?php echo "$payment_id" ?>"/>
        
        <input type="email" class="form-control" name="email" placeholder="Email to send gift" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required>
        <input type="hidden" name="action" value="placeOrder"/>
        <input type="hidden" name="gift"/> 
        
        <input class="btn btn-light btn-lg btn-block checkout-main-btn" type="submit" name="checkoutSubmit" value="Back to Games">
        </form>
        <br>
        <?php } else {?>
            <div class="col-md-12">
                <div class="alert alert-danger">Your order submission failed.</div>
            </div>
        </div>
        <input class="btn btn-light btn-lg btn-block" type="submit" name="checkoutSubmit" value="Back to Gamelist" onclick="location.href='./gameslist.php'">
        <br>
        <?php } ?>
    </main>
    
    <!-- FOOTER -->
    <?php
        include "footer.inc.php";
    ?>
</body>
</html>