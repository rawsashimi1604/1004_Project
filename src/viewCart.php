<!DOCTYPE html>
<?php 
// Initialize shopping cart class 
include_once 'Cart.inc.php'; 
$cart = new Cart; 
?>

<html lang="EN">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>GamesDex: Cart</title>
    </head>
    
    <!-- BODY -->
    <body class="bg-dark">
        
        <?php
            include "nav.inc.php";
            $userId = $_SESSION['member_id'];
            if (empty($userId)){
                echo '<div style="position: absolute; left: 50%;" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Please sign in before proceeding to checkout.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        ?>
        <!-- MAIN -->
        <main class="container cart-container text-light">
            <header>
                <h1>Your shopping cart</h1>
            </header>
            <div class="container">
                <div class="row cart-row">
                    <div class="col-md-8 cart-main">
                        
                        <hr>
                        <h2>Items: <?php echo $cart->total_items(); ?></h2>
                        <hr>
                        
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
                                </div>
                                <div class="row">
                                    <span class="col item-qty">Qty: 1</span>
                                    <span class="col item-cancel">
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')?window.location.href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;"><img alt="Remove from Cart" src="images/remove.png"></i> </button>
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="item-company">Published by <?php echo $item["publisher"]; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php } }
                            else{    
                        ?>
                            <p>Your cart is empty.....</p>
                        <?php } ?>
                        <?php if($cart->total_items() > 0){ ?>
                        <tr>
                        <?php echo '$'.$cart->total(); ?>
                        </tr>
                        <?php } ?>
                        
                    </div>

                    <div class="col-md-4 cart-info">
                        <span class="cart-subtotal">Subtotal: <span class="cart-price"><?php echo '$'.$cart->total(); ?></span></span>
                        <hr>
                        <form action="checkout.php" method="post">
                            <div class="form-check cart-check">
                                <input type="checkbox" class="form-check-input" id="gift" name="gift">
                                <label class="form-check-label" for="gift">This order contains a gift</label>
                            </div>
                            <button type="submit" class="btn btn-light cart-checkout-btn">Proceed to checkout</button>
                        </form>
                    </div>
                </div>
                <button onclick="location.href='./gameslist.php'" type="submit" class="btn btn-light cart-btn">Continue Shopping</button>
            </div>
            
            <br>
        </main>

        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>