<?php

	include_once("functions.php");
	
	require_login();

	$pageTitle = "Helpdesk Request Sent";
	
	require("header.php");
	
	if(isset($_GET['course'])) {
    	$courseDetails = getCourseDetailsByID($_GET['course']);
    }
	

?>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    <ul class="breadcrumb">
    	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
    	<li class="last"><a href=""><i class="fa fa-exclamation-circle"></i> Report A Problem With This Course</a></li>
    	<li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>
    
    <div class="island">
        <div class="island-body island-main">
            <h2>Thanks for contacting the Helpdesk</h2>
            <p>Thanks for letting us know you're having a problem with a course. This is the course you're reporting:</p>
            
            <h3>What seems to be the problem?</h3>
            
            <p>Your message has been sent, and you should receive an email from us soon.</p>
            
            <h4>How can I check on the progress of my Helpdesk request?</h4>
            
            <p>You can check the status of your helpdesk request by using <a href="http://hornbill.cent.gla.ac.uk/sw/selfservice/">SupportWorks Self-Service</a>. Simply log in with your GUID.</p>
        </div>
    </div>
    
</div>
<script src="js/course-chooser.js"></script>

<?php include("footer.php"); ?>