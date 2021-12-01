<?php 

session_start();

require_once "authCookieSessionValidate.php";
$userId = $_SESSION['member_id'];

// Include the database config file 
require_once 'DBController.php'; 

// Include PayPal configuration file 
include_once 'paypal_config.php'; 

// Initialize shopping cart class 
include_once 'Cart.inc.php'; 
$cart = new Cart; 
 
// If the cart is empty, redirect to the products page 
if($cart->total_items() <= 0){ 
    header("Location: index.php"); 
}

if(!$isLoggedIn) {
    //echo "<script type='text/javascript'>alert('Please login before purchasing!');</script>";
    header("Location: ./index.php");
}
 
// Get posted data from session 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 
 
// Get status message from session 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
?>

<script type="text/javascript">
    function changeText(event){
        var a = event.target;
        console.log(a);
        if (a.value === "For Me!"){
            a.value = "Gift!";
        }
        else
            a.value = "For Me!";
    }
</script>

<html lang="EN">
    <title>GamesDex: Checkout for your games</title>
    <meta name="Shopping Cart checkout" content="width=device-width, initial-scale=1.0">
    <?php include "head.inc.php" ?>
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <!-- MAIN -->
        <main class="container checkout-container text-light">
            <div class="container h-100">
                <div class="row h-100">
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

                    <div class="col-md-5 order-md-2 checkout-right">
                        <span class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="">Order Summary</h2>
                            <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                        </span>
                        <ul class="list-group mb-3">
                            <?php 
                                if($cart->total_items() > 0){ 
                                    //get cart items from session 
                                    $cartItems = $cart->contents(); 
                                    foreach($cartItems as $item){ 
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                                    <small class="text-muted"><?php echo '$'.$item["price"]; ?>(<?php echo $item["qty"]; ?>)</small>
                                </div>
                                <span class="text-muted"><?php echo '$'.$item["subtotal"]; ?></span>
                            </li>
                            <?php } } ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong><?php echo '$'.$cart->total(); ?></strong>
                            </li>
                        </ul>
                        
                        <div class="checkout-promo">
                        <h3>Got a promotional code?</h3>
                            <div>
                                <input type="text" class="form-control" placeholder="Enter your code here">
                                <button class="btn btn-block btn-light ">Apply</button>
                            </div>
                        </div>
                        <a href="index.php" class="btn btn-block btn-light checkout-btn">Back to Shopping</a>
                    </div>

                    <?php
                        if (isset($_POST['gift']) || $statusMsg) { // <-- IF THE GIFT OPTION SELECTED
                    ?>
                    <div class="col-md-7 order-md-1 checkout-left">
                        <h1>Checkout</h1>
                        <span class="mb-3">Select the games to gift!</span>
                        <form method="post" action="cartAction.php">
                            <?php 
                                if($cart->total_items() > 0){ 
                                    // Get cart items from session 
                                    $cartItems = $cart->contents(); 
                                    foreach($cartItems as $item){
                            ?>
                            <div class="cart-item row">
                                <div class="col-3 item-img mobile-none">
                                    <img src="<?php echo $item['image']; ?>" alt="item1">
                                </div>
                                <div class="col-md-9 item-info">
                                    <div class="row">
                                        <span class="col item-name">
                                            <?php echo $item["name"]; ?>
                                        </span>
                                        <span class="col item-price">
                                            <?php echo '$'.$item["price"]; ?>
                                        </span>
                                        <span>
                                            <input type="hidden" name="item_number" value="<?php echo $row['id']; ?>">
                                        </span>
                                    </div>
                                    <div class="row">
                                        <span class="col item-qty">Qty: 1</span>
                                        <span class="col item-cancel">
                                            <input class="btn btn-info btn-lg btn-block checkout-gift-btn" id="isgift" type="isgift" name="isgift[]" value="For Me!" onclick="changeText(event);" readonly="readonly">
                                            
                                        </span>
                                    </div>
                                    <div class="row">
                                        <span class="item-company">Published by Riot Games</span>
                                    </div>
                                </div>
                            </div>
                            <?php } }
                                else{ 
                            ?>
                            <tr><td colspan="5"><p>Your cart is empty.....</p></td>
                            <?php } ?>
                                <hr>
                            <div class="checkout-gift-container">
                                <h4>Contact Details</h4>
                                <div class="mb-1">
                                <label for="email">Email:</label>
                                <input type="email" id="inputemail" onkeyup="inputvalue()" class="form-control" name="email" placeholder="Email to send gift" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required>
                            </div>
                            </div>
                            <input type="hidden" name="action" value="placeOrder"/>
                            <input type="hidden" name="gift"/>                      
                            <input class="btn btn-success btn-lg btn-block checkout-main-btn" type="submit" name="checkoutSubmit" value="Place Order">
                            
                        </form>
                    </div>
                    <?php } else {
                        $db_handle = new DBController();
                        $query = "SELECT * FROM steam_clone_members where member_id =". $userId;
                        $result = $db_handle->runBaseQuery($query);
                        
                        if (!empty($result)){
                            foreach ($result as $row) {
                                $fname = $row["fname"];
                    ?>
                    <div class="col-md-7 order-md-1 checkout-left">
                        <h1>Checkout</h1>
                        <span class="mb-3">Please check your particulars. If needed, please change in <a href='./account.php'>Account</a></span>
                        <hr>
                        <form class="" id="payment_gateway" action="<?php echo PAYPAL_URL; ?>" method="post">
                            <div class="col">
                                <label for="first_name">First Name</label>
                                <span><?php echo $row['fname'] ?></span>
                            </div>
                            <div class="col">
                                <label for="last_name">Last Name</label>
                                <span><?php echo $row['lname'] ?></span>
                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <span><?php echo $row['email'] ?></span>
                            </div>
                            <hr>
                            <?php } } ?>
                            <!-- Specify a Buy Now button. -->
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
                            <input type="hidden" name="item_name" value="<?php if($cart->total_items() > 1){echo "Game Bundle";}else{echo $item["name"];} ?>">
                            <input type="hidden" name="item_number" value="<?php if($cart->total_items() > 1){echo "1";}else{echo $item["id"];} ?>">
                            <input type="hidden" name="amount" value="<?php echo $cart->total(); ?>">
                            <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">

                            <!-- Specify URLs -->
                            <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
                            <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
                            <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">

                            <!--<input class="btn btn-success btn-lg btn-block checkout-main-btn" type="submit" name="submit" value="Place Order">-->
                            <button type="submit" name="submit" value="Place Order" alt="Check out with PayPal" class="btn btn-success btn-lg btn-block checkout-main-btn"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Check out with PayPal"></button>
                            </form>
                            <?php } ?>
                    </div> 
                </div>
            </div>
        </main>
        <script>
            function inputvalue(){
                /* Get input value on change */
                var inputVal = document.getElementById("inputemail").value;
            }
        </script>
        <!-- FOOTER -->
        <?php
            include "footer.inc.php";
        ?>
    </body>
    
    
</html>