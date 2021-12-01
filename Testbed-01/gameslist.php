<!DOCTYPE html>
<html lang="en">
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
                <form method="get">
                    <span class="search-txt mobile-none">Search:</span>
                    <input type="text" name="search" autocomplete="off" class="form-control input-sm" placeholder="Enter search term" aria-controls="browsing_list">
                    <div class="result"></div>
                    <button id="browse_search_button" type="submit" name="submit" class="btn btn-light">Search</button>
                </form>
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
                    foreach ($result as $row) {
                        echo '<tr class="gameslist-rows" onclick="window.location=\'gamepage.php?id=' . $row["appid"] . '\';">
                                    <td class="align-items-center">
                                        <img class="gameslist-thumbnail" src="' . $row["image"] . '" alt="' . $row["name"] . ' Mini Image"/>
                                    </td>
                                    <td class="align-items-center">' . $row["name"] . '</td>
                                    <td class="align-items-center gameslist-desc mobile-none">' . $row["description"] . '</td>
                                    <td class="align-items-center">' . $row["developer"] . '</td>
                                    <td class="align-items-center">' . $row["price"] . '</td>
                                </tr>';
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
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
<script>
    $(document).ready(function() {
        $('.search-box input[type="text"]').on("keyup input", function() {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if (inputVal.length) {
                $.get("DB_livesearch.php", {
                    term: inputVal
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function() {
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>
</html>