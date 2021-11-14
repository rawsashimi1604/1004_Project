<?php
    require_once "DBController.php";
    $db_handle = new DBController();
    
    $search = $_POST["search"];
    $query = "SELECT * FROM apps_list WHERE name = '$search'";
    $result = $db_handle->runBaseQuery($query);
    if (!empty($result)){
        echo '<script>jQuery(document).ready(remove_rows(2));</script>';
        foreach ($result as $row){
        echo '<tr><td aria-controls="browsing_list" '
            . 'class="table tbody tr td"><a href="gamepage.php?id='.$row["appid"].'">'
            . '<img class="img-ss-list" src="'.$row["image"].'" />'
            .$row["name"].'</a></td><td>'.$row["developer"].'</td><td>'
            .$row["price"].'</td></tr>';
        }
    }
    else{
        echo '<script>jQuery(document).ready(remove_rows(2));</script>';
        echo '<tr><a>Looks like theres nothing here...</a></tr>';
    }
    

?>

