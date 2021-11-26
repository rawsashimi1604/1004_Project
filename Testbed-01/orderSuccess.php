<?php 
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
*/
if(!isset($_REQUEST['id'])){ 
    header("Location: index.php"); 
} 

session_start();
require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

 
// Include the database config file 
require_once 'DBController.php'; 

$config = parse_ini_file('../../private/db-config.ini');
$db = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);

$userId = $_SESSION['member_id'];

// Fetch order details from database 
$result = $db->query("SELECT r.*, c.fname, c.lname, c.email FROM orders as r LEFT JOIN steam_clone_members as c ON c.member_id = r.customer_id WHERE r.id = ".$_REQUEST['id']); 
 
if($result->num_rows > 0){ 
    $orderInfo = $result->fetch_assoc(); 
    if ($userId != $orderInfo['customer_id']){
        echo "<script>alert('You are not authorized!');</script>";
        header("Location: index.php"); 
    }
}else{ 
    header("Location: index.php"); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<?php include "head.inc.php" ?> 
<body class="bg-dark">
    <?php include "nav.inc.php" ?>
    <header class="container jumbotron text-center mb-0 home-container">
        <h1>ORDER STATUS</h1>
        <div class="col-12">
            <?php if(!empty($orderInfo)){ ?>
                <div class="col-md-12">
                    <div class="alert alert-success">Your order has been placed successfully.</div>
                </div>

                <!-- Order status & shipping info -->
                <div class="row col-lg-12 ord-addr-info">
                    <div class="hdr">Order Info</div>
                    <p><b>Reference ID:</b> #<?php echo $orderInfo['id']; ?></p>
                    <p><b>Total:</b> <?php echo '$'.$orderInfo['grand_total']; ?></p>
                    <p><b>Placed On:</b> <?php echo $orderInfo['created']; ?></p>
                    <p><b>Buyer Name:</b> <?php echo $orderInfo['fname'].' '.$orderInfo['lname']; ?></p>
                    <p><b>Email:</b> <?php echo $orderInfo['email']; ?></p>
                </div>

                <!-- Order items -->
                <div class="row col-lg-12">
                    <table class="table table-hover">
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
                            $result = $db->query("SELECT i.*, p.name, p.price FROM order_items as i LEFT JOIN apps_list as p ON p.appid = i.product_id WHERE i.order_id = ".$orderInfo['id']); 
                           
                            if($result->num_rows > 0){  
                                //while($item = mysqli_fetch_assoc($result)){
                                foreach ($result as $item) {
                                    $price = $item["price"]; 
                                    $quantity = $item["quantity"]; 
                                    $sub_total = $price * $quantity;
                                    $remarks = $item['gift_id'];
                            ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>
                                <td><?php echo '$'.$price; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo '$'.$sub_total; ?></td>
                                <td><?php 
                                    //echo "<script>alert(" . $remarks . ");</script>";
                                    if($remarks != 0 && !is_null($remarks)){
                                        //echo "<script>alert('You are authorized!');</script>";
                                        $db_handle = new DBController();
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
                            <?php } 
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else{ ?>
            <div class="col-md-12">
                <div class="alert alert-danger">Your order submission failed.</div>
            </div>
            <?php } ?>
        </div>
        <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Back to Gamelist" onclick="location.href='./gameslist.php'">
    </header>
<?php include "footer.inc.php"; ?>
</body>
</html>