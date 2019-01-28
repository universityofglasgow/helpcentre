<?php
    
    require_once("functions.php");
    
    incrementViews($_GET['id']);
    echo 'Updated article '.$_GET['id'];
        
?>