<?php

	include_once("functions.php");
	
	$categoryDetails = getCategoryDetails(1);

	$pageTitle = 'Search Results For "'.$_GET['q'].'"';
	
	require("header.php");
	

?>
<div class="col-xs-12">
</div>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    <ul class="breadcrumb">
    	<li class="last"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
    	<li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>
    
    <h2>Search Results for <?php echo $_GET['q']; ?></h2>
    
        <?php
        
            $matches = getSearchResults($_GET['q']);
            
            foreach($matches as $article) {
                outputArticleSummary($article);
            }
            
        ?>
    
</div>

<?php include("footer.php"); ?>