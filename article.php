<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

	include_once("functions.php");
	
	$articleDetails = getArticleDetails($_GET['id']);
	
	if($articleDetails === false) {
    	$articleDetails = new stdClass();
    	$articleDetails->id = '-1';
    	$articleDetails->title = 'This article couldn\'t be found';
    	$articleDetails->shorttitle = $articleDetails->title;
    	$articleDetails->body = '<p>Whoops - it looks like you\'ve found an article that doesn\'t exist in Help Centre. Maybe we\'ve been tidying up.</p><p>You can use the search box above to find what you\'re looking for.</p>';
    	$articleDetails->output = $articleDetails->body;
	}

	$pageTitle = $articleDetails->title;
	
	require("header.php");
	

?>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    
    <ul class="breadcrumb">
    	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="last"><a href="article.php?id=<?php echo $articleDetails->id; ?>"><i class="fa fa-question-circle"></i> <?php echo $articleDetails->shorttitle; ?></a></li>
        <li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>
    
    <div class="island island-main">
    
        <h2><?php echo $articleDetails->title; ?></h2>
        
        <div class="article">
        <?php
            
            echo $articleDetails->output;
            
        ?>
        </div>
    </div>
    
    <?php if($articleDetails->id != "-1") { ?>
    
    <form method="post" action="rate.php">
        <div class="island rate-form">
            <div class="island-header"><h3>Was this article helpful?</h3></div>
            <div class="island-body">
                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <a class="rate-badge" data-value="helpful">
                            <img class="face" src="img/rate-thumbs-up.png" alt="image of a confused face" data-no-retina="true" />
                            <span>Yes, it was</span>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a class="rate-badge" data-value="unhelpful">
                            <img class="face" src="img/rate-thumbs-down.png" alt="image of an unhappy face" data-no-retina="true" />
                            <span>No, it wasn't</span>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-6">
                            <input type="hidden" id="rating" name="rating" value="blank" />
                            <input type="hidden" id="article" name="article" value="<?php echo $articleDetails->id; ?>" />
                            <textarea id="feedback" name="feedback" class="form-control" placeholder="Do you have any comments that might help us improve Help Centre?"></textarea>
                            <button class="btn btn-block btn-success" type="submit">Tell us how you feel</a>
                    </div>
                </div>
            </div>
            <div class="island-footer">Your answer is anonymous and will only be used to improve the Help Centre.</div>
            <script src="js/rate.js"></script>
        </div>
    </form>
    
    <?php } ?>
    
    
</div>
<script>
function updateViews() { $.get("viewed.php", {id: <?php echo $articleDetails->id; ?>}); } setTimeout(updateViews, 30000);
</script>
<?php include("footer.php"); ?>