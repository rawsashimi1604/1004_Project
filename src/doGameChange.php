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

    if($btnVal == "Submit"){
        addGame();
    }
    elseif($btnVal == "Update"){
        updateGame();
    }
    elseif($btnVal == "Delete"){ 
        deleteGame();
    }
    
}
else
{
    header("Location: http://34.126.181.163/project/gameslist.php");
}

function updateGame()
{
  global $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2;
  
  
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
    $stmt = $conn->prepare("UPDATE apps_list SET name = ?, price = ?, description = ?, developer = ?, publisher = ?, windows_requirements = ?, linux_requirements = ?, mac_requirements = ?, genre = ?, category = ?, category2 = ? WHERE appid = ?");
      // Bind & execute the query statement:
      $stmt->bind_param("sissssssiiii", $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2, $app_id);
      if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
      }
      $stmt->close();
      }

  $conn->close();
}
}

function addGame()
{
  global $app_id, $gameTitle, $gamePrice, $gameDesc, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $category_id, $category_id2;
  
  //checks if file was sent
  if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be exactly 2 MB';
      }
      //to upload the file into server
      if(empty($errors)==true) {
          $target = "/var/www/html/project/images/";
          $complete_path = $target . basename($_FILES['image']['name']);
          $file_tmp = $_FILES['image']['tmp_name'];
          move_uploaded_file($file_tmp, $complete_path);
          echo "File has been uploaded";
      }else{
          
          print_r($errors);
      }
   }
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
              $filedir = "images/" . $file_name;
              $stmt = $conn->prepare("INSERT INTO apps_list (appid, name, price, description, image, developer, publisher, windows_requirements, linux_requirements, mac_requirements, genre, category, category2) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                      
              // Bind & execute the query statement:        
              $stmt->bind_param("isisssssssiii", $app_id, $gameTitle, $gamePrice, $gameDesc, $filedir, $dev, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre_id, $gameCat, $gameCat2);
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
  global $app_id;
  
  if (empty($app_id)) {
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
    echo "<script>alert('Ooops something wrong with database connection')</script>";
  } else {
      $stmt = $conn->prepare("DELETE FROM apps_list WHERE appid=?");
      // Bind & execute the query statement:        
      $stmt->bind_param("i", $app_id);
      if (!$stmt->execute()) {
          $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          $success = false;
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
          if($btnVal == "Submit")
          {
              echo "<h1>Game details changed successfully</h1>";
              echo "<a href='gameslist.php' class='btn btn-success'>Return to Home</a>";
          }
          elseif($btnVal == "Update")
          {
              echo "<h1>Game details changed successfully</h1>";
              echo "<a href='gameslist.php' class='btn btn-success'>Return to Home</a>";
          }
          else
          {
              echo "<h1>Game " . $gameTitle . " has been successfully deleted!</h1></br>";
              echo "<a href='gameslist.php' class='btn btn-success'>Return to Home</a>";
          }
          
      } 
      else {
          echo "<h1>Oops!</h2>";
          echo "<h2>The following errors were detected:</h4>";
          echo "<p>" . $errorMsg . "</p>";
          echo "<p>You can login again at the link below</p>";
          echo "<a href='index.php data-bs-target='#loginModal' class='btn btn-danger' role='button'>Return to Home</a>";
      }
      ?>
      <hr>
    </main>
    <?php include "footer.inc.php"; ?>
  </body>
</html>
