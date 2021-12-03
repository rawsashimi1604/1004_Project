<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html lang="EN">

<!-- HEAD SETUP -->
<head>
    <?php
        include "head.inc.php";
        session_start();
    ?>
    <title>GamesDex: Developers List</title>
    <meta name="List of Games" content="width=device-width, initial-scale=1.0">
</head>
    

<script>
$(document).ready(function() {
    $('.search-box input[type="text"]').on("keyup input", function() {
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("DB_livesearch.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>

<!-- MySQL Database Connect get ALL -->
<?php
include "DB_getall.inc.php";
?>

<!-- BODY -->

<body>
    <?php
    include "nav.inc.php";
    ?>
    <!-- HEADER -->
    <header class="jumbotron text-center bg-dark gameslist-header">
        <h1 class="display-4 text-light">Search for your favourite games!</h1>
    </header>
    <?php
    if($_SESSION['role'] == "dev"){
        echo "YO HERE I AM";
    }else{
        echo "not working";
        echo "<br>ID= " . $_SESSION["member_id"];
    }
?>
    <!-- MAIN -->
    <main class="container gameslist-container">
        <section id="browsing_section">
            <div class="search-box">
                <div class="row">
                    <div class="col-md-10">
                        <form method="get">
                            <span class="search-txt">Search:</span>
                            <input type="text" name="search" autocomplete="off" class="form-control input-sm" placeholder="Enter search term" aria-controls="browsing_list">
                            <div class="result"></div>
                            <input id="browse_search_button" type="submit" name="submit">
                        </form>
                        
                    </div>
                    <?php
                        if($_SESSION["role"] == "dev"){?>
                        <div class="col-md-2">
                        <!-- <button type="button" class="btn btn-primary"><a Add Game</button> -->
                        <a class="btn btn-primary" href="./devGamePage.php" role="button">Add Game</a>
                        </div>
                    <?php }?>
                </div>
            </div>

            <table id="browsing_list" class="table table-sm table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Game</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="mobile-none">Description</th>
                        <th scope="col">Developer</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once "DBController.php";
                        $db_handle = new DBController();
                        $query = "SELECT * FROM apps_list";
                        $result = $db_handle->runBaseQuery($query);
                        if($_SESSION['role'] == "dev"){
                        foreach ($result as $row) {
                            echo '<tr class="gameslist-rows" onclick="window.location=\'devGamePage.php?id=' . $row["appid"] . '\';">
                                    <td valign="middle" scope="row">
                                        <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                    </td>
                                    <td valign="middle">' . $row["name"] . '</td>
                                    <td valign="middle" class="gameslist-desc mobile-none">' . $row["description"] . '</td>
                                    <td valign="middle">' . $row["developer"] . '</td>
                                    <td valign="middle">' . $row["price"] . '</td>
                                </tr>';
                            // echo '<tr aria-controls="browsing_list"><a href="gamepage.php?id='.$row["appid"].'">'
                            //     . '<img class="img-ss-list" src="'.$row["image"].'" />'
                            //     .$row["name"].'</a></td><td>'.$row["developer"].'</td><td>'
                            //     .$row["price"].'</tr>';
                        }
                        }else{
                            foreach ($result as $row) {
                            echo '<tr class="gameslist-rows" onclick="window.location=\'gamepage.php?id=' . $row["appid"] . '\';">
                                    <td valign="middle" scope="row">
                                        <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                    </td>
                                    <td valign="middle">' . $row["name"] . '</td>
                                    <td valign="middle" class="gameslist-desc mobile-none">' . $row["description"] . '</td>
                                    <td valign="middle">' . $row["developer"] . '</td>
                                    <td valign="middle">' . $row["price"] . '</td>
                                </tr>';
                        }
                        }
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "DBController.php";
    $db_handle = new DBController();
    $genresearch = ($_GET["genre_id"]);
    $namesearch = strtolower($_GET["search"]);
    
    if (!empty($genresearch)){
        $query = "SELECT * FROM apps_list WHERE genre LIKE '$genresearch'";
    }
    else{
        $query = "SELECT * FROM apps_list WHERE lower(name) LIKE '%{$namesearch}%'";
    }
    
    $result = $db_handle->runBaseQuery($query);
    if (!empty($result)){
        echo '<script>jQuery(document).ready(remove_rows('.count($result).'));</script>';
        foreach ($result as $row){
        echo '<tr class="gameslist-rows" onclick="window.location=\'devGamePage.php?id=' . $row["appid"] . '\';">
                                <td valign="middle" scope="row">
                                    <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                </td>
                                <td valign="middle">' . $row["name"] . '</td>
                                <td valign="middle" class="gameslist-desc">' . $row["description"] . '</td>
                                <td valign="middle">' . $row["developer"] . '</td>
                                <td valign="middle">' . $row["price"] . '</td>
                            </tr>';
        } 
    }
    else{
        echo '<script>jQuery(document).ready(remove_rows(1));</script>';
        echo '<tr class="gameslist-rows"><td>Looks like theres nothing here...</td></tr>';
    }
                        }
                        echo
                        '</tbody>
                        </table>';
                    ?>
        </section>
    </main>
    <?php
    include "footer.inc.php";
    ?>
</body>

</html>