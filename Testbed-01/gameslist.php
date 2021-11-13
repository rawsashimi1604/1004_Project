<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html lang="EN">
    <!-- HEAD SETUP -->
    <?php
        include "head.inc.php";
        session_start();
    ?>
    
    <!-- MySQL Database Connect get ALL -->
    <?php
        include "DB_getall.inc.php";
    ?>
    

    
    <!-- BODY -->
    <body class="bg-dark">
        <?php
            include "nav.inc.php";
        ?>
        <!-- HEADER -->
        <header class="jumbotron text-center bg-dark">
            <h1 class="display-4 text-light">Browse</h1>
            <h2 class="text-light">Look around! Fancy anything?</h2>
        </header>
        
        <!-- MAIN -->
        <main class="container gamelist-container">
            <section id="browsing_section">
                <div class="search-box" data-aos="zoom-in-left" data-aos-duration="1000">
                    <form method="post">
                        <div class="gamelist-search-main">
                            <span>Search Our Catalogue</span>
                        </div>

                        <div class="gamelist-inputs">
                            <input type="text" name="search" autocomplete="off" class="form-control input-sm"
                                placeholder="Enter Game Title" aria-controls="browsing_list">
                            <input id="browse_search_button" type="submit" name="submit" value="Search">
                        </div>
                    </form>
                </div>

                <div class="container">
                    <div class="gamelist-games" data-aos="fade-right" data-aos-duration="500">
                        <?php
                            if ($result->num_rows > 0)
                            {
                                // Fetch all the results from our database
                                while($row = $result->fetch_assoc()) {
                                    echo '<div class="gamelist-game"><div aria-controls="browsing_list" '
                                    . 'class="gamelist-title"><a href="gamepage.php?id='.$row["appid"].'">'
                                    . '<img class="img-ss-list" src="'.$row["image"].'" />' ."<span>"
                                    .$row["name"].'</span></a></div><span class="gamelist-dev">'.$row["developer"].'</span><span class="gamelist-price">'
                                    .$row["price"].'</span></div>';
                                }
                            }
                            else
                            {
                                $errorMsgDB = "Looks like there's nothing here..";
                                $success = false;
                                alert($errorMsgDB);
                            }
                            $stmt->close();
                            $conn->close();
                            
                            if ($_SERVER["REQUEST_METHOD"] == "POST")
                            {
                                echo '<script>jQuery(document).ready(remove_rows());</script>';
                                include "DB_search.inc.php";
                            }
                        ?>
                    </div>
                </div>
                
            </section>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>

