<?php
//Define and initialize variables to hold our form data:
$app_id = $gameTitle = $gamePrice = $gameDesc = $errorMsg = ""; 
$success = true;

//only process if the form has been submitted via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST")
{  
    //Game Name
    
}
else
{
    echo "<h2>This page is not meant to be run directly.</h2>";
    echo "<p>You can login at the link below:</p>";
    echo "<a href='login.php'>Go to Sign Up page...</a>";
    exit();
}

/*
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
    </body>
</html>
*/