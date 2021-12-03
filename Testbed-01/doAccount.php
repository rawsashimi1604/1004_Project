<?php

//Define and initialize variables to hold our form data:
//ini_set('display_errors', 1);
session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

$old_pwd = $pwd_hashed = $new_pwd = $errorMsg = ""; 
$userId = $_SESSION['member_id'];
$success = true; 

//only process if the form has been submitted via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST")
{  
    //Email address
    if (empty($_POST["old_pwd"]))
    {
        $errorMsg .= "Original password is required.<br>";
        $success = false;
    }
    else
    {
        $checkOriginalPassword = checkOriginalPassword();
    }
    
    #Validation for pwd and pwd_confirm input
    if(strcmp($_POST['new_pwd'], $_POST['cfm_pwd'])!= 0)
    {
        $errorMsg .= "Passwords do not match...<br>";
        $success = false;
    }
    
    //Password
    if (empty($_POST["new_pwd"]) && empty($_POST["cfm_pwd"]))
    {
        $errorMsg .= "Password is required.<br>";
        $success = false;
    }
    else
    {
        //NOTE: we do not sanitize the password since this could strip out characters
        //that are meant to be part of the password. Instead, we will hash the password
        //before sorting it in our database, and NEVER output the plaintext password to the web page.
        
       
        $pwd_hashed = password_hash($_POST["new_pwd"], PASSWORD_DEFAULT); 
        
    }    
    
    if($success){
        $updateUserPassword = updateUserPassword();
    }
    
}
else
{
    echo "<h2>This page is not meant to be run directly.</h2>";
    echo "<p>You can login at the link below:</p>";
    echo "<a href='login.php'>Go to Sign Up page...</a>";
    exit();
}

function checkOriginalPassword()
{     
    global $original, $userId, $pwd_hashed, $errorMsg, $success;    

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
        $stmt = $conn->prepare("SELECT password FROM steam_clone_members WHERE member_id=?"); 
        // Bind & execute the query statement:        
        $stmt->bind_param("i", $userId);        
        $stmt->execute();        
        $result = $stmt->get_result();        
        if ($result->num_rows > 0)        
        {            
            // Note that email field is unique, so should only have            
            // one row in the result set.            
            $row = $result->fetch_assoc();         
            $pwd_hashed = $row["password"];            
            // Check if the password matches:
            $original = $_POST["old_pwd"];
            if (!password_verify($original, $pwd_hashed))            
            {                
                // Don't be too specific with the error message - hackers don't                
                // need to know which one they got right or wrong. :)                
                $errorMsg = "Original password is wrong...";                
                $success = false;
                $isAuthenticated = false;
            }           
        }        
        else        
        {            
            $errorMsg = "Checking of original password has some issue...";            
            $success = false;
            $isAuthenticated = false;
        }        
        $stmt->close();    
    }   
    
    $conn->close();   
}

function updateUserPassword()
{     
    global $userId, $pwd_hashed, $errorMsg, $success;    

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
        echo "<script>alert('Ooops something wrong with database connection')</script>";
    }    
    else    
    {        
        // Prepare the statement:        
        $stmt = $conn->prepare("UPDATE steam_clone_members SET password = ? WHERE member_id= ?");        
      
        // Bind & execute the query statement:        
        $stmt->bind_param("si", $pwd_hashed, $userId);      
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
<html>
    <head>
        <title>Change password Results</title>
        <?php
            include "head.inc.php";
        ?>
    </head>
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <main class="container text-light">
            <hr>
            <?php
                if ($success) 
                {
                    echo "<h1>Password Changed successfully</h1>"; 
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
            <hr>
        </main>
        <?php
            include "footer.inc.php";
        ?>  
    </body>
</html>
