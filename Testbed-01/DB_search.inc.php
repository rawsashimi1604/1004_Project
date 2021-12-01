<?php
    /*
     * Database Search Include function
     * To be used on gameslist for searching based on name, genre, or category
     */
    $genresearch = ($_GET["genre_id"]);
    $categorysearch = ($_GET["category_id"]);
    $namesearch = strtolower($_GET["search"]);
    
    if (!empty($genresearch)){
        $query = "SELECT * FROM apps_list WHERE genre LIKE '$genresearch'";
    }
    else if (!empty($categorysearch)){
        $query = "SELECT * FROM apps_list WHERE category LIKE '$categorysearch' OR category2 LIKE '$categorysearch'";
    }
    else{
        $query = "SELECT * FROM apps_list WHERE lower(name) LIKE '%{$namesearch}%'";
    }
    
    $result = $db_handle->runBaseQuery($query);
    if (!empty($result)){
        echo '<script>jQuery(document).ready(remove_rows('.count($result).'));</script>';
        foreach ($result as $row){
        echo '<tr class="gameslist-rows" onclick="window.location=\'gamepage.php?id=' . $row["appid"] . '\';">
                                <td class="align-items-center">
                                    <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                </td>
                                <td class="align-items-center">' . $row["name"] . '</td>
                                <td class="align-items-center gameslist-desc mobile-none">' . $row["description"] . '</td>
                                <td class="align-items-center">' . $row["developer"] . '</td>
                                <td class="align-items-center">' . $row["price"] . '</td>
                            </tr>';
        } 
    }
    else{
        echo '<script>jQuery(document).ready(remove_rows(1));</script>';
        echo '<tr class="gameslist-rows"><td>Looks like theres nothing here...</td></tr>';
    }
    

?>

