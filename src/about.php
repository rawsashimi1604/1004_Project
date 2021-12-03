<!DOCTYPE html>
<html lang="EN">
    <head>
        <?php
            include "head.inc.php";
        ?>
        <title>GamesDex: About Us</title>
    </head>
    
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <!-- MAIN -->
        <main class="container bg-dark text-light about-container">
            <div class="about-wrapper">
                <div class="content">
                    <h1 class="about-header">Who we are</h1>
                    <p class="about-author"><b>Yeong Jing Kang</b>, Backend Developer</p>
                    <p class="about-main-text">
                        We are a team of students from Singapore Institute of Technology currently studying ICT1004 (Web
                        Systems and Techonologies). We hope that through this project, we would be able to apply what we
                        have learnt in class and improve our Web Development skills.
                    </p>
                    <p class="about-main-text">
                        For our project, we decided to do a gaming ecommerce site as we were all passionate about video
                        games.
                    </p>
                    <p class="about-main-text">
                        The main technologies we used were:
                    </p>
                    <ul>
                        <li>HTML -> HTML templating</li>
                        <li>CSS -> Styling</li>
                        <li>Bootstrap -> CSS library to accelarate styling process</li>
                        <li>Vanilla JS -> Client-side scripting</li>
                        <li>PHP -> Main Server-side technology</li>
                        <li>Google Cloud -> Cloud hosting service</li>
                        <li>Apache -> Web server software</li>
                        <li>MySQL -> Database management system (DBMS)</li>
                    </ul>
                    <p class="about-main-text">
                        Visit our <a target="_blank" href="https://github.com/rawsashimi1604/1004_Project">Github Page</a>
                        to view our
                        source code!
                    </p>
                </div>
            </div>
            <div class="about-members">
                <h1 class="about-header">Meet the team!</h1>
                <p class="about-author">And find out more about their favourite games...</p>
                <div class="about-member-profiles">
                    <div class="member">
                        <img src="./images/JingKang.jpeg" alt="" width="120" height="120">
                        <span class="member-name">Jing Kang</span>
                        <span class="member-title">Backend Developer</span>
                        <span class="member-game">Zelda</span>
                    </div>
                    <div class="member">
                        <img src="./images/Hakiim.jpeg" alt="" width="120" height="120">
                        <span class="member-name">Hakiim</span>
                        <span class="member-title">Backend Developer</span>
                        <span class="member-game">Starcraft</span>
                    </div>
                    <div class="member">
                        <img src="./images/Kenneth.PNG" alt="" width="120" height="120">
                        <span class="member-name">Kenneth</span>
                        <span class="member-title">Backend Developer</span>
                        <span class="member-game">Pokemon</span>
                    </div>
                    <div class="member">
                        <img src="./images/KangChen.jpg" alt="" width="120" height="120">
                        <span class="member-name">Kang Chen</span>
                        <span class="member-title">Full Stack Developer</span>
                        <span class="member-game">COD Mobile</span>
                    </div>
                    <div class="member">
                        <img src="./images/Gavin.jpg" alt="" width="120" height="120">
                        <span class="member-name">Gavin</span>
                        <span class="member-title">Frontend Developer</span>
                        <span class="member-game">FIFA</span>
                    </div>
                </div>
            </div>
        </main>
        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>

