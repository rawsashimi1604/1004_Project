<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php include "head.inc.php"; ?>

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
        <h1 class="game-header"><?php echo "$name" ?></h1>
        <table border="0" cellpadding="5" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td width ="130" valign='top'>Game Title</td>
                    <td>
                        <input type='text' name='gameName' value='<?php echo "$name"?>'>
                    </td>
                    
                </tr>
                <tr>
                    <td width ="130" valign='top'>Game Price</td>
                    <td>
                        <input type='text' name='gamePrice' value='<?php echo "$price"?>'>
                    </td>
                </tr>
                <tr>
                    <td width ="130" valign='top'>Game Description</td>
                    <td>
                        <textarea name='gameDesc' rows='4' cols='50'> <?php echo "$description"?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class='mt8 bt8' style='text-align: center'>
                <input type='button' class='btn btn-light login-btn' value='Submit'>
                <input type='button' class='btn btn-light login-btn' value='Delete'>
            </div>
        </div>
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