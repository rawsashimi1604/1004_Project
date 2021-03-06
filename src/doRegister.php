<!DOCTYPE html>
<html lang="EN">
    <head>
        <?php
        include "head.inc.php";
        include "email.php";
        ?>
        <title>Thank you for registering!</title>
    </head>
    
    <body class="bg-dark">
        <?php
        include "nav.inc.php";
        ?>
        <?php
        $fname = $lname = $password = $dob = $email = $errorMsg = "";
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
        if ($_POST["fname"])
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
        if(strcmp($_POST['pwd'], $_POST['cfm_pwd'])!= 0)
        {
            $errorMsg .= "Passwords do not match.<br>";
            $success = false;
        }
        
        #Password Hashing
        $hashed_password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        
        #Date Of Birth
        $dob = $_POST['dateofbirth'];

        if ($success)
        {
            saveMemberToDB();
            if($success){
                ?>
                <br>
                <main class='container text-light register-success-container'>
                    <h1>Your registration is successful!</h1>
                    <h4>Thank you for signing up with GamesD??x! <?php echo ($fname . " " . $lname)?></h4>
                    <div class="form-group">
                    <button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</button>
                </div>
                </main>
                <?php
                $subject = "GamesDex Account Registration Notice";
                $email = $_POST["email"];
                $lname = $_POST["lname"];
                $message = "
                    <!DOCTYPE html>
                        <html lang='en'>
                            <head>
                                <title>Heyy</title>
                            </head>

                            <body>
                                <style>

                                </style>

                                <main>
                                    <h1>Welcome to GamesDex! ".$lname."</h1>
                                    <p>This email is to confirm that you have successfully registered with us.
                                    We hope that we can provide you with the greatest gaming purchasing needs.
                                    </p>
                                    <p>
                                        Thank you for registering with us! Your Email: ".$email."
                                    </p>
                                    <p>Visit our <a href='https://github.com/rawsashimi1604/1004_Project/'>Github Page</a> to view our source code!
                                    </p>
                                </main>
                            </body>

                    </html>
                ";
                // Send email
                SendEmail($email, $lname, $message, $subject);
            }  
            else
            {
                ?>
                <br>
                <main class='container text-light'>
                    <h1>Oops!</h1>
                    <h4>The following input errors were detected:<br></h4>
                    <?php 
                    echo "<p>" . $errorMsg . "</p>";
                    ?>
                    <a class="btn btn-danger" href="./register.php" role="button">Return to Sign Up</a>
                </main>

            <?php
            }
        }
        else
        {
            ?>
            <br>
            <main class='container text-light'>
                <h1>Oops!</h1>
                <h4>The following input errors were detected:<br></h4>
                <?php 
                echo "<p>" . $errorMsg . "</p>";
                ?>
                <a class="btn btn-danger" href="./register.php" role="button">Return to Sign Up</a>
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
            global $fname, $lname, $hashed_password, $dob, $email, $errorMsg, $success;
            $role = 'member';
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
                //something wrong with checking email variable
                
                
                    // Prepare the statement:
                    $stmt = $conn->prepare("INSERT INTO steam_clone_members (fname, lname, dob, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                    // Bind & execute the query statement:
                    $stmt->bind_param("ssssss", $fname, $lname, $dob, $email, $hashed_password, $role);
                
                if (!$stmt->execute())
                {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();
        }
        include "footer.inc.php"
        ?>
    </body>
</html>