<!DOCTYPE html>
<html>
    <head>
    <?php
    include "head.inc.php"
    ?>
    </head>
    
    <body class="bg-dark">
        <?php
        include "nav.inc.php";
        ?>
        <?php
        $fname = $lname = $password = $dob = $email = $errorMsg = "";
        $success = true;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            if (empty($_POST["email"])) {
                $errorMsg .= "Email is required! <br>";
                $success = false;
            }
            else
            {
                $email = sanitize_input($_POST["email"]);
                //Validation
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMsg .= "Invalid email format! <br>";
                    $success = false;   
                }
            }
        }
        if (empty($_POST["pwd"])) 
        {
            $errorMsg .= "Password is required! <br>";
            $success = false;
        }
        if ($success) 
        {
            authenticateUser();
            if ($success){
                ?>
        <br>
        <main class='container text-light'>
            <h1>Login successful!</h1>
            <h2>Welcome back, <?php echo $fname . " " . $lname?></h2>
            <a href="index.php" class="btn btn-success" role="button">Return to Home</a> 
        </main>
            <?php
            }
            else
            {
                ?>
        <br>
        <main class='container text-light'>
            <h1>Oops!</h1>;
            <h2>The following errors were detected:</h2>;
                <?php echo "<p>" . $errorMsg . "</p>"; ?>
            <p>You can login again at the link below</p>;
            <a href="index.php" data-bs-target="#loginModal" class="btn btn-danger" role="button">Return to Login</a>
        </main>
            <?php
                
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
        }
        else 
        {
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
            } 
            else {
                $errorMsg = "Email not found or password doesn't match...";
                $success = false;
            }
            $stmt->close();
            
            }
            $conn->close();
            }
            include "footer.inc.php";
            ?>
    </body>
</html>