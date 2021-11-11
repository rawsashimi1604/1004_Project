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
    </header>

    <!-- MAIN -->
    <main class="container mt-5">
        <section id="featured">
            <h2 class="text-center">Featured Products</h2>
            <p class="text-center">Checkout new and popular products</p>
            <div class="row">
                <article class="col-sm">
                    <?php
                    if ($result->num_rows > 0) {
                        // Fetch all the results from our database
                        while ($row = $result->fetch_assoc()) {
                            echo '<figure><img class="img-thumbnail" src="' . $row["image"] . '" /><figcaption>' . $row["name"] . '</figcaption></figure><br />';
                        }
                    } else {
                        $errorMsgDB = "Looks like there's nothing here..";
                        $success = false;
                    }
                    ?>
                </article>
                <article class="col-sm">
                    <?php
                    echo '<div class="container"><row class="row-cols-2">';
                    if ($result->num_rows > 0) {
                        // Fetch all the results from our database
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col"><figure><img class="img-thumbnail" src="' . $row["image"] . '" /><figcaption>' . $row["name"] . '</figcaption></figure></div>';
                        }
                    } else {
                        $errorMsgDB = "Looks like there's nothing here..";
                        $success = false;
                    }
                    echo "</row></div>";
                    $stmt->close();
                    $conn->close();

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