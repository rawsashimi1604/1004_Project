<?php

session_start();

require_once "authCookieSessionValidate.php";

//Define and initialize variables to hold our form data:
$app_id = $gameTitle = $gamePrice = $gameDesc = $errorMsg = ""; 
$success = true;

//only process if the form has been submitted via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST")
{  
    //Game Details
    $app_id = $_POST['gameID'];
    $gameTitle = $_POST['gameName'];
    $gamePrice = $_POST['gamePrice'];
    $gameDesc = $_POST['gameDesc'];
    $dev = $_POST['gameDev'];
    $publisher = $_POST['gamePublisher'];
    $windows_requirements = $_POST['gameWindows'];
    $linux_requirements = $_POST['gameLinux'];
    $mac_requirements = $_POST['gameMac'];
    $genre_id = $_POST['genre_id'];
    $category_id = $_POST['category'];
    $category_id2 = $_POST['category2'];
    $btnVal = $_POST['btnAct'];
    //echo $btnVal;
    if($btnVal == "Submit"){
        //if($app_id)
        addGame();
        echo "<h1>New Game added!</h1>";
        echo "GameID: " . $app_id . "<br>Game Title: " . $gameTitle . "<br>Game Price: " . $gamePrice . "<br>GameDesc: " . $gameDesc . "<br>Gamedev: " . $dev . "<br>Publisher: " . $publisher . "<br>winreq: " . $windows_requirements . "<br>linreq: " . $linux_requirements . "<br>Macreq: " . $mac_requirements . "<br>GenreID: " . $genre_id . "<br>Cat1: " . $category_id . "<br>Cat2: " . $category_id2;
    }
    elseif($btnVal == "Update"){
//        echo "app id is " . $app_id;
//        echo "</br>".$name;
//        echo "<h1>Game " . $name . " details has been updated!";
        echo "GameID: " . $app_id . "<br>Game Title: " . $gameTitle . "<br>Game Price: " . $gamePrice . "<br>GameDesc: " . $gameDesc . "<br>Gamedev: " . $dev . "<br>Publisher: " . $publisher . "<br>winreq: " . $windows_requirements . "<br>linreq: " . $linux_requirements . "<br>Macreq: " . $mac_requirements . "<br>GenreID: " . $genre_id . "<br>Cat1: " . $category_id . "<br>Cat2: " . $category_id2;
        updateGame();
    }
    elseif($btnVal == "Delete"){
        //deleteGame();
        echo "<h1>Game " . $gameTitle . " has been successfully deleted! wowowow well done.</h1></br>";
        echo "sike not implemented yet";
    }
    
}
else
{
    echo "<h2>This page is not meant to be run directly.</h2>";
    echo "<p>You can login at the link below:</p>";
    echo "<a href='login.php'>Go to Sign Up page...</a>";
    exit();
}

