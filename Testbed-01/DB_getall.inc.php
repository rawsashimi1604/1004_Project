<?php
    /*
     * Get all game items from DB function include file
     */
    // Setup connection configuration
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsgDB = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM apps_list");
        // Bind & execute the query statement:
        $stmt->bind_param("issssss", $appid, $name, $price, $description, $image, $developer, $publisher);
        $stmt->execute();
        $result = $stmt->get_result();
    }
?>