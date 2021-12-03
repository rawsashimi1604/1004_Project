<?php
//Define and initialize variables to hold our form data:
$email = $pwd_hashed = $errorMsg = ""; 
$success = true; 

//only process if the form has been submitted via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST")
{  
    //Email address
    if (empty($_POST["email"]))
    {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    }
    else
    {
        $email = sanitize_input($_POST["email"]);
        
        //Additional check to make sure e-mail address is well-formed.
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }
    
    //Password
    if (empty($_POST["pwd_"]))
    {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    }
    else
    {
        //NOTE: we do not sanitize the password since this could strip out characters
        //that are meant to be part of the password. Instead, we will hash the password
        //before sorting it in our database, and NEVER output the plaintext password to the web page.
        //$pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);   
    }    
    
    $authenticateUser = authenticateUser();
}
else
{
    header("Location: http://34.126.181.163/project/register.php");
}

function sanitize_input($data) 
{    
    $data = trim($data);   
    $data = stripslashes($data);    
    $data = htmlspecialchars($data);   
    return $data; 
}

function authenticateUser()
{     
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;    

    // Create database connection.    
    $config = parse_ini_file('../../private/db-config.ini');    
    $conn = new mysqli($config['servername'], $config['username'],            
            $config['password'], $config['dbname']);    

    // Check connection    
    if ($conn->connect_error)    
    {        
        $errorMsg = "Connection failed: " . $conn->connect_error;        
        $success = false;
        $isAuthenticated = false;
    }    
    else    
    {        
        // Prepare the statement:        
        $stmt = $conn->prepare("SELECT * FROM steam_clone_members WHERE email=?");        
        
        // Bind & execute the query statement:        
        $stmt->bind_param("s", $email);        
        $stmt->execute();        
        $result = $stmt->get_result();        
        if ($result->num_rows > 0)        
        {            
            // Note that email field is unique, so should only have            
            // one row in the result set.            
            $row = $result->fetch_assoc();            
            $fname = $row["fname"];            
            $lname = $row["lname"];            
            $pwd_hashed = $row["password"];            

            // Check if the password matches:            
            if (!password_verify($_POST["pwd_"], $pwd_hashed))            
            {                
                // Don't be too specific with the error message - hackers don't                
                // need to know which one they got right or wrong. :)                
                $errorMsg = "Email not found or password doesn't match...";                
                $success = false;
                $isAuthenticated = false;
            }           
        }        
        else        
        {            
            $errorMsg = "Email not found or password doesn't match...";            
            $success = false;
            $isAuthenticated = false;
        }        
        $stmt->close();    
    }   
    
    $conn->close();   
}

if (! empty($_POST["login"])) {
    $isAuthenticated = false;
    $username = $_POST["member_name"];
    $password = $_POST["member_password"];
    
    $user = $auth->getMemberByUsername($username);
    if (password_verify($password, $user[0]["member_password"])) {
        $isAuthenticated = true;
    }
    
    if ($isAuthenticated) {
        $_SESSION["member_id"] = $user[0]["member_id"];
        $isAuthenticated = true;
        
    } else {
        $message = "Invalid Login";
    }
}


?>

<html>
    <head>
        <title>Login Results</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <main class="container text-light login-success-container">
            <?php
                if ($success) 
                {
                    $isAuthenticated = true;
                    $user = $auth->getMemberByEmail($email);
                    $_SESSION["member_id"] = $user[0]["member_id"];
                    $_SESSION["role"] = $user[0]["role"];
                    $_SESSION["lname"] = $user[0]["lname"];
                    
                    echo "<h1>Login successful!</h1>"; 
                    echo "<h2>Welcome back, " . $fname . " " . $lname . ".</h2>";
                    echo "<a href='index.php' class='btn btn-success'>Return to Home</a>";
                }   
                else
                { 
                    echo "<h1>Oops!</h2>";
                    echo "<h2>The following errors were detected:</h4>"; 
                    echo "<p>" . $errorMsg . "</p>";
                    echo "<p>You can login again at the link below</p>";
                    echo "<a href='index.php' data-bs-target='#loginModal' class='btn btn-danger' role='button'>Return to Login</a>";
                }
            ?>
        </main>
        <?php
            include "footer.inc.php";
        ?>  

        <script>
            var hiddenElement = document.querySelector(".navbar").querySelectorAll(".d-flex")[1];
            hiddenElement.classList.toggle('display-hide');
        </script>
    </body>
</html>
