<?php

	include_once("functions.php");
	
	require_login('ticket');

	$pageTitle = "Help With This Course";
	
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
            <h2>Contact The Helpdesk</h2>
            <p>Thanks for letting us know you're having a problem with a course. This is the course you're reporting:</p>
            
            <h3>What seems to be the problem?</h3>
            
            <form class="form-horizontal" action="ticket-send.php" method="post">
                <div class="form-group">
                    <label class="col-xs-3 control-label" for="description">Course</label>
                    <div class="col-xs-9 course-details-inline">
                        <?php if(isset($_GET['course'])) { ?>
                            <?php outputCoursePanel($courseDetails); ?>
                            <a id="chooseCourse" href="#"><i class="fa"></i>This isn't the course I'm having problems with</a>
                        <?php } else { ?>
                            <a id="chooseCourse" href="#" class="chooseCourseBlank"><i class="fa"></i>Choose a Course</a>
                        <?php } ?>
                        <div class="courseChooser">
                            <div class="radio"><label><input type="radio" name="courseid" value="none" /> I'm not having problems with any particular course</label></div>
                            <?php
                                
                                $userDetails = getUserDetailsByUsername($_SESSION['username']);
                                $userCourses = getCoursesForUser($userDetails->id);
                                
                                foreach($userCourses as $course) {
                                    $courseDetails = getCourseDetailsByID($course->course);
                                    echo '<div class="radio"><label><input type="radio" name="courseid" value="'.$courseDetails->id.'"';
                                    if (isset($_GET['course']) && ($course->course == $_GET['course'])) {
                                        echo 'checked="checked"';
                                    }
                                    echo ' /><span class="courseTitle">'.$courseDetails->fullname.'</span><span class="courseCode">'.$courseDetails->shortname.'</span><span class="courseID">'.$courseDetails->id.'</span></label></div></li>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label" for="description">Description</label>
                    <div class="col-xs-9">
                        <textarea class="form-control" rows="5" name="description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="hidden" name="useragent" id="useragent" value="<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>" />
                        <input type="hidden" name="guid" id="guid" value="<?php echo strtolower($_SESSION["username"]); ?>" />
                        <input type="hidden" name="name" id="name" value="<?php echo $_SESSION["fullname"]; ?>" />
                        <input type="hidden" name="email" id="email" value="<?php echo strtolower($_SESSION["email"]); ?>" />
                        <input type="hidden" name="security" id="security" value="<?php echo hash('sha512', '80)4<Y3!L0VV'.strtolower($_SESSION["username"]).$_SESSION["fullname"].strtolower($_SESSION["email"])); ?>" />
                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus-circle"></i> Create Helpdesk Ticket</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>
<script src="js/course-chooser.js"></script>

<?php include("footer.php"); ?>