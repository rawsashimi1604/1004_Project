<?php
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    //$link = mysqli_connect("localhost", "root", "", "demo");
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

   

    if(isset($_REQUEST["term"])){
    
        $param_term = $_REQUEST["term"];
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