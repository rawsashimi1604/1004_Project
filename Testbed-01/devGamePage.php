<!DOCTYPE html>
<html lang="en">
<!-- HEAD -->
<head>
    <?php include "head.inc.php"; ?>
    <title>GamesDex: Developer Game Page</title>
    <meta name="Developers Page" content="width=device-width, initial-scale=1.0">
</head>


<body class="bg-dark">
    <!-- Insert Nav bar -->
    <?php
    include "nav.inc.php";
    ?>
    <!-- MySQL Database Connection-->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET['id'];
        // Prepare the statement:
        require_once "DBController.php";
        $db_handle = new DBController();
        $query = "SELECT * FROM apps_list WHERE appid = '$id'";
        $result = $db_handle->runBaseQuery($query);
        if (!empty($result)){
            foreach ($result as $row){
                // Fetch all the results from our database
                $id = $row["appid"];
                $name = $row["name"];
                $price = $row["price"];
                $description = $row["description"];
                $image = $row["image"];
                $developer = $row["developer"];
                $publisher = $row["publisher"];
                $windows_requirements = strip_tags($row["windows_requirements"]);
                $linux_requirements = strip_tags($row["linux_requirements"]);
                $mac_requirements = strip_tags($row["mac_requirements"]);
                $genre_id = $row["genre"];
                $gameCat = $row["category"];
                $gameCat2 = $row["category2"];
            }
        }
        $query = "SELECT * FROM apps_genres WHERE genre_id = '$genre_id'";
        $result = $db_handle->runBaseQuery($query);
        if (!empty($result)){
            foreach ($result as $row){
                // Fetch all the results from our database
                $genre_name = $row["genre_name"];
            }
        }
    }
    ?>
    
    <main class="container text-light game-container">
        <form action="doGameChange.php" method="post" enctype="multipart/form-data">
            <?php
                if(empty($name)){
                    ?><p class="game-header text-white">Add a new Game</p><?php
                }else{
                    ?><p class="game-header"><?php echo "$name" ?></p><?php
                }?>
            <table>
                <tbody>
                    <?php if(empty($name)){
                        ?>
                    <tr>
                        <td>Game ID</td>
                        <td>
                            <input type='text' name='gameID'>
                        </td>
                    </tr>
                        <?php
                    } else {
                        ?>
                    <tr>
                        <td>
                            <input type='hidden' name='gameID' value='<?php echo "$id"?>'>
                        </td>
                    </tr><?php
                    }
                    ?>
                    
                    <tr>
                        <td>Game Title</td>
                        <td>
                            <input type='text' name='gameName' value='<?php echo "$name"?>'>
                        </td>

                    </tr>
                    <tr>
                        <td>Game Price</td>
                        <td>
                            <input type='text' name='gamePrice' value='<?php echo "$price"?>'>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Description</td>
                        <td>
                            <textarea name='gameDesc'  ><?php echo "$description"?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Developer</td>
                        <td>
                            <input type='text' name='gameDev' value='<?php echo "$developer"?>'>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Publisher</td>
                        <td>
                            <input type='text' name='gamePublisher' value='<?php echo "$publisher"?>'>
                        </td>
                    </tr>
                    <tr>
                        <td>Windows Requirements</td>
                        <td>
                            <textarea name='gameWindows'><?php echo "$windows_requirements"?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Linux Requirements</td>
                        <td>
                            <textarea name='gameLinux'><?php echo "$linux_requirements"?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Mac Requirements</td>
                        <td>
                            <textarea name='gameMac'><?php echo "$mac_requirements"?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Genre</td>
                        <td>
                            <input type='text' name='genre_id' value='<?php echo "$genre_id"?>'>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Category</td>
                        <td>
                            <input type='text' name='category' value='<?php echo "$gameCat"?>'>
                        </td>
                    </tr>
                    <tr>
                        <td>Game Category 2</td>
                        <td>
                            <input type='text' name='category2' value='<?php echo "$gameCat2"?>'>
                        </td>
                    </tr>
                    <?php
                    if(empty($name)){?>
                        <tr>
                            <td>Game image</td>
                            <td>
                                <input type="file" name="image" />
                            </td>
                        </tr><?php
                    }?>
                </tbody>
            </table>
            <div class="row">
                <div class='mt8 bt8' style='text-align: center'>
                    <?php
                    if (empty($name)){
                        ?><input type="submit" class="btn btn-light" name="btnAct" value="Submit">
                        <?php
                    }else{
                        ?><input type="submit" class="btn btn-light" name="btnAct" value="Update">
                        <input type="submit" class="btn btn-danger" name="btnAct" value="Delete"><?php
                    }?>
                        
                    <a class="btn btn-primary" href="./gameslist.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </main>
    
    <!-- FOOTER -->
    <?php
    include "footer.inc.php";
    ?>

    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>