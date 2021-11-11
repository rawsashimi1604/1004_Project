<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
    <?php
        include "head.inc.php";
    ?>

    <body class="bg-dark">
        <!-- Insert Nav bar -->
        <?php
            include "nav.inc.php";
        ?>
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET")
            {
               $id = $_GET['id'];
               echo "<div>'.$id.'</div>";
            }
        ?>

        <main class="container text-light game-container">
            <h1 class="game-header">Counter-Strike</h1>
            <h2 class="game-dev-info">developed by <span class="game-developer">Valve</span>, published by <span
                    class="game-publisher">Valve</span></h2>
            <div class="row">
                <div class="col-7 game-images">
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
                                <img src="https:\/\/cdn.akamai.steamstatic.com\/steam\/apps\/10\/0000000132.1920x1080.jpg?t=1602535893"
                                    class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https:\/\/cdn.akamai.steamstatic.com\/steam\/apps\/10\/0000000133.1920x1080.jpg?t=1602535893"
                                    class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https:\/\/cdn.akamai.steamstatic.com\/steam\/apps\/10\/0000000134.1920x1080.jpg?t=1602535893"
                                    class="d-block w-100" alt="...">
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

                    <div class="game-requirements">
                        <h2>Game Requirements</h2>
                        <hr>
                        <div class="container">
                            <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover"
                                title="PC Requirements"
                                data-bs-content="And here's some amazing content. It's very engaging. Right?">PC
                                Requirements</button>
                            <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover"
                                title="Mac Requirements"
                                data-bs-content="And here's some amazing content. It's very engaging. Right?">Mac
                                Requirements</button>
                            <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover"
                                title="Linux Requirements"
                                data-bs-content="And here's some amazing content. It's very engaging. Right?">Linux
                                Requirements</button>
                        </div>
                    </div>
                </div>
                <div class="col-5 game-info">
                    <img src="https:\/\/cdn.akamai.steamstatic.com\/steam\/apps\/10\/header.jpg?t=1602535893"
                        alt="header image" class="game-header-img">

                    <div class="game-description-container">
                        <span class="game-description-header">Description</span>
                        <p class="game-description">Play the world's number 1 online action game. Engage in an incredibly
                            realistic brand of terrorist
                            warfare in this wildly popular team-based game. Ally with teammates to complete strategic
                            missions.
                            Take out enemy sites. Rescue hostages. Your role affects your team's success. Your team's
                            success
                            affects your role.</p>
                    </div>


                    <div class="game-price-details" data-aos="fade-right" data-aos-duration="1500">
                        <span class="game-price">$10.00</span>
                        <button type="button" class="btn btn-success">Add to Cart</button>
                    </div>
                    <span>Genres:</span>
                    <div class="game-genres">
                        <span class="game-genre">Action</span>
                        <span class="game-genre">FPS</span>
                    </div>
                    <span>Categories:</span>
                    <div class="game-categories">
                        <span class="game-category">Multi-player</span>
                        <span class="game-category">PvP</span>
                        <span class="game-category">Online PvP</span>
                        <span class="game-category">Shared\/Split Screen PvP</span>
                        <span class="game-category">Valve Anti-Cheat enabled</span>
                    </div>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
        
        <script>
            $(document).ready(function () {
                $('[data-bs-toggle="popover"]').popover();
            });
        </script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>