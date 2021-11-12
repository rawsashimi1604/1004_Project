<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html lang="EN">
    <?php include "head.inc.php" ?>

    <?php include "DB_getall.inc.php" ?>
    <!-- BODY -->

    <body>
        <?php include "nav.inc.php" ?>
        <header class="jumbotron text-center bg-dark">
            <h1 class="display-4 text-light">Steam Clone</h1>
            <h2 class="text-light">Get ready to rumble</h2>
            <div class="game-images">
                <div id="game-image-carousell" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://cdn.akamai.steamstatic.com/steam/apps/10/header.jpg?t=1602535893"
                                 class="d-md-block" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.akamai.steamstatic.com/steam/apps/220/header.jpg?t=1591063154"
                                 class="d-md-block" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.akamai.steamstatic.com/steam/apps/240/header.jpg?t=1602536047"
                                 class="d-md-block" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#game-image-carousell"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#game-image-carousell"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </header>


        <!-- MAIN -->
        <main class="container mt-5">
            <section id="featured">
                <h2 class="text-center">Featured Products</h2>
                <p class="text-center">Checkout new and popular products</p>
                <div class="row">
                    <article>
                        <?php
                        echo '<div class="container"><div class="row row-cols-3">';
                        if ($result->num_rows > 0) {
                            // Fetch all the results from our database
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                <div class="game-thumbnail col">
                                    <div class="card mb-3">
                                        <img class="card-img-top" src="' . $row["image"] . '" />
                                        <div class="card-body">
                                        <h5 class="card-title mb-0">' . $row["name"] . '</h5>
                                    </div>
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

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginmodalTitle">Member Login</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <!-- Login details -->
                            <div class="row login-row">
                                <div class="col">
                                    <label for="email" class="form-label">Enter your email address:</label>
                                    <input type="email" class="form-control" aria-label="First name" id="email">
                                </div>
                            </div>
                            <div class="row login-row">
                                <div class="col">
                                    <label for="pwd" class="form-label">Enter your password:</label>
                                    <input type="password" class="form-control" aria-label="Last name" id="pwd">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-light login-btn">Login</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "footer.inc.php" ?>
    </body>