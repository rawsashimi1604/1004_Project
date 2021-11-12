<?php
/*
 * Helper function to authenticate the login.
 */
$fname = $lname = $password = $dob = $email = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required! <br>";
        $success = false;
    } else {
        $email = sanitize_input($_POST["email"]);

        //Validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format! <br>";
            $success = false;
        }
    }

    //password
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password is required! <br>";
        $success = false;
    }

    if ($success) {
        authenticateUser();
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticateUser() {
    global $email, $pwd_hashed, $errorMsg, $success;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM steam_clone_members WHERE email=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Note that email field is always unique, so should only have
            // one row in the result.
            $row = $result->fetch_assoc();
            $fname = $row["fname"];
            $lname = $row["lname"];
            echo "<br>" . $fname . "<br>";
            echo $lname;
            $pwd_hashed = $row["password"];
            // Check if the password matches:
            if (!password_verify($_POST["pwd"], $pwd_hashed)) {
                // Don't be too specific with the error message - hackers don't
                // need to know which one they got right or wrong. :)
                $errorMsg = "Email not found or password doesn't match...";
                $success = false;
            }
        } else {
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
        }
        
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <?php include "head.inc.php" ?>
        <title>World of Pets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <?php
        ?>
        <main class="container">
            <?php
            if ($success) {
                echo "<h1>Login successful!</h1>";
                echo "<h2>Welcome back, " . $fname . " " . $lname . ".</h2>";
                ?><a href="index.php" class="btn btn-success" role="button">Return to Home</a> <?php
            } else {
                echo "<h1>Oops!</h1>";
                echo "<h2>The following errors were detected:</h2>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<p>You can login again at the link below</p>";
                ?>
                <a href="index.php" data-bs-target="#loginModal" class="btn btn-danger" role="button">Return to Login</a>
                    <?php
            }
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>