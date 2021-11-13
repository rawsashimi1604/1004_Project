<!DOCTYPE html>
<?php 
session_start();

require_once "authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ./index.php");
}

$userId = $_SESSION['member_id'];

/*
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>alert('Debug Objects: " . $output . "' );</script>";
}
debug_to_console($userId);
*/
?>

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
        <main class="container text-light">
            <header>
                <h1 class="account-header">Your Account Details</h1>
            </header>


            <!-- Account statistics -->
            <div class="container account-container">
                <h2>Account statistics</h2>
                <hr>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod ad placeat nesciunt esse voluptatum nemo
                    ut! Laboriosam fugiat molestias, impedit officiis quasi culpa quam consequatur optio veniam eius sed
                    nulla, magnam beatae itaque amet in nobis repellat reiciendis quibusdam aliquam vel quos quis? Quisquam
                    perferendis incidunt libero voluptatum id provident?
                </p>
            </div>


            <!-- Update password -->
            <div class="container account-container account-update-pw">
                <h2>Update Password</h2>
                <hr>
                <form action="#">
                    <div class="row register-row">
                        <div class="col">
                            <label for="old_pwd" class="form-label">Your current password</label>
                            <input type="password" class="form-control" aria-label="Old Password" id="old_pwd" name="old_pwd">
                        </div>
                        <div class="col">
                            <label for="new_pwd" class="form-label">Your new password</label>
                            <input type="password" class="form-control" aria-label="New Password" id="new_pwd" name="new_pwd">
                        </div>
                        <div class="col">
                            <label for="confirm_pwd" class="form-label">Confirm new password</label>
                            <input type="password" class="form-control" aria-label="Confirm New Password" id="confirm_pwd" name="cfm_pwd">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light account-btn">Change password</button>
                </form>
            </div>

            <!-- Account statistics -->
            <div class="container account-container">
                <h2>Account statistics</h2>
                <hr>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod ad placeat nesciunt esse voluptatum nemo
                    ut! Laboriosam fugiat molestias, impedit officiis quasi culpa quam consequatur optio veniam eius sed
                    nulla, magnam beatae itaque amet in nobis repellat reiciendis quibusdam aliquam vel quos quis? Quisquam
                    perferendis incidunt libero voluptatum id provident?
                </p>
            </div>

        </main>
        <!-- Update Password -->


        <!-- FOOTER -->
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
