<?php 
// Initialize shopping cart class 
include_once 'Cart.inc.php'; 
$cart = new Cart; 
?>

<html lang="EN">
    <?php
        include "head.inc.php";
    ?>
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
                <div class="row cart-row">
                    <div class="col-8 cart-main">
                        
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
                                <!--<img src="./images/about_game.jpg" alt="item 1">-->
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
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')?window.location.href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;"><img src="images/remove.png"></i> </button>
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
                        <?php if($cart->total_items() > 0){ ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <!--<td><strong>Cart Total</strong></td>-->
                            <!--<td class="text-right"><strong><?php echo '$'.$cart->total(); ?></strong></td>-->
                            <td></td>
                        </tr>
                        <?php } ?>
                        
                        
                        
                        <!--
                        <div class="cart-item row">
                            <div class="col-3 item-img">
                                <img src="./images/about_game.jpg" alt="item 1">
                            </div>
                            <div class="col-9 item-info">
                                <div class="row">
                                    <span class="col item-name">
                                        My Item Name
                                    </span>
                                    <span class="col item-price">
                                        $10.00
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col item-qty">Qty: 1</span>
                                </div>
                                <div class="row">
                                    <span class="item-company">Published by Riot Games</span>
                                </div>
                            </div>
                        </div>
                        <div class="cart-item row">
                            <div class="col-3 item-img">
                                <img src="./images/about_game.jpg" alt="item 1">
                            </div>
                            <div class="col-9 item-info">
                                <div class="row">
                                    <span class="col item-name">
                                        My Item Name
                                    </span>
                                    <span class="col item-price">
                                        $10.00
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col item-qty">Qty: 1</span>
                                </div>
                                <div class="row">
                                    <span class="item-company">Published by Riot Games</span>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>

                    <div class="col-4 cart-info">
                        <span class="cart-subtotal">Subtotal: <span class="cart-price"><?php echo '$'.$cart->total(); ?></span></span>
                        <span class="cart-taxfees">Estimated Tax and Fees: <span class="cart-tax">$3.98</span></span>
                        <hr>
                        <form action="checkout.php" method="post">
                            <div class="form-check register-check">
                                <input type="checkbox" class="form-check-input" id="gift" name="gift">
                                <label class="form-check-label" for="gift">This order contains a gift</label>
                            </div>
                            <button type="submit" class="btn btn-light register-btn">Proceed to checkout</button>
                        </form>
                    </div>
                </div>
            </div>
            <button onclick="location.href='./gameslist.php'" type="submit" class="btn btn-light register-btn">Continue Shopping</button>
            <br>
        </main>

        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>