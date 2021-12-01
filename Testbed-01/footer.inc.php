<footer class="text-center text-white">
    <!-- Grid container -->
    <div class="container p-4">
        <!-- Section: Social media -->
        <div class="mb-4">
            <!-- Facebook -->
            <a class="footer-btn" id="Facebooklink" rel="noopener" href="https://www.facebook.com/" role="button"><i class="bi bi-facebook"></i></a>

            <!-- Twitter -->
            <a class="footer-btn" id="Twitterlink" rel="noopener" href="https://twitter.com/?lang=en" role="button"><i class="bi bi-twitter"></i></a>

            <!-- Google -->
            <a class="footer-btn" id="Googlelink" href="https://www.google.com/" role="button"><i class="bi bi-google"></i></a>

            <!-- Instagram -->
            <a class="footer-btn" id="Instagramlink" rel="noopener" href="https://www.instagram.com/" role="button"><i class="bi bi-instagram"></i></a>

            <!-- Linkedin -->
            <a class="footer-btn" id="LinkedInlink" rel="noopener" href="https://sg.linkedin.com/" role="button"><i class="bi bi-linkedin"></i></a>

            <!-- Github -->
            <a class="footer-btn" id="Githublink" rel="noopener" href="https://github.com/rawsashimi1604/1004_Project" role="button"><i class="bi bi-github"></i></a>
        </div>
        <!-- Section: Social media -->

        <!-- Section: Form -->
        <div class="">
            <?php  
                include "email.php";

                // If submit button was pressed,
                if(isset($_POST['submitButton'])) {
                    $input = $_POST['inputText'];
                    
                    $subject = "Enjoy the greatest games at GamesDex";

                    $message = "
                        <!DOCTYPE html>
                            <html lang='en'>
                                <head>
                                    <title>Heyy</title>
                                </head>

                                <body>
                                    <style>

                                    </style>

                                    <main>
                                        <h1>Welcome to GamesDex!</h1>
                                        <p>We are a team of students from Singapore Institute of Technology currently studying ICT1004 (Web Systems and
                                            Techonologies). We hope that through this project, we would be able to apply what we have learnt in class
                                            and improve our Web Development skills.
                                        </p>
                                        <p>
                                            For our project, we decided to do a gaming ecommerce site as we were all passionate about video games.
                                        </p>
                                        <p>
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
                                        <p>Visit our <a href='https://github.com/rawsashimi1604/1004_Project/'>Github Page</a> to view our source code!
                                        </p>
                                    </main>
                                </body>

                        </html>
                    ";
                    // Send email
                    SendEmail($input, "Guest", 123, $message, $subject);
                }
            ?>
            <form action="#" method="post">
                <!--Grid row-->
                <div class="row d-lg-flex justify-content-between">
                    <!--Grid column-->
                    <div class="col-auto">
                        <p class="pt-2">
                            <strong>Sign up for our newsletter</strong>
                        </p>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-5 col-12 flex-fill">
                        <!-- Email input -->
                        <div class="form-outline form-white mb-4 footer-email">
                            <input type="email" id="form5Example21" class="form-control" placeholder="Email Address" name="inputText">
                            <label class="form-label" for="form5Example21"></label>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-auto footer-btn-container">
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-outline-light mb-4 footer-btn-subscribe" name="submitButton">
                            Subscribe
                        </button>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </form>
        </div>
        <!-- Section: Form -->

        <!-- Section: Text -->
        <div class="mb-4">
            <p>
                Welcome to GamesDex! This is a project made by Singapore Institute of Technology students for our final project for module ICT1004. We hope you enjoy!
            </p>
        </div>
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3 footer-copy">
        © 2021 Copyright:
        <a class="" href="https://github.com/rawsashimi1604/1004_Project">GamesDex.com</a>
    </div>
    <!-- Copyright -->
</footer>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>