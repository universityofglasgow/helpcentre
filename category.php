<?php

	include_once("functions.php");
	
	$categoryDetails = getCategoryDetails($_GET['id']);

	$pageTitle = $categoryDetails->title;
	
	require("header.php");
	

?>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    <ul class="breadcrumb">
    	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
    	<?php
        	
        $categoryTree = buildCategoryTree($categoryDetails->id);
        
        foreach($categoryTree as $treeCat) {
            echo '<li';
            if ($treeCat->id == $categoryDetails->id) {
                echo ' class="last"';
            }
            echo '><a href="category.php?id='.$treeCat->id.'"><i class="fa fa-bars"></i> '.$treeCat->title.'</a></li>';
        }
        	
        ?>
        <li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>
    
    <div class="island">
        <div class="island-body island-main">
    
            <h2><?php echo $categoryDetails->summary; ?></h2>
            
            
            
            <div class="content-box"><?php echo $categoryDetails->body; ?></div>
            
            <?php
                
                $childCategories = getChildCategories($categoryDetails->id);
                
                if(count($childCategories !== 0)) {    
                    
                    foreach($childCategories as $category) {
                        outputCategoryBlock($category);
                    }
                    
                }
                
                $articles = getArticlesInCategory($categoryDetails->id);
                
                if(count($articles !== 0)) {
                    
                    foreach($articles as $article) {
                        outputArticleSummary($article);
                    }
                
                }
                
            ?>
            
        </div>
        
    </div>
    
</div>

<?php include("footer.php"); ?>