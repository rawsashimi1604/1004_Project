<?php
/*
 * This file contains the AJAX live search feature found in GamesList
 * The file is called by the javascript function in GamesList that waits for keyup events
 */

    //Connection to DB
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']); 
    
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsgDB = "Connection failed: " . $conn->connect_error;
        $success = false;
        alert($errorMsgDB);
    }

   
    //If the search term was entered, perform the query using it from request
    if(isset($_REQUEST["term"])){
    
        $param_term = strtolower($_REQUEST["term"]);
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM apps_list WHERE lower(name) LIKE '%{$param_term}%'");
        
        // Bind & execute the query statement:
        $stmt->bind_param("isssssssssi", $appid, $name, $price, $description, $image, $developer, $publisher, $windows_requirements, $linux_requirements, $mac_requirements, $genre);

        // Set parameters
        
        
        // Attempt to execute the prepared statement
        if (!$stmt->execute()){
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " .$stmt->error;
            $success = false;
        } else{
            $result = $stmt->get_result();
            // Check number of rows in the result set
            if(!empty($result)){
                // Fetch result rows as an associative array
                foreach ($result as $row){
                    echo "<p>" . $row["name"] . "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        }
        // Close statement
        $stmt->close();
    }

    // close connection
    $conn->close();
?>