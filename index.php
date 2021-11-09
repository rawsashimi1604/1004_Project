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
                    <figure>
                        <img class="img-thumbnail" src="images/calico_small.jpg" alt="Calico" title="View larger image..." />
                        <figcaption>Call of Duty</figcaption>
                    </figure>
                </div>
            </section>
        </main>
        
        <!-- FOOTER -->
        <?php
            include "footer.inc.php";
        ?>
    </body>

