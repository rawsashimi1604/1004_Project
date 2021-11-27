<!DOCTYPE html>
<html lang="EN">
    <?php
        include "head.inc.php";
    ?>
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <!-- MAIN -->
        <main class="container bg-dark text-light about-container">
            <div class="row">
                <div class="col-md about-col aos-init aos-animate" data-aos="fade-right" data-aos-duration="1500">
                    <img src="./images/about_game.jpg" alt="Gaming controller" class="game-img">
                </div>
                <div class="col-md about-col aos-init aos-animate" data-aos="fade-left" data-aos-duration="1500">
                    <p>We are a team of students from SIT.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md order-md-1 order-2 about-col aos-init aos-animate" data-aos="fade-right"
                    data-aos-duration="1500">
                    <p>We are a team of students from SIT.</p>
                </div>
                <div class="col-md order-md-2 order-1 about-col aos-init aos-animate" data-aos="fade-left"
                    data-aos-duration="1500">
                    <img src="./images/about_game.jpg" alt="Gaming controller" class="game-img">
                </div>
            </div>

            <div class="row">
                <div class="col-md about-col aos-init aos-animate" data-aos="fade-right" data-aos-duration="1500">
                    <img src="./images/about_game.jpg" alt="Gaming controller" class="game-img">
                </div>
                <div class="col-md about-col aos-init aos-animate" data-aos="fade-left" data-aos-duration="1500">
                    <p>We are a team of students from SIT.</p>
                </div>
            </div>
        </main>
        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>

