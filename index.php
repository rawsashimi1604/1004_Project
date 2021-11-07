<?php
//    $config = parse_ini_file('../../private/db-config.ini');
//    $conn = new mysqli($config['servername'], $config['username'],
//    $config['password'], $config['dbname']);
//    // Check connection
//    if ($conn->connect_error)
//    {
//        $errorMsg = "Connection failed: " . $conn->connect_error;
//        $success = false;
//    }
    $stats = $stats = '{
    "applist": {
        "apps": [{
                "appid": 216938,
                "name": "Pieterw test app76 ( 216938 )"
            },
            {
                "appid": 660010,
                "name": "test2"
            },
            {
                "appid": 660130,
                "name": "test3"
            },
            {
                "appid": 1118314,
                "name": ""
            },
            {
                "appid": 442314,
                "name": "Intro to Zbrush - Part 3: Zbrush Document Setup"
            },
            {
                "appid": 442315,
                "name": "Intro to Zbrush - Part 4: Zbrush Tiling Plane Setup"
            },
            {
                "appid": 442316,
                "name": "Intro to Zbrush - Part 5: Zbrush Tips and Tricks"
            },
            {
                "appid": 442317,
                "name": "Forest Ground - Part 1: Reference Review"
            },
            {
                "appid": 442318,
                "name": "Forest Ground - Part 2: Substance Ground Alpha"
            },
            {
                "appid": 442319,
                "name": "Forest Ground - Part 3: Zbrush Ground Start"
            },
            {
                "appid": 442320,
                "name": "Forest Ground - Part 4: Ztools Creation – Branches"
            },
            {
                "appid": 442321,
                "name": "Forest Ground - Part 5: Ztools Creation – Pebbles"
            },
            {
                "appid": 442322,
                "name": "Forest Ground - Part 6: Ztools Creation – Leaves"
            },
            {
                "appid": 442323,
                "name": "Forest Ground - Part 7: Ztools Variations - Leaf"
            },
            {
                "appid": 442324,
                "name": "Forest Ground - Part 8: Ztools Variations - Branches"
            },
            {
                "appid": 442325,
                "name": "Forest Ground - Part 9: Zbrush Ground Texturing"
            },
            {
                "appid": 442326,
                "name": "Forest Ground - Part 10: Checking our Progress"
            },
            {
                "appid": 442327,
                "name": "Forest Ground - Part 11: Nanomeshing Rocks"
            },
            {
                "appid": 442328,
                "name": "Forest Ground - Part 12: Nanomeshing Branches"
            },
            {
                "appid": 442329,
                "name": "Forest Ground - Part 13: Nanomeshing Leaves"
            },
            {
                "appid": 442330,
                "name": "Forest Ground - Part 14: Fibermesh Grassing Time"
            },
            {
                "appid": 442331,
                "name": "Forest Ground - Part 15: Making Final Adjustments"
            },
            {
                "appid": 442332,
                "name": "Forest Ground - Part 16: Tiling Our Nanomesh"
            },
            {
                "appid": 442333,
                "name": "Forest Ground - Part 17: Rendering out our Textures"
            },
            {
                "appid": 442334,
                "name": "Forest Ground - Part 18: Photoshop File Setup"
            }
        ]
    }
    }';

    //$stats = file_get_contents('gameData.json', true);
    $json = json_decode($stats, true);
    foreach ($json['applist']['apps'] as $stat) 
    {
        $appid = $stat['appid'];
        $name = $stat['name'];
//        echo($appid. ", ".$name);
//        echo("<br/>");
//        $stmt = $conn->prepare("INSERT INTO apps_list (appid, name) VALUES (?, ?)");
//        $stmt->bind_param("ss", $appid, $name);
//        if (!$stmt->execute())
//        {
//                    $message2 = "Execute failed: (" . $stmt->errno . ") " . 
//                            $stmt->error;
//                    $success = false;
//        }
    }

//    $stmt->close();
//    $conn->close();
?>

<html>
    <head>
        <title>Registration Results</title>
    </head>
    <body>
        <br>
        <main class="container">
            <div>
                <h2><?php echo "$message1"?></h2>
                <h4><?php echo "$message2"?></h4>
            </div>
        </main>
        <br>
    </body>
</html>

