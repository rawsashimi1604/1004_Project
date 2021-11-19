<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html lang="EN">
<!-- HEAD SETUP -->
<?php
include "head.inc.php";
session_start();
?>

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

    <!-- MAIN -->
    <main class="container gameslist-container">
        <section id="browsing_section">
            <div class="search-box">
                <form method="post">
                    <span class="search-txt">Search:</span>
                    <input type="text" name="search" autocomplete="off" class="form-control input-sm" placeholder="Enter search term" aria-controls="browsing_list">
                    <input id="browse_search_button" type="submit" name="submit">
                </form>
            </div>
            </div>

            <table id="browsing_list" class="table">
                <thead>
                    <tr>
                        <th scope="col">Game</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Developer</th>
                        <th scope="col">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "DBController.php";
                    $db_handle = new DBController();
                    $query = "SELECT * FROM apps_list";
                    $result = $db_handle->runBaseQuery($query);
                    foreach ($result as $row) {
                        echo '<tr class="gameslist-rows" onclick="window.location=\'gamepage.php?id=' . $row["appid"] . '\';">
                                <td valign="middle" scope="row">
                                    <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                </td>
                                <td valign="middle">' . $row["name"] . '</td>
                                <td valign="middle" class="gameslist-desc">' . $row["description"] . '</td>
                                <td valign="middle">' . $row["developer"] . '</td>
                                <td valign="middle">' . $row["price"] . '</td>
                            </tr>';
                        // echo '<tr aria-controls="browsing_list"><a href="gamepage.php?id='.$row["appid"].'">'
                        //     . '<img class="img-ss-list" src="'.$row["image"].'" />'
                        //     .$row["name"].'</a></td><td>'.$row["developer"].'</td><td>'
                        //     .$row["price"].'</tr>';
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        include "DB_search.inc.php";
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