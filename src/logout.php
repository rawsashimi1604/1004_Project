<?php
session_start();

require "Util.php";
$util = new Util();
    
    if (isset($_POST['action'])){
        //Clear Session
        $_SESSION["member_id"] = "";
        session_destroy();

        // clear cookies
        $util->clearAuthCookie();
        header("Refresh:0");
        header("Location: index.php");
    }
?>