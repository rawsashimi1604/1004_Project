<?php
    require_once "DBController.php";
    $db_handle = new DBController();
    
    $search = $_POST["search"];
    $query = "SELECT * FROM apps_list WHERE name LIKE '%{$search}%'";
    $result = $db_handle->runBaseQuery($query);
    if (!empty($result)){
        echo '<script>jQuery(document).ready(remove_rows('.count($result).'));</script>';
        foreach ($result as $row){
        echo '<tr class="gameslist-rows" onclick="window.location=\'gamepage.php?id=' . $row["appid"] . '\';">
                                <td valign="middle" scope="row">
                                    <img class="gameslist-thumbnail" src="' . $row["image"] . '" />
                                </td>
                                <td valign="middle">' . $row["name"] . '</td>
                                <td valign="middle" class="gameslist-desc">' . $row["description"] . '</td>
                                <td valign="middle">' . $row["developer"] . '</td>
                                <td valign="middle">' . $row["price"] . '</td>
                            </tr>';
        } 
    }
    else{
        echo '<script>jQuery(document).ready(remove_rows(2));</script>';
        echo '<tr><a>Looks like theres nothing here...</a></tr>';
    }
    

?>

