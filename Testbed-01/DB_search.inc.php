<?php
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
    else
    {
        $search = $_POST["search"];
        $stmt = $conn->prepare("SELECT * FROM apps_list WHERE name = '$search'");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            // Fetch all the results from our database
            while($row = $result->fetch_assoc()) {
                echo '<tr><td aria-controls="browsing_list" '
                                . 'class="table tbody tr td"><a href="">'
                                . '<img class="img-ss-list" '
                                . 'src="'.$row["image"].'" />'.$row["name"].'</a>'
                                . '</td><td>'.$row["developer"].'</td><td>'
                                .$row["publisher"].'</td></tr>';
            }
        }
        else
        {
            $errorMsgDB = "Looks like there's nothing here..";
            $success = false;
            alert($errorMsgDB);
        }
        $stmt->close();
        $conn->close();  
    }
?>

