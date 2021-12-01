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
        <main class="container text-light register-container">
            <h1 class="register-header">Register Here!</h1>
            <form action="doRegister.php" method="post">
                <!-- First name and last name -->
                <div class="row register-row">
                    <div class="col-md">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" aria-label="First name" id="fname" name="fname">
                    </div>
                    <div class="col-md">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" aria-label="Last name" id="lname" name="lname">
                    </div>
                </div>

                <!-- Password and confirm password -->
                <div class="row register-row">
                    <div class="col-md">
                        <label for="pwd" class="form-label">Password</label>
                        <input type="password" class="form-control" aria-label="First name" id="pwd" name="pwd" onkeyup="checkpw();">
                    </div>
                    <div class="col-md">
                        <label for="cfm_pwd" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" aria-label="Last name" id="cfm_pwd" name="cfm_pwd" onkeyup="checkpw();">
                        <span id='errMsg'></span>
                    </div>
                </div>

                <!-- Date of birth and email -->
                <div class="row register-row">
                    <div class="col-md register-dob">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="date" class="form-control" name="dateofbirth" id="dateofbirth">
                    </div>
                    <div class="col-md">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="form-check register-check">
                    <input type="checkbox" class="form-check-input" id="tos">
                    <label class="form-check-label" for="tos">I Agree to Terms of Service</label>
                </div>
                <button type="submit" class="btn btn-light register-btn">Register</button>
            </form>
        </main>
        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>