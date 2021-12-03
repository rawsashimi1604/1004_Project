<!DOCTYPE html>
<?php 
/*
 * 
*/


session_start();
require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

// Include PayPal configuration file 
include_once 'paypal_config.php';  

// Include the database config file 
require_once 'DBController.php'; 

// Initialize shopping cart class 
include_once 'Cart.inc.php'; 
$cart = new Cart; 

// Include PHPMailer function file
include_once 'email.php';

// Ensure only logged in users can access this page
$userId = $_SESSION['member_id'];
if (empty($userId)){
    echo "<script>alert('You are not authorized!');</script>";
    header("Location: index.php");
} else {
    $query = "SELECT * FROM steam_clone_members WHERE member_id = '$userId'";
    $result = $db_handle->runBaseQuery($query);
    foreach ($result as $row) {
        $user_email = $row['email'];
    }
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
    
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION["temp_link"] = $actual_link;
    
    
    // Transaction History redirect from Accounts Page clause
    $payment_id = $_GET['id'];
    if(!empty($payment_id)){
        $query = "SELECT * FROM user_payments WHERE payment_id = '$payment_id'";
        $payment_history = $db_handle->runBaseQuery($query);
        foreach ($payment_history as $row) {
            $txn_id  = $row['txn_id'];
        }
    }

    

} else {
    header("Location: ./index.php");
}


$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
}
// Get posted data from session 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 



?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    function changeText(event){
        var a = event.target;
        console.log(a);
        if (a.value === "Gift!"){
            a.value = "For Me!";
        }
        else
            a.value = "Gift!";
    }
	
	function showHint(str) {
        if (str.length == 0) {
          document.getElementById("txtHint").innerHTML = "";
          return;
        } else {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("txtHint").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET", "getemail.php?q=" + str, true);
          xmlhttp.send();
        }
    }
</script>



<html lang="en">
<head>
    <?php
        include "head.inc.php";
    ?>
    <title>GamesDex: Order Success!</title>
    <meta name="Order Details" http-equiv="X-UA-Compatible" content="IE=edge">
</head>


