<?php
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once("functions.php");
    
    saveRating($_POST['article'], $_SERVER['REMOTE_ADDR'], $_POST['rating'], $_POST['feedback']);
    
    faeWhenceICame();
    
?>