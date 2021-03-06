<!DOCTYPE html>
<html lang="EN">

<!-- HEAD -->
<head>
    <?php
        include "head.inc.php";
        header("Location: http://34.126.181.163/project/index.php");
    ?>
    <title>GamesDex: Login</title>
    <meta name="Login Page" content="width=device-width, initial-scale=1.0">
</head>
    
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        
        <!-- MAIN -->
        <main class="container text-light">
            <h1 class="login-header">Login Here!</h1>
            <form action="doLogin.php" method="post">
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
        </main>
        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>