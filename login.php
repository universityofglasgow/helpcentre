<?php

	include_once("functions.php");
	
	if(isset($_POST['username'])) {
    	$loginStatus = ldap_authenticate($_POST['username'], $_POST['password']);
        if($loginStatus === 0) {
    	    switch($_POST['destination']) {
                case 'ticket':
                    $dest = 'ticket.php';
        	     default:
        	        if((substr($_POST['destination'], 0, 8) == 'article-') && is_integer(substr($_POST['destination'], 8))) {
            	        $dest = 'article.php?id='.substr($_POST['destination'], 8);
        	        } else {
        	            $dest = 'index.php';
                    }
    	     }
		     header("location: ".$dest);
		     die();
	     }
	}

    $pageTitle = "Log in to Help Centre";
	
	require("header.php");
	

?>

<div class="col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
    
    <ul class="breadcrumb">
    	<li class="last"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="help-now"><a href="ticket.php"><i class="fa fa-question-circle"></i> Contact the Helpdesk</a></li>
    </ul>    
    <div class="row login-stuff">
    <div class="col-sm-7 col-md-8">
        <div class="login-text hidden-xs">
            <div class="island island-main">
                <h2>Log in to Help Centre</h2>
                <p>Most of Help Centre is open to everyone without logging in.</p>
                <p>But if you log in to Help Centre, you can:</p>
                <ul>
                    <li><strong>Give us feedback on Help Centre's articles</strong> &ndash; tell us if they were helpful or not, and give us comments on how we can improve them.</li>
                    <li><strong>Contact the IT Helpdesk</strong> &ndash; just tell us what the problem is and press 'Send'. Help Centre automatically adds your name and email address to the ticket, so the IT Services team can contact you.</li>
                    <li><strong>Tell us which course you're having a problem with</strong> &ndash; no need to find out the course's ID number, or copy and paste a link. Help Centre knows which Moodle courses you belong to, so just choose one from the list. And if you click the 'Help Centre' link from a Moodle course, we'll automatically fill it in.</li>
                </ul>
            </div>
        </div>
    </div>
	<div class="col-sm-5 col-md-4">
		<form action="login.php" method="post" class="login-form">
			<?php if(isset($loginStatus) && $loginStatus !== 0) {
				echo '<div class="alert alert-danger">';
				switch($loginStatus) {
    				case 1:
    				    echo 'Your account doesn\'t have access to Inspector. Please <a href="http://www.gla.ac.uk/services/it/helpdesk/webform/">open a Helpdesk ticket</a> if you believe this is an error.';
    				    break;
    				case 2:
    				case 3:
    				    echo 'Incorrect GUID or password.';
    				    break;
    				case 4:
    				    echo 'Inspector couldn\'t check your username and password because something broke. Please try again later, or <a href="http://www.gla.ac.uk/services/it/helpdesk/webform/">open a Helpdesk ticket</a>.';
    				    break;
    				case 5:
    				    echo 'Yeah, I\'m gonna need to see some ID.';
    				    break;
    				default:
    				    echo 'Error: ';
    				    var_dump($loginStatus);
                }
				echo '</div>';
			} ?>
			<input type="text" class="form-control" name="username" id="username" placeholder="Username" autofocus="autofocus" />
			<input type="password" class="form-control" name="password" id="password" placeholder="Password" />
			<?php if(isset($_GET['dest'])) { echo '<input type="hidden" name="destination" id="destination" value="'.$_GET['dest'].'" />'; } ?>
			<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-lock"></i> Log in with your GUID</button>
			<a class="btn btn-block btn-link reset-password" href="https://password.gla.ac.uk">Forgot your password?</a>
		</form>
	</div>
</div>
</div>
<?php include("footer.php"); ?>