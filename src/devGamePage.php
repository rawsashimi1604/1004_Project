<!DOCTYPE html>
<?php
session_start();

require_once "authCookieSessionValidate.php";
$role = $_SESSION['role'];

if($role != "dev" || !$isLoggedIn) {
    header("Location: ./index.php");
} else {
?>
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
        if (!empty($result)) {
            foreach ($result as $row) {
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
        if (!empty($result)) {
            foreach ($result as $row) {
                // Fetch all the results from our database
                $genre_name = $row["genre_name"];
            }
        }
    }
    ?>

    <main class="container text-light game-container">
        <form action="doGameChange.php" method="post" enctype="multipart/form-data">
            <?php if (empty($name)) { ?>
                <p class="game-header text-white">Add a new Game</p>
            <?php } else { ?>
                <p class="game-header"><?php echo "$name" ?></p>
            <?php } ?>
            <?php if (empty($name)) { ?>
                <div class="row mb-3">
                    <label class="col-md-3 form-label" for="gameID"> Game ID </label>
                    <div class="col-md-7">
                        <input class="form-control" type='text' name='gameID'>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-7">
                    <input class="form-control" type='hidden' name='gameID' value='<?php echo "$id" ?>'>
                </div>
            <?php } ?>
            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameName">Game Title</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='gameName' value='<?php echo "$name" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gamePrice">Game Price</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='gamePrice' value='<?php echo "$price" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameDesc">Game Description</label>
                <div class="col-md-7">
                    <textarea type="text" type class="form-control" name='gameDesc' rows="7" maxlength="1024"><?php echo "$description" ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameDev">Game Developer</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='gameDev' value='<?php echo "$developer" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gamePublisher">Game Publisher</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='gamePublisher' value='<?php echo "$publisher" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameWindows">Windows Requirements</label>
                <div class="col-md-7">
                    <textarea type="text" class="form-control" name='gameWindows' rows="7" maxlength="1024"><?php echo "$windows_requirements" ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameLinux">Linux Requirements</label>
                <div class="col-md-7">
                    <textarea type="text" class="form-control" name='gameLinux' rows="7" maxlength="1024"><?php echo "$linux_requirements" ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="gameMac">Mac Requirements</label>
                <div class="col-md-7">
                    <textarea type="text" class="form-control" name='gameMac' rows="7" maxlength="1024"><?php echo "$mac_requirements" ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="genre_id">Game Genre</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='genre_id' value='<?php echo "$genre_id" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="category">Game Category</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='category' value='<?php echo "$gameCat" ?>'>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 form-label" for="category2">Game Category 2</label>
                <div class="col-md-7">
                    <input class="form-control" type='text' name='category2' value='<?php echo "$gameCat2" ?>'>
                </div>
            </div>
            <?php if (empty($name)) { ?>
                <div class="row mb-3">
                    <label class="col-md-3 form-label" for="game_image">Game image</label>
                    <div class="col-md-7">
                        <input class="form-control" type="file" name="game_image" />
                    </div>
                </div>
                <div class="row mb-3">
                    <input type="submit" class="btn btn-primary col-md-2" name="btnAct" value="Submit">
                    <div class="col-md-2">
                        <a class="btn btn-danger" href="./gameslist.php">Cancel</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row mb-3">
                    <div class="col-auto">
                        <input type="submit" class="btn btn-update btn-success" name="btnAct" value="Update">
                    </div>
                    <div class="col-auto">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirmDelete" class="btn btn-danger" name="btnAct" value="Delete">Delete</Button>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-danger" href="./gameslist.php">Cancel</a>
                    </div>
                    <div>
                    <?php } ?>
                    <!-- <div class="row mb-3">
                    <a class="btn btn-danger" href="./gameslist.php">Cancel</a>
                </div> -->
        </form>
        <div class="modal fade " id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-container">
                    <div class="modal-header">
                        <h5 class="modal-title">Are you sure?</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Login details -->
                        <div class="row login-row">
                            <div class="col">
                                <label for="pwd_" class="form-label">You are about to delete a game!</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <a class="btn btn-success" href="" role="button">Yes</a>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- <div class="modal fade" id="confirmDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div> -->

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

<?php } ?>