<!DOCTYPE html>

<html lang="en">
    <!-- HEAD SETUP -->
    <?php
        include "head.inc.php"
    ?>
    
    <!-- MySQL Database Connect -->
    <?php
        include "DB_getall.inc.php";
    ?>
    

    
    <!-- BODY -->
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <!-- HEADER -->
        <header class="jumbotron text-center bg-dark">
            <h1 class="display-4 text-light">Browse</h1>
            <h2 class="text-light">Look around! Fancy anything?</h2>
        </header>
        
        <!-- MAIN -->
        <main class="container">
            <section id="browsing_section">
                <div class="search-box">
                    <form method="post">
                        <label><b>Search:</b></label>
                        <input  type="text" 
                                name="search" 
                                autocomplete="off" 
                                class="form-control input-sm" 
                                placeholder="Enter search term" 
                                aria-controls="browsing_list">
                        <input id="browse_search_button" type="submit" name="submit">
                    </form>
                </div>
                </div>
                <table style="width:100%" id="browsing_list" class="table dataTable no-footer" role="grid">
                    <tr>
                        <th>Game</th>
                        <th>Developer</th>
                        <th>Cost</th>
                    </tr>
                    <?php
                        if ($result->num_rows > 0)
                        {
                            // Fetch all the results from our database
                            while($row = $result->fetch_assoc()) {
                                echo '<tr><td aria-controls="browsing_list" '
                                . 'class="table tbody tr td"><a href="">'
                                . '<img class="img-ss-list" '
                                . 'src="'.$row["image"].'" />'.$row["name"].'</a>'
                                . '</td><td>'.$row["developer"].'</td><td>'
                                .$row["publisher"].'</td></tr>';
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
                 </table>
            </section>
        </main>
        <?php
            include "footer.inc.php";
        ?>
    </body>
</html>

