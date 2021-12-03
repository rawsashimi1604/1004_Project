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
        ?>
        <!-- MAIN -->
        <main class="container cart-container text-light">
            <header>
                <h1>Your shopping cart</h1>
            </header>
            <div class="container">
                <div class="row cart-row">
                    <div class="col-8 cart-main">
                        <h2>Items: 2</h2>
                        <hr>
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
                    </div>

                    <div class="col-4 cart-info">
                        <span class="cart-subtotal">Subtotal: <span class="cart-price">$20.00</span></span>
                        <span class="cart-taxfees">Estimated Tax and Fees: <span class="cart-tax">$3.98</span></span>
                        <hr>
                        <form action="">
                            <div class="form-check register-check">
                                <input type="checkbox" class="form-check-input" id="gift">
                                <label class="form-check-label" for="gift">This order contains a gift</label>
                            </div>
                            <button type="submit" class="btn btn-light register-btn">Proceed to checkout</button>
                        </form>
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