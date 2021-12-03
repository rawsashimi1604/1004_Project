<!DOCTYPE html>
<?php 
session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

$userId = $_SESSION['member_id'];
$total = 0;
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>GamesDex: Account</title>
    </head>
    
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
                    <form action="doUpdate.php" method="post">
                        <?php
                        require_once "DBController.php";
                        $db_handle = new DBController();
                        
                        $query = "SELECT * FROM steam_clone_members WHERE member_id='" . $userId . "'";
                        $result = $db_handle->runBaseQuery($query);
                        if (!empty($result)){
                            foreach ($result as $row){
                            echo    '<div class="row">
                                        <label for="lname" class="col-sm-2 col-form-label">Last Name:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="lname" name="lname" aria-label="Last Name Input Field" value="'. $row["lname"] . '">
                                        </div>
                                    </div>' .
                                    '<div class="row">
                                        <label for="fname" class="col-sm-2 col-form-label">First Name:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="fname" name="fname" aria-label="First Name Input Field" value="'. $row["fname"] . '">
                                        </div>
                                    </div>' .
                                    '<div class="row">
                                        <label for="dob" class="col-sm-2 col-form-label">Date of Birth:</label>
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="dob" name="dob" aria-label="DOB Input Field" value="'. $row["dob"] . '">
                                        </div>
                                    </div>' .
                                    '<div class="row">
                                        <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                        <div class="col-sm-5">
                                            <input type="email" class="form-control" id="email" name="email" aria-label="Email Input Field" value="'. $row["email"] . '">
                                        </div>
                                    </div>' ;
                            } 
                        }
                        ?>
                        <button type="submit" class="btn btn-light col-sm-1 updateButton">Update</button>
                    </form>
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
                    
                    $query = "SELECT r.* FROM steam_clone_members as s INNER JOIN user_payments as r ON r.customer_id = s.member_id WHERE s.member_id = " . $userId . " ORDER BY r.payment_id DESC;";
                    $result = $db->query($query);
                    
                    if($result->num_rows > 0){ 
                        foreach ($result as $row) {
                            $total += $row["payment_gross"]
                    ?>
                    <div class="cart-item row">
                        <div class="col-md-3 item-img">
                            <img src="./images/about_game.jpg" alt="item 1">
                        </div>
                        <div class="col-md-9 item-info">
                            <div class="row">
                                <span class="col item-name">
                                    <?php echo 'Transaction Number: '. $row["txn_id"]; ?>
                                </span>
                                <span class="col item-price">
                                    <?php echo '$'.$row["payment_gross"]; ?>
                                </span>
                            </div>
                            <div class="row">
                                <span class="col-8 item-qty">
                                    <?php echo 'Purchase Date: '.$row["payment_date"]; ?>
                                </span>
                                <span class="col item-cancel">
                                    <button class="btn btn-sm btn-light" onclick="window.location.href='orderSuccess.php?id=<?php echo $row["payment_id"]; ?>';">View Order</button>
                                </span>
                            </div>
                            <div class="row">
                                <span class="item-company">
                                    <?php echo 'Status: '.$row["payment_status"]; ?>
                                </span>
                            </div>
                            <?php
                            $result = $db->query("SELECT o.gift_id FROM user_payments as r INNER JOIN order_items as o ON r.id = o.payment_id WHERE r.customer_id = ".$row['customer_id'] . " ORDER BY o.gift_id DESC LIMIT 1"); 
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
                    else{ ?>
                        <tr><td colspan="5"><p>Your cart is empty.....</p></td>
                    <?php } ?>
                    <?php if($cart->total_items() > 0){ ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <?php echo '$'.$cart->total(); ?>
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
                    
                    $query = "SELECT a.*, s.fname, s.lname, i.payment_date FROM order_items as o INNER JOIN apps_list as a ON o.product_id = a.appid INNER JOIN user_payments as i ON o.payment_id = i.payment_id INNER JOIN steam_clone_members as s ON i.customer_id = s.member_id where o.gift_id = " . $userId . " ORDER BY i.payment_date DESC;";
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
                                    <?php echo "$".$row["price"]; ?>
                                </span>
                            </div>
                            <div class="row">
                                <span class="col-8 item-qty">
                                    <?php echo 'Received on: '.$row["payment_date"]; ?>
                                </span>
                            </div>
                            <div class="row">
                                <span class="item-company">
                                    <?php echo 'Status: Success'; ?>
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