<body class="bg-dark">
    <main class="container jumbotron text-center mb-0 ord-container">
        <h1>Your Order Details</h1>
        <form method="post" action="cartAction.php">
        <div class="col-12">
            <?php if(!empty($statusMsg) && ($statusMsgType == 'success')) {?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                </div>
            <?php } ?>
            <?php if (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                </div>
            <?php } ?>
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
                    } else { 
                        // Insert tansaction data into the database 
                        $query = "INSERT INTO user_payments(item_number,txn_id,payment_gross,currency_code,payment_status, payment_date, buyer_name , buyer_email, customer_id)"
                                . "VALUES('".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."','".$payment_date."','".$buyer_name."','".$buyer_email."','".$userId."')";
                        $insert = $db_handle->runBaseQuery($query);
                        
                        $query = "SELECT * FROM user_payments WHERE txn_id = '$txn_id'";
                        $result = $db_handle->runBaseQuery($query);
                        foreach ($result as $row) {
                            $payment_id = $row['payment_id'];
                        }
                        

                        
                        //get cart items from session 
                        $cartItems = $cart->contents(); 
                        $GameItems = "";
                        
                        //Based on number of items bought, populate the table list for email
                        foreach($cartItems as $item){
                            $gamekey = generateGameKey();
                            $GameItems .= "<tr>";
                            $GameItems .= "<td style='color:#198754;text-align:left;padding-bottom:5px;text-align:center;'>1</td>";
                            $GameItems .= "<td style='text-align:left;color:#f8f9fa'>".$item["name"]."</td>";
                            $GameItems .= "<td style='text-align:left;color:#f8f9fa'>".$gamekey."</td>";
                            $GameItems .= "</tr>";
                        }
                        
                        //HTML email format for confirmation email
                        $message = "<html>
                                        <head>
                                            <title>Purchase</title>
                                        </head>
                                    <body>                
                                        <div style='width:800px;background:#212529;border-style:groove;'>
                                            <hr width='100%' size='2' color='#A4168E'>
                                            <h2 style='width:50%;height:40px; text-align:right;margin:0px;padding-
                                            left:390px;color:#f8f9fa;'>Purchase Confirmation</h2>
                                            <div style='width:50%;text-align:right;margin:0px;padding-
                                            left:390px;color:#ea6512'> Transaction ID:". $txn_id." </div>
                                            <h4 style='color:#ea6512;margin-top:-20px;'> Hello, ".$buyer_name."
                                            </h4>
                                            <p>Thank You for the purchase! Please find the transaction details along with the invoice. </p>
                                            <hr/>
                                            <div style='height:210px;background:#212529'>
                                                <table cellspacing='0' width='100%' style='background:#212529'>
                                                    <thead>
                                                        <col width='80px' />
                                                        <col width='40px' />
                                                        <col width='40px' />
                                                        <tr>          
                                                        <th style='color:#ea6512;text-align:center;'>Quantity: </th>                           
                                                        <th style='color:#ea6512;text-align:left;'>Game Title: </th>
                                                        <th style='color:#ea6512;text-align:left;'>Key: </th>                                                                            
                                                        </tr>
                                                        </thead>
                                                            <tbody>".$GameItems." 
                                                                <tr>
                                                            </tbody> 
                                                        </table>                        
                                                        <hr width='100%' size='1' color='#A4168E' style='margin-top:10px;'>                          
                                                        <table cellspacing='0' width='100%' style='padding-left:300px;background:#212529'>
                                                        <thead>                                                                       
                                                        <tr style='background:#212529'>                                        
                                                        <th style='color:#ea6512;text-align:right;'>Total Paid:</th>
                                                        <th style='color:#f8f9fa;text-align:left;padding-bottom:5px;padding-
                                                        left:10px;'>$".$payment_gross."</th>                                        
                                                        </tr>
                                                    </thead>   
                                                </table>             
                                            </div> 
                                        </div>              
                                    </body>
                                    </html>";

                        
                        $subject = "GamesDex: Invoice for Transaction No: ".$txn_id."";
                        
                        // Send email receipt to customer $user_email
                        SendEmail($user_email, $buyer_name, $message, $subject);
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
                            <?php if (isset($_SESSION['isgift'])){
                                    ?>
                            <label class="form-check-label" for="gift">This order contains a gift</label>
                            <?php } ?>
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
                                <td><?php echo $item["name"]; ?></td>           <!-- List name from cart -->
                                <td><?php echo '$'.$price; ?></td>              <!-- List name from price -->
                                <td>1</td>                                      <!-- List name from quantity -->
                                <td><?php echo '$'.$sub_total; ?></td>          <!-- List name from subtotal -->
                                <td><?php 
                                    if($remarks != 0 && !is_null($remarks)){
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
                                    //get cart items from session 
                                    $cartItems = $cart->contents(); 
                                    foreach($cartItems as $item){
                                    ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>           <!-- List name from cart -->
                                <td><?php echo '$'.$item["price"]; ?></td>      <!-- List name from price -->
                                <td>1</td>                                      <!-- List name from quantity -->
                                <td><?php echo '$'.$item["subtotal"]; ?></td>   <!-- List name from subtotal -->
                                <?php if (isset($_SESSION['isgift'])){
                                    ?>
                                <!--<label class="form-check-label" for="gift">This order contains a gift</label>-->
                                <td><input class="btn btn-info btn-lg btn-block checkout-gift-btn" id="isgift" type="isgift" name="isgift[]" value="Gift!" onclick="changeText(event);" readonly="readonly"></td>
                                <?php
                                } else {
                                ?>
                                <td><?php 
                                    if($remarks != 0 && !is_null($remarks)){
                                        $query = "SELECT * FROM steam_clone_members where member_id =". $remarks;
                                        $result = $db_handle->runBaseQuery($query);
                                        if (!empty($result)){
                                            foreach ($result as $row) {
                                                $gift = $row["fname"] . " " . $row["lname"];
                                            }
                                        }
                                        echo "A Gift to ". $gift;
                                    } else{
                                        echo "Game has just been ordered";    
                                    }
                                }?>
                                </td>
                            </tr>                            
                            <?php
                                } 
                            }?>
                            
                        </tbody>
                    </table>   
                </div>
                <?php if (isset($_SESSION['isgift'])){ ?>
                    <!--<form method="post" action="<?php echo $_SESSION['temp_link']?>">-->
                    <div class="checkout-gift-container">
                        <h4>Recipient Details</h4>
                        <div class="mb-1">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Email to send gift" onkeyup="showHint(this.value)" required>
                        <p><span id="txtHint"></span></p>
                    </div>
                <?php } ?>
        </div>
        <input type="hidden" name="action" value="placeOrder"/>
        <input type="hidden" name="orderid" value="<?php echo "$payment_id" ?>"/>
        <?php if (isset($_SESSION['isgift'])){ ?>
        <input class="btn btn-success btn-lg btn-block checkout-main-btn" type="submit" name="checkoutSubmit" value="Send Gift!"></input>
        <?php } else {?>
        <input class="btn btn-success btn-lg btn-block checkout-main-btn" type="submit" name="checkoutSubmit" value="Back to games"></input>
        <?php } ?>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>