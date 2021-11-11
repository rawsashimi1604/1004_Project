<!DOCTYPE html>
<html>
    <head>
    <?php
    include "head.inc.php"
    ?>
    </head>
    
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <?php
        $fname = $email = $lname = $password = $errorMsg = "";
        $success = true;
        #Sanitization for email input
        if (empty($_POST["email"]))
        {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        }
        else
        {
            $email = sanitize_input($_POST["email"]);
            // Additional check to make sure e-mail address is well-formed.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errorMsg .= "Invalid email format.<br>";
                $success = false;
            }
        }

        #Santization for lname input
        if (empty($_POST["lname"]))
        {
            $errorMsg .= "Last name is required.<br>";
            $success = false;
        }
        else
        {
            $lname = sanitize_input($_POST["lname"]);
            // Additional check to ensure lname input does not have funny char
            if(!filter_var($lname, FILTER_SANITIZE_STRING))
            {
                $errorMsg .= "Invalid Last Name format.<br>";
                $success = false;
            }
        }

        #Sanitization for fname input
        if (empty($_POST["fname"]))
        {
            $errorMsg .= "First name is required.<br>";
            $success = false;
        }
        else
        {
            $fname = sanitize_input($_POST["fname"]);
            // Additional check to ensure fname input does not have funny char
            if(!filter_var($fname, FILTER_SANITIZE_STRING))
            {
                $errorMsg .= "Invalid First Name format<br>";
                $success = false;
            }
        }
        #Validation for pwd and pwd_confirm input
        if(strcmp($_POST['pwd'], $_POST['pwd_confirm'])!= 0)
        {
            $errorMsg .= "Passwords do not match.<br>";
            $success = false;
        }
        
        #Password Hashing
        $hashed_password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        if ($success)
        {
            saveMemberToDB();
            if($success){
                ?>
                <br>
                <main class='container'>
                    <h1>Your registration is successful!</h1>
                    <h4>Thank you for signing up <?php echo ($fname . " " . $lname)?></h4>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success">Log In</button>
                </div>
                </main>
                <?php
            }  
            else
            {
                ?>
                <br>
                <main class='container'>
                    <h1>Oops!</h1>
                    <h4>The following input errors were detected:<br></h4>
                    <?php 
                    echo "<p>" . $errorMsg . "</p>";
                    ?>
                    <div class="form-group">
                        <a href="register.php">
                            <button class="btn btn-danger">Return to Sign Up</button>
                        </a>
                    </div>
                </main>

            <?php
            }
        }
        else
        {
            ?>
            <br>
            <main class='container'>
                <h1>Oops!</h1>
                <h4>The following input errors were detected:<br></h4>
                <?php 
                echo "<p>" . $errorMsg . "</p>";
                ?>
                <div class="form-group">
                    <a href="register.php">
                        <button class="btn btn-danger">Return to Sign Up</button>
                    </a>
                </div>
            </main>
        
        <?php
        }

        //Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        /*
        * Helper function to write the member data to the DB
        */
        function saveMemberToDB()
        {
            global $fname, $lname, $email, $hashed_password, $errorMsg, $success;
            // Create database connection.
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

            // Check connection
            if ($conn->connect_error)
            {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            }
            else
            {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password) VALUES (?, ?, ?, ?)");
                // Bind & execute the query statement:
                $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);
                if (!$stmt->execute())
                {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }
        ?>
    </body>
    <?php
    include "footer.inc.php"
    ?>
</html>