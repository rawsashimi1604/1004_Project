<?php

session_start();

require_once "authCookieSessionValidate.php";

$lname = $fname = $dob = $email = $errorMsg = "";
$userId = $_SESSION['member_id'];
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $lname = $_POST["lname"];
   $fname = ($_POST["fname"]);
   $dob = ($_POST["dob"]);
   $email = ($_POST["email"]);
  updateDetails();
}

function updateDetails()
{
  global $lname, $fname, $dob, $email, $userId, $errorMsg;
  // , $fname, $dob, $email, $userId, $errorMsg, $success;

  if (empty($lname)) {
    echo "last name is empty";
  } else {

  // Create database connection.    
  $config = parse_ini_file('../../private/db-config.ini');
  $conn = new mysqli(
    $config['servername'],
    $config['username'],
    $config['password'],
    $config['dbname']
  );

  // Check connection    
  if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
    $isAuthenticated = false;
    echo "<script>alert('Ooops something wrong with database connection')</script>";
  } else {
    // Prepare the statement:
    $stmt = $conn->prepare("UPDATE steam_clone_members SET lname = '$lname', fname = '$fname', dob='$dob', email='$email' WHERE member_id= $userId");
    if (!$stmt->execute()) {
      $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      $success = false;
      //echo "<script>alert('Failed to update details')</script>";
    }
    $stmt->close();
  }

  $conn->close();
}
}
?>

<html lang="en">
  <head>
    <title>Update Account Details</title>
    <?php include "head.inc.php"; ?>
  </head>

  <body class="bg-dark">
    <?php include "nav.inc.php"; ?>
    <main class="container text-light">
      <hr>
      <?php
      if ($success) {
        echo "<h1>Account details changed successfully</h1>";
        echo "<a href='index.php' class='btn btn-success'>Return to Home</a>";
      } else {
        echo "<h1>Oops!</h2>";
        echo "<h2>The following errors were detected:</h4>";
        echo "<p>" . $errorMsg . "</p>";
        echo "<p>You can login again at the link below</p>";
        echo "<a href='index.php' data-bs-target='#loginModal' class='btn btn-danger' role='button'>Return to Login</a>";
      }
      ?>
      <hr>
    </main>
    <?php include "footer.inc.php"; ?>
  </body>
</html>