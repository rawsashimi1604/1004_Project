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
    include "DB_getall.inc.php";
    ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET['id'];
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM apps_list WHERE appid = '$id'");
        // Bind & execute the query statement:
        $stmt->bind_param("issssss", $appid, $name, $price, $description, $image, $developer, $publisher);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch all the results from our database
            while ($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $price = $row["price"];
                $description = $row["description"];
                $image = $row["image"];
                $developer = $row["developer"];
                $publisher = $row["publisher"];
                $windows_requirements = $row["windows_requirements"];
                $linux_requirements = $row["linux_requirements"];
                $mac_requirements = $row["mac_requirements"];
            }
        }
    }
    ?>

    <main class="container text-light game-container">
        <h1 class="game-header"><?php echo "$name" ?></h1>
        <h2 class="game-dev-info">Developed by <span class="game-developer"><?php echo "$developer" ?></span>, published by <span class="game-publisher"><?php echo "$publisher" ?></span></h2>
        <div class="row">
            <div class="col-7 game-images">
                <div id="game-image-carousell" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#game-image-carousell" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo "$image" ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo "$image" ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo "$image" ?>" class="d-block w-100" alt="...">
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

                <div class="game-requirements">
                    <h2>Game Requirements</h2>
                    <hr>
                    <div class="container">
                        <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover" title="PC Requirements" data-bs-content="<?php echo "$windows_requirements" ?>">PC
                            Requirements</button>
                        <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover" title="Mac Requirements" data-bs-content="<?php echo "$mac_requirements" ?>">Mac
                            Requirements</button>
                        <button type="button" class="btn btn-lg btn-light game-popover" data-bs-toggle="popover" title="Linux Requirements" data-bs-content="<?php echo "$linux_requirements" ?>">Linux
                            Requirements</button>
                    </div>
                </div>
            </div>
            <div class="col-5 game-info">
                <img src="<?php echo "$image" ?>" alt="header image" class="game-header-img">

                <div class="game-description-container">
                    <span class="game-description-header">Description</span>
                    <p class="game-description">
                        <?php echo "$description" ?>
                    </p>
                </div>


                <div class="game-price-details" data-aos="fade-right" data-aos-duration="1500">
                    <span class="game-price"><?php echo "$price" ?></span>
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