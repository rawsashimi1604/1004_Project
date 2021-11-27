<?php 

//include "head.inc.php";

session_start();

require_once "authCookieSessionValidate.php";
$userId = $_SESSION['member_id'];

// Include the database config file 
require_once 'DBController.php'; 

// Include Paypal configuration file 
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
            a.value = "As a Gift!";
        }
        else
            a.value = "For Me!";
    }
</script>

<html lang="EN">
    <?php include "head.inc.php" ?>
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <!-- MAIN -->
        <main class="container cart-container text-light">
            <header>
                <h1>Your shopping cart</h1>
            </header>
            <div class="container">
                <h1>CHECKOUT</h1>
                <br>
                <div class="col-12">
                    <div class="checkout">
                        <div class="row">
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

                            <div class="col-md-4 order-md-2 mb-4">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Your Cart</span>
                                    <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                                </h4>
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
                                <a href="index.php" class="btn btn-block btn-info">Add Items</a>
                            </div>

                            <?php
                            if (isset($_POST['gift']) || $statusMsg) { // <-- IF THE GIFT OPTION SELECTED
                                ?>
                            <div class="col-md-8 order-md-1">
                                
                                <h4 class="mb-3">Select the games to gift!</h4>
                                <form method="post" action="cartAction.php">

                                    <?php 
                                if($cart->total_items() > 0){ 
                                    // Get cart items from session 
                                    $cartItems = $cart->contents(); 
                                    foreach($cartItems as $item){
                                ?>
                                <div class="cart-item row">
                                    <div class="col-3 item-img">
                                        <img src="<?php echo $item['image'] ?>" alt="item1">
                                    </div>
                                    <div class="col-9 item-info">
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
                                                <input class="btn btn-info btn-lg btn-block" style="width:50%;" id="isgift" type="isgift" name="isgift[]" value="For Me!" onclick="changeText(event);" readonly="readonly">
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
                                    
                                    <h4 class="mb-3">Contact Details</h4>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required>
                                    </div>
                                    <input type="hidden" name="action" value="placeOrder"/>
                                    <input type="hidden" name="gift"/>
                                    <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Place Order">
                                    <input type="hidden" name="action" value="placeOrder"/>
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
                            <div class="col-md-8 order-md-1">
                                <h4 class="mb-3">Please check your particulars. If needed, please change in <a href='./account.php'>Account</a></h4>
                                <!-- <form method="post" action="cartAction.php"> -->
                                <form action="<?php echo PAYPAL_URL; ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name">First Name</label>
                                            <h4><?php echo $row['fname'] ?></h4>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last_name">Last Name</label>
                                            <h4><?php echo $row['lname'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <h4><?php echo $row['email'] ?></h4>
                                    </div>
                                    
                                    <!-- Specify a Buy Now button. -->
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
                                    <input type="hidden" name="item_name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="item_number" value="<?php echo $row['appid']; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $row['price']; ?>">
                                    <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
                                    
                                    <!-- Specify URLs -->
                                    <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
                                    <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
                                    <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">
                                    
                                    <input type="hidden" name="action" value="placeOrder"/>
                                    <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Place Order">
                                </form>
                            </div> 
                            <?php } } 
                                } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>