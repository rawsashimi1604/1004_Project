<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html lang="EN">
    <?php
        include "head.inc.php"
    ?>
    
    <?php
        include "DB_getall.inc.php"
    ?>
    <!-- BODY -->
    <body>
        <?php
            include "nav.inc.php";
        ?>
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
                        <figure>
                            <img class="img-thumbnail" src="images/calico_small.jpg" alt="Calico" title="View larger image..." />
                            <figcaption>Call of Duty</figcaption>
                        </figure>
                        <?php
                            if ($result->num_rows > 0)
                            {
                                // Fetch all the results from our database
                                while($row = $result->fetch_assoc()) {
                                    echo '<figure><img class="img-thumbnail" src="'.$row["image"].'" /><figcaption>'.$row["name"].'</figcaption></figure><br />';
                                }
                            }
                            else
                            {
                                $errorMsgDB = "Looks like there's nothing here..";
                                $success = false;
                            }
                        ?>
                    </article>
                    <article class="col-sm">
                        <?php
                            if ($result->num_rows > 0)
                            {
                                // Fetch all the results from our database
                                while($row = $result->fetch_assoc()) {
                                    echo '<figure><img class="img-thumbnail" src="'.$row["image"].'" /><figcaption>'.$row["name"].'</figcaption></figure><br />';
                                }
                            }
                            else
                            {
                                $errorMsgDB = "Looks like there's nothing here..";
                                $success = false;
                            }
                            $stmt->close();
                            $conn->close();
                        ?>
                    </article>
                </div>
                
            </section>
        </main>
        
        <!-- FOOTER -->
        <?php
            include "footer.inc.php";
        ?>
    </body>