function updateGame()
{
  global $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2;
  //, $price, $desc, $dev, $publisher, $windows_requirements, $linux_requirements
  
  if (empty($gameTitle) || empty($app_id)) {
    echo "name is empty";
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
    //$isAuthenticated = false;
    echo "<script>alert('Ooops something wrong with database connection')</script>";
  } else {
    // Prepare the statement:
    $stmt = $conn->prepare("UPDATE apps_list SET name = '$gameTitle', price = $gamePrice, description = '$gameDesc', developer = '$dev', publisher = '$publisher', windows_requirements = '$windows_requirements', linux_requirements = '$linux_requirements', mac_requirements = '$mac_requirements', genre = $genre_id, category = $category_id, category2 = $category_id2 WHERE appid = $app_id");
    //, price = '$price', description = '$desc', developer = '$developer', publisher = '$publisher', windows_requirement = '$windows_requirements', linux_requirement = '$linux_requirements', mac_requirements = '$mac_requirements', genre = '$genre_id', category = '$category_id', category2 = '$category_id2' 
    // Bind & execute the query statement:        
    //$stmt->bind_param("i", $app_id);
    // $fname, $dob, $email, $userId
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
function addGame()
{
  global $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2;
  
  if (empty($gameTitle) || empty($app_id) || empty($gamePrice) || empty($gameDesc) || empty($dev) || empty($windows_requirements) || empty($linux_requirements) || empty($mac_requirements) || empty($genre_id) || empty($category_id) || empty($category_id2)) {
    echo "something is empty";
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
    //$isAuthenticated = false;
    echo "<script>alert('Ooops something wrong with database connection')</script>";
  } else {
          // Prepare the statement:
          $checkId = $conn->prepare("SELECT * FROM apps_list WHERE appid=?");
          $checkId->bind_param("i", $app_id);
          $checkId->execute();
          $result = $checkId->get_result();
          if ($result->num_rows > 0){
              $errorMsg = "Game ID already exists";
              $success = false;
          }
          else{
              $stmt = $conn->prepare("INSERT INTO apps_list (appid, name, price, description, developer, publisher, windows_requirements, linux_requirements, mac_requirements, genre, category, category2) VALUES ($app_id, '$gameTitle', $gamePrice, '$gameDesc', '$dev', '$publisher', '$windows_requirements', '$linux_requirements', '$mac_requirements', $genre_id, $category_id, $category_id2)");
              // Bind & execute the query statement:        
              //$stmt->bind_param("isissssssiii", $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $gameCat, $gameCat2);
              if (!$stmt->execute()) {
                  $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                  $success = false;
              }
          }
          
          $stmt->close();
          
          }
          $conn->close();
          
          }
}
function deleteGame()
{
  global $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2;
  
  if (empty($gameTitle) || empty($app_id) || empty($gamePrice) || empty($gameDesc) || empty($dev) || empty($windows_requirements) || empty($linux_requirements) || empty($mac_requirements) || empty($genre_id) || empty($category_id) || empty($category_id2)) {
    echo "something is empty";
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
    //$isAuthenticated = false;
    echo "<script>alert('Ooops something wrong with database connection')</script>";
  } else {
          // Prepare the statement:
          $checkId = $conn->prepare("SELECT * FROM apps_list WHERE appid=?");
          $checkId->bind_param("i", $app_id);
          $checkId->execute();
          $result = $checkId->get_result();
          if ($result->num_rows > 0){
              $errorMsg = "Game ID already exists";
              $success = false;
          }
          else{
              $stmt = $conn->prepare("INSERT INTO apps_list (appid, name, price, description, developer, publisher, windows_requirements, linux_requirements, mac_requirements, genre, category, category2) VALUES ($app_id, '$gameTitle', $gamePrice, '$gameDesc', '$dev', '$publisher', '$windows_requirements', '$linux_requirements', '$mac_requirements', $genre_id, $category_id, $category_id2)");
              // Bind & execute the query statement:        
              //$stmt->bind_param("isissssssiii", $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $gameCat, $gameCat2);
              if (!$stmt->execute()) {
                  $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                  $success = false;
              }
          }
          
          $stmt->close();
          
          }
          $conn->close();
          
          }
}
?>
<html lang="en">
  <head>
    <title>Game Details</title>
    <?php include "head.inc.php"; ?>
  </head>

  <body class="bg-dark">
    <?php include "nav.inc.php"; ?>
    <main class="container text-light">
      <hr>
      <?php
      if ($success) {
          echo $app_id;
          echo $gameTitle;
        echo "<h1>Game details changed successfully</h1>";
        echo "<a href='devGamePage.php?id=".$app_id."' class='btn btn-success'>Back</a>";
        echo "<a href='devGamesList' class='btn btn-success'>Return to Home</a>";
      } else {
        echo "<h1>Oops!</h2>";
        echo "<h2>The following errors were detected:</h4>";
        echo "<p>" . $errorMsg . "</p>";
        echo "<p>You can login again at the link below</p>";
        echo "<a href='index.php data-bs-target='#loginModal' class='btn btn-danger' role='button'>Return to Login</a>";
      }
      ?>
      <hr>
    </main>
    <?php include "footer.inc.php"; ?>
  </body>
</html>
<?php
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
?>