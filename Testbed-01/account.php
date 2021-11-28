<!DOCTYPE html>
<?php 
session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

$userId = $_SESSION['member_id'];
$total = 0;
/*
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>alert('Debug Objects: " . $output . "' );</script>";
}
debug_to_console($userId);
*/
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
        <main class="container text-light pt-4 account-main-container">
            <header>
                <h1 class="account-header">Your Account Details</h1>
            </header>

            
            <!-- Account statistics -->
            <div class="container account-container">
                <h2>User Details</h2>
                <hr>
                <div class="account-stats">
                    <?php
                    require_once "DBController.php";
                    $db_handle = new DBController();
                    
                    $query = "SELECT * FROM steam_clone_members WHERE member_id='" . $userId . "'";
                    $result = $db_handle->runBaseQuery($query);
                    if (!empty($result)){
                        foreach ($result as $row){
                        echo '<div><span>Last Name: </span><span class="account-lname">'. $row["lname"] . '</span></div>' .
                             '<div><span>First Name: </span><span class="account-fname">'. $row["fname"] . '</span></div>' .
                             '<div><span>Date of Birth: </span><span class="account-dob">'. $row["dob"] . '</span></div>' .
                             '<div><span>Email: </span><span class="account-email">'. $row["email"] . '</span></div>';
                        } 
                    }
                    ?>
                </div>
                
            </div>


            <!-- Update password -->
            <div class="container account-container account-update-pw">
                <h2>Update Password</h2>
                <hr>
                <form action="doAccount.php" method="post">
                    <div class="row register-row">
                        <div class="col-md-4">
                            <label for="old_pwd" class="form-label">Your current password</label>
                            <input type="password" class="form-control" aria-label="Old Password" id="old_pwd" name="old_pwd">
                        </div>
                        <div class="col-md-4">
                            <label for="new_pwd" class="form-label">Your new password</label>
                            <input type="password" class="form-control" aria-label="New Password" id="new_pwd" name="new_pwd">
                        </div>
                        <div class="col-md-4">
                            <label for="confirm_pwd" class="form-label">Confirm new password</label>
                            <input type="password" class="form-control" aria-label="Confirm New Password" id="confirm_pwd" name="cfm_pwd">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light account-btn">Change password</button>
                </form>
            </div>

            <!-- Account statistics -->
            <!--
            <div class="container account-container">
                <h2>Account Transactions</h2>
                <hr>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod ad placeat nesciunt esse voluptatum nemo
                    ut! Laboriosam fugiat molestias, impedit officiis quasi culpa quam consequatur optio veniam eius sed
                    nulla, magnam beatae itaque amet in nobis repellat reiciendis quibusdam aliquam vel quos quis? Quisquam
                    perferendis incidunt libero voluptatum id provident?
                </p>
            </div>
            -->
            
            <div class="row container account-container">
                <div class="col-md-8 cart-main">

                    <h2>Account Transactions</h2>
                    <hr>
                    
                    <?php 
                    require_once "DBController.php";
                    $db_handle = new DBController();
                   
                    $config = parse_ini_file('../../private/db-config.ini');
                    $db = new mysqli($config['servername'], $config['username'],
                            $config['password'], $config['dbname']);    
                    //$query = "SELECT DISTINCT r.*, o.gift_id FROM steam_clone_members as s INNER JOIN orders as r ON r.customer_id = s.member_id INNER JOIN order_items as o ON r.id = o.order_id WHERE s.member_id = " . $userId . " ORDER BY r.id DESC;";
                    $query = "SELECT r.* FROM steam_clone_members as s INNER JOIN orders as r ON r.customer_id = s.member_id WHERE s.member_id = " . $userId . " ORDER BY r.id DESC;";
                    $result = $db->query($query);
                    
                    if($result->num_rows > 0){ 
                        foreach ($result as $row) {
                            $total += $row["grand_total"]
                    ?>
                    <div class="cart-item row">
                        <div class="col-md-3 item-img">
                            <!--<img src="<?php //echo $item['image'] ?>" alt="item1">-->
                            <img src="./images/about_game.jpg" alt="item 1">
                        </div>
                        <div class="col-md-9 item-info">
                            <div class="row">
                                <span class="col item-name">
                                    <?php echo 'Order Number: '. $row["id"]; ?>
                                </span>
                                <span class="col item-price">
                                    <?php echo '$'.$row["grand_total"]; ?>
                                </span>
                            </div>
                            <div class="row">
                                <span class="col-8 item-qty">
                                    <?php echo 'Purchase Date: '.$row["created"]; ?>
                                </span>
                                <span class="col item-cancel">
                                    <button class="btn btn-sm btn-light" onclick="window.location.href='orderSuccess.php?id=<?php echo $row["id"]; ?>';">View Order</button>
                                </span>
                            </div>
                            <div class="row">
                                <span class="item-company">
                                    <?php echo 'Status: '.$row["status"]; ?>
                                </span>
                            </div>
                            <?php
                            $result = $db->query("SELECT o.gift_id FROM orders as r INNER JOIN order_items as o ON r.id = o.order_id WHERE r.customer_id = ".$row['customer_id'] . " ORDER BY o.gift_id DESC LIMIT 1"); 
                            if($result->num_rows > 0){  
                                foreach ($result as $item) {
                                    if($item["gift_id"] != 0 && !is_null($item["gift_id"])){
                                        echo "<div class='row'>";
                                        echo "<span class='item-company'>";
                                        echo "*Include gifts to others";
                                        echo "</span>";
                                        echo "</div>";
                                    }
                                }
                            }
                            ?>
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

                </div>

                <div class="col-md-4 cart-info">
                    <span class="cart-subtotal">Total Spent: <span class="cart-price">$<?php echo $total; ?></span></span>
                    <hr>
                    You are our most loyal customer!
                </div>
                
            </div>
            <div class="row container account-container">
                <div class="col-12 cart-main">
                    <h2>Received Game Gifts</h2>
                    <hr>
                    <?php 
                    $db_handle = new DBController();
                   
                    $config = parse_ini_file('../../private/db-config.ini');
                    $db = new mysqli($config['servername'], $config['username'],
                            $config['password'], $config['dbname']);    
                    //$query = "SELECT DISTINCT r.*, o.gift_id FROM steam_clone_members as s INNER JOIN orders as r ON r.customer_id = s.member_id INNER JOIN order_items as o ON r.id = o.order_id WHERE s.member_id = " . $userId . " ORDER BY r.id DESC;";
                    $query = "SELECT a.*, s.fname, s.lname, i.created FROM order_items as o INNER JOIN apps_list as a ON o.product_id = a.appid INNER JOIN orders as i ON o.order_id = i.id INNER JOIN steam_clone_members as s ON i.customer_id = s.member_id where o.gift_id = " . $userId . " ORDER BY i.created DESC;";
                    $result = $db->query($query);
                    
                    if($result->num_rows > 0){ 
                        foreach ($result as $row) {
                    ?>
                    <div class="cart-item row">
                        <div class="col-3 item-img">
                            <img src="<?php echo $row['image'] ?>" alt="item1">
                        </div>
                        <div class="col-9 item-info">
                            <div class="row">
                                <span class="col item-name">
                                    <?php echo 'Game: '. $row["name"]; ?>
                                </span>
                                <span class="col item-price">
                                    <?php echo $row["fname"] . " " . $row["lname"]; ?>
                                </span>
                            </div>
                            <div class="row">
                                <span class="col-8 item-qty">
                                    <?php echo 'Received on: '.$row["created"]; ?>
                                </span>
                                <span class="col item-cancel">
                                    <button class="btn btn-sm btn-success" onclick="window.location.href='#">Accept</button>
                                </span>
                            </div>
                            <div class="row">
                                <span class="item-company">
                                    <?php echo 'Status: '.$row["status"]; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php } }
                    else{ 
                        
                    ?>
                        <tr><td colspan="5"><p>No Gifts.....</p></td>
                    <?php } ?>
                </div>
            </div>
        </main>
        
        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
