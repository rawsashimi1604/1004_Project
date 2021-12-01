<!DOCTYPE html>
<html lang="en">
<title>GamesDex: Search for your favourite games!</title>
<meta name="List of Games" content="width=device-width, initial-scale=1.0">
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
    <!-- MAIN -->
    <main class="container gameslist-container">
        <section id="browsing_section">
            <h1 class="display-4 text-light text-center mb-5">Search for your favourite games!</h1>
            <div class="search-box">
                <form method="get">
                    <span class="search-txt mobile-none">Search:</span>
                    <input type="text" name="search" autocomplete="off" class="form-control input-sm" placeholder="Enter search term" aria-controls="browsing_list">
                    <div class="result"></div>
                    <button id="browse_search_button" type="submit" name="submit" class="btn btn-light">Search</button>
                </form>
                <?php
                        if($_SESSION["role"] == "dev"){?>
                        <div class="col-md-3">
                        <!-- <button type="button" class="btn btn-primary"><a Add Game</button> -->
                        <a class="btn btn-primary" href="./devGamePage.php" role="button">Add Game</a>
                        </div>
                    <?php }?>
            </div>

            <table id="browsing_list" class="table table-sm table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Title</th>
                        <th class="mobile-none">Description</th>
                        <th>Developer</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "DBController.php";
                    $db_handle = new DBController();
                    $query = "SELECT * FROM apps_list";
                    $result = $db_handle->runBaseQuery($query);
                    if (!empty($_GET["genre_id"]) || !empty($_GET["category_id"]) || !empty($_GET["search"])) {
                        include "DB_search.inc.php";
                    } else {
                        if($_SESSION['role'] != "dev"){
                        foreach ($result as $row) { ?>
                        <tr class="gameslist-rows" onclick="window.location='gamepage.php?id=<?php echo $row["appid"] ?>';">
                            <td class="align-middle">
                                <img class="gameslist-thumbnail" src="<?php echo  $row["image"] ?>" alt="<?php echo $row["name"] ?> Mini Image"/>
                            </td>
                            <td class="align-middle"><?php echo $row["name"]?></td>
                            <td class="align-middle gameslist-desc mobile-none"><?php echo $row["description"] ?></td>
                            <td class="align-middle"><?php echo $row["developer"] ?></td>
                            <td class="align-middle"><?php echo $row["price"] ?></td>
                        </tr>

                    <?php }
                        } else {
                            foreach ($result as $row) { ?>
                            <tr class="gameslist-rows" onclick="window.location='devGamePage.php?id=<?php echo $row["appid"] ?>';">
                            <td class="align-middle">
                                <img class="gameslist-thumbnail" src="<?php echo  $row["image"] ?>" alt="<?php echo $row["name"] ?> Mini Image"/>
                            </td>
                            <td class="align-middle"><?php echo $row["name"]?></td>
                            <td class="align-middle gameslist-desc mobile-none"><?php echo $row["description"] ?></td>
                            <td class="align-middle"><?php echo $row["developer"] ?></td>
                            <td class="align-middle"><?php echo $row["price"] ?></td>
                        </tr>
                    <?php }
                        } } ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php
    include "footer.inc.php";
    ?>
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
</body>

</html>