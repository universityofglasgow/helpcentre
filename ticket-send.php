<?php
    
    require_once("functions.php");
    
    require_login();
    
    if($_POST['security'] !== hash('sha512', '80)4<Y3!L0VV'.strtolower($_POST["guid"]).$_POST["name"].strtolower($_POST["email"]))) {
        echo('<p>Invalid Security Token!!!</p>');
    }
    
    $ticket= [
        'customer-username'     => $_POST['guid'],
        'customer-name'         => $_POST['name'],
        'customer-email'        => $_POST['email'],
        'problem-text'          => $_POST['description'],
        'problem-course-id'     => 'none',
        'problem-course-code'   => 'none',
        'problem-course-title'  => 'none',
        'user-agent'            => $_POST['useragent']
    ];
    
    if(isset($_POST['courseid']) && !empty($_POST['courseid'])) {
        $ticket['problem-course-id'] = $_POST['courseid'];
    }
    
    if($ticket['problem-course-id'] !== 'none') {
        $courseDetails = getCourseDetailsByID($ticket['problem-course-id']);
     
        $ticket['problem-course-code'] = $courseDetails->shortname;
        $ticket['problem-course-title'] = $courseDetails->fullname; 
    }
  
    $emailText = 'Hello,

'.$ticket['customer-name'].' has submitted a new helpdesk ticket using Moodle Help Centre.

Customer Name: '.$ticket['customer-name'].'
Customer GUID: '.$ticket['customer-username'].'
Customer Email: '.$ticket['customer-email'].'

Description of Problem:

'.$ticket['problem-text'].'

';

if(isset($ticket['problem-course-code'])) {
    $emailText .= 'Problem Course: http://moodle2.gla.ac.uk/course/view.php?id='.$ticket['problem-course-id'].'
Problem Course ID: '.$ticket['problem-course-id'].'
Problem Course Code: '.$ticket['problem-course-code'].'    
Problem Course Title: '.$ticket['problem-course-title'].'

';
}

    $emailHeaders = 'From: helpcentre@moodleinspector.gla.ac.uk' . PHP_EOL .
    'Reply-To: '.$ticket['customer-email'] . PHP_EOL .
    'X-Mailer: PHP/' . phpversion();
 
    $emailText .= 'User Agent: '.$ticket['user-agent'];
     
    $emailWrapped = wordwrap($emailText, 70);
    
    mail('ithelpdesk@glasgow.ac.uk', 'Moodle Helpdesk Request from '.$ticket['customer-name'], $emailWrapped, $emailHeaders);
    
    header('location: ticket-sent.php');
?>