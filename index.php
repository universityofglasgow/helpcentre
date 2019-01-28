<?php

	include_once("functions.php");
	
	$categoryDetails = getCategoryDetails(1);

	$pageTitle = $categoryDetails->title;
	
	require("header.php");
	

?>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    <ul class="breadcrumb">
    	<li class="last"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
    	 <li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>
    
    <div class="island">
        <div class="island-body island-main">
    
            <h2><?php echo $categoryDetails->summary; ?></h2>
            
            <div class="content-box"><?php echo $categoryDetails->body; ?></div>
            
                <?php
                
                    $childCategories = getChildCategories(1);
                    
                    foreach($childCategories as $category) {
                        outputCategoryBlock($category);
                    }
                    
                ?>
            
        </div>
        
    </div>
    
</div>

<?php include("footer.php"); ?>