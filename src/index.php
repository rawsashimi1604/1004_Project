<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.inc.php" ?>
    <title>GamesDex: Welcome!</title>
    <meta name="Home Page" content="width=device-width, initial-scale=1.0">
</head>


<?php include "DB_getall.inc.php" ?>
<!-- BODY -->

<body class="bg-dark">
    <?php include "nav.inc.php" ?>
    <header class="container jumbotron text-center mb-0 home-container">
        <div class="game-images">
            <div id="game-image-carousell" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <a href="./gamepage.php?id=570">
                            <img src="./images/indexCarousel-1.jpg" class="d-md-block" alt="carousel-img-1">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a href="./gamepage.php?id=730">
                            <img src="./images/indexCarousel-2.jpg" class="d-md-block" alt="carousel-img-3">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a href="./gamepage.php?id=570">
                            <img src="./images/indexCarousel-3.jpg" class="d-md-block" alt="carousel-img-3">
                        </a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#game-image-carousell" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#game-image-carousell" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </header>


    <!-- MAIN -->
    <main class="container my-4 mt-0 mb-0">
        <section id="featured" class="index-featured">
            <h2 class="text-center py-3">Featured Products</h2>
            <p class="text-center">Checkout new and popular products</p>
            <div class="row">
                <article>
                    <?php
                    echo '<div class="container"><div class="row row-cols-lg-3 row-cols-1">';
                    if ($result->num_rows > 0) {
                        // Fetch all the results from our database
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <div class="col">
                                    <div class="game-thumbnail-card card mb-3">
                                        <a class href="gamepage.php?id=' . $row["appid"] . '">
                                            <div class="thumbnail-wrapper">
                                                <img class="card-img-top" src="' . $row["image"] . '" alt="' . $row["name"] . ' Thumbnail Image"/>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title mb-0">' . $row["name"] . '</h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>';
                        }
                    } else {
                        $errorMsgDB = "Looks like there's nothing here..";
                        $success = false;
                    }
                    echo "</div></div>";
                    ?>
                </article>
            </div>
        </section>
    </main>


    <!-- FOOTER -->
    <?php include "footer.inc.php" ?>
    
    <?php
        session_start();

        require_once "Auth.php";
        require_once "Util.php";

        $auth = new Auth();
        $db_handle = new DBController();
        $util = new Util();

        require_once "authCookieSessionValidate.php";

        function debug_to_console($data)
        {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);

            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }

        if ($isLoggedIn) {
            //$util->redirect("dashboard.php");
            debug_to_console("Logged in");
        } else {
            debug_to_console("Logged out");
        }
    ?>
</body>

</html>