<?php
//    //Remember to name the files according in "Run Configuration" when testing 
//    //this code, such as "Index File" should be corresponding file name here.
//
//
    //Standard database connection creation from labs
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    

    //Get contents of JSON file, need to upload together in project folder.
    $stats = file_get_contents('top50.json', true);
    
    //Decode the JSON file, convert into PHP readable array.
    $json = json_decode($stats, true);
    
    //Loop through the array elements under "applist", "apps", and parse in variable $stat.
    foreach ($json as $stat) 
    {
        $appid = $stat['appid'];
        $name = $stat['name'];
        $price = $stat['price'];
        $image = $stat['image'];
        $developer = $stat['developer'];
        $publisher = $stat['publisher'];
        
        
        $webappinfo = file_get_contents("https://store.steampowered.com/api/appdetails/?appids=$appid", true);
        $json_web = json_decode($webappinfo, true); // <-- Decode JSON to PHP array
        
        //Description GET
        $description = $json_web[$appid]['data']['short_description'];
        $windows_requirements = $json_web[$appid]['data']['pc_requirements']['minimum'];
        $mac_requirements = $json_web[$appid]['data']['mac_requirements']['minimum'];
        $linux_requirements = $json_web[$appid]['data']['linux_requirements']['minimum'];
        
        echo($appid. ", ".$name. ", ".$price. ", ".$description. ", ".$image. ", ".$developer. ", ".$publisher. ", ".$windows_requirements. ", ".$mac_requirements. ", ".$linux_requirements);
        echo("<br/>");
        
        //Database upload statements. Need create the appropriate table and columns in MySQL.
        $stmt = $conn->prepare("INSERT INTO apps_list (appid, name, price, description, image, developer, publisher, windows_requirements, linux_requirements, mac_requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $appid, $name, $price, $description, $image, $developer, $publisher, $windows_requirements, $linux_requirements, $mac_requirements);
        if (!$stmt->execute())
        {
                    $message2 = "Execute failed: (" . $stmt->errno . ") " . 
                            $stmt->error;
                    $success = false;
                    echo($message2);
                    echo($errorMsg);
        }
    }

    $stmt->close();
    $conn->close();
?>

