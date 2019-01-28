<?php
    
require_once('idiorm.php');

require_once('config.php');
    
if(php_sapi_name() !== 'cli') {
    session_set_cookie_params(time()+7200, '/', $cookieURL, false, true);
    session_start();
}

$syntaxOriginal = Array(
    '/\[\[blockpic:([^\]]*?)\]\]/',
    '/\[\[_([^_]*?)_\]\]/',
    '/\[\[\!([^_]*?)\!\]\]/',
    '/\[\[\#([0-9].?):([^_]*?)\]\]/',
    
);

$syntaxReplace = Array(
    '<div class="block-image"><img src="'.$baseURL.'media/${1}.jpg" alt="" class="img-responsive" /></div>',
    '<span class="term">${1}</span>',
    '<div class="alert alert-block alert-info">${1}</div>',
    '<a href="article.php?id=${1}">${2}</a>'
);

function require_login($dest='') {
	if(!isset($_SESSION['username'])) {
    	if($dest != '') {
		    header("location: login.php?dest=".$dest);
        } else {
            header("location: login.php");
        }
	}
}

function getLDAPConnection() {
    $ldapconfig['host'] = ' ldap://cytosine.campus.gla.ac.uk';
    $ldapconfig['port'] = '636';
    $ldapconfig['basedn'] = 'O=gla';
    $ldapconfig['authrealm'] = NULL;
    return $ldapconfig;
}

function ldap_authenticate($user, $password) {
    
    $ldapconfig = getLDAPConnection();
    
    if ($user != "" && $password != "") {
        $ds = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
        ldap_bind($ds, 'CN=LDAPInspector,ou=service,o=gla', '23jj12ad83px54ad');
        $r = ldap_search( $ds, $ldapconfig['basedn'], 'cn=' . $user);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        if ($r) {
            $result = ldap_get_entries( $ds, $r);
            if ($result[0]) {
                if (ldap_bind( $ds, $result[0]['dn'], $password) ) {
                	$_SESSION['username'] = $result[0]['cn'][0];
                	$_SESSION['email'] = $result[0]['mail'][0];
                	$_SESSION['firstname'] = $result[0]['givenname'][0];
                	$_SESSION['surname'] = $result[0]['sn'][0];
                	$_SESSION['fullname'] = $result[0]['givenname'][0] . ' ' . $result[0]['sn'][0];
					return 0; // Successful login
                } else {
                    return 2; // Account exists, incorrect password
                }
            } else {
                return 3; // Account doesn't exist
            }
        } else {
            return 4; // Active Directory isn't happy
        }
    }
    return 5; // Someone submitted a blank form
}

function getCourseDetailsByID($id) {
	$course = ORM::for_table('mdl_course', 'moodle')->where(Array('id'=>$id))->findOne();

	return $course;
}

function outputCoursePanel($course) {
    $categoryDetails = getCategoryDetailsByID($course->category);
    echo '<div class="island course-details"><div class="island-body">';
    echo '<h3 class="course-title">'.$course->fullname.'<span class="course-code">&ensp;('.$course->shortname.')</span></h3>';
    echo '<h4 class="course-category">'.$categoryDetails->name.'</h4>';
    if(!empty($course->description)) {
        echo '<p class="course-description">'.$course->description.'</p>';
    } else {
        echo '<p class="course-description">This course doesn\'t have a description.</p>';
    }
    echo '</div></div>';
}

function buildCategoryTree($category) {
    $categoryTree = Array();
    
    $categoryDetails = getCategoryDetails($category);
        
    while ($categoryDetails->id != 1) {
        $categoryTree[] = $categoryDetails;
        $categoryDetails = getCategoryDetails($categoryDetails->parent);
    }
    
    return (array_reverse($categoryTree));
}

function getCategoryDetails($category) {
    $cat = ORM::for_table('category', 'help')->where(Array('id'=>$category))->findOne();
        
    return $cat;
}

function getArticleDetails($category) {
    global $syntaxOriginal, $syntaxReplace;
    
    $article = ORM::for_table('issue', 'help')->where(Array('id'=>$category))->findOne();
    
    if($article != false) {
        $article->output = preg_replace($syntaxOriginal, $syntaxReplace, $article->body);
        return $article;
    }
    
    return false;
}

function getChildCategories($parent) {
    $children = ORM::for_table('category', 'help')->where(Array('parent'=>$parent))->findMany();
    
    $categories = Array();
    
    foreach($children as $kid) {
        $categories[] = $kid;
    }
    
    return $categories;
}

function getArticlesInCategory($category) {
    $articles = ORM::for_table('issue', 'help')->join('location', Array('issue.id', '=', 'location.issue'))>where(Array('issue.published'=>1,'location.category'=>$category));
        
    $articles = Array();
    
    foreach($articles as $article) {
        $articles[] = $article;
    }
    
    return $articles;
}

function outputCategoryBig($category) {
    echo '<div class="island"><div class="island-header"><h3><a href="category.php?id='.$category->id.'">'.$category->summary.'</a></h3></div>';
    echo '<div class="island-body">'.$category->body.'</div>';
    echo '<div class="island-footer"><a href="category.php?id='.$category->id.'">More Information</a></div></div>';
}

function outputCategorySmallBlock($category) {
    echo '<div class="island list-title-only"><div class="island-body"><a class="category-link" href="category.php?id='.$category->id.'"><div class="media"><div class="media-left"><img src="img/icon-'.$category->icon.'.png" alt="" data-no-retina="true" /></div><div class="media-body"><h3>'.$category->summary.'</h3></div></div></a></div></div>';
}

function outputCategoryBlock($category) {
    echo '<div class="island list-title-one-line-summary"><div class="island-body"><a class="category-link" href="category.php?id='.$category->id.'"><div class="media"><div class="media-left"><img src="img/icon-'.$category->icon.'.png" alt="" /></div><div class="media-body"><h3>'.$category->summary.'</h3>'.$category->body.'</div></div></a></div></div>';
}

function outputArticleSummary($article) {
    echo '<div class="island"><div class="island-header"><h3><a href="article.php?id='.$article->id.'">'.$article->title.'</a></h3></div>';
    echo '<div class="island-body">'.$article->summary.'</div>';
    echo '<div class="island-footer"><a class="more-info-link" href="article.php?id='.$article->id.'"><i class="fa fa-info-circle"></i> More Information</a></div></div>';
}

function outputArticleLi($article) {
    echo '<li><a href="article.php?id='.$article->id.'">'.$article->title.'</a></li>';
}

function getCommonProblems($limit=10) {
    $common = ORM::for_table('issue', 'help')->where(Array('published'=>1))->orderByDesc('views')->findMany($limit);
    
   foreach($common as $row) {
        $articles[] = $row;
    }
    
    return $articles;
}

function getSearchResults($term) { 
    saveSearchTerm($term, $_SERVER['REMOTE_ADDR']);
    
    $results = ORM::for_table('issue', 'help')->rawQuery('SELECT * FROM issue WHERE issue.published=1 AND MATCH (title, summary, body) AGAINST ("'.$term.'" IN BOOLEAN MODE)')->findMany();
    
    foreach($results as $row) {
        $articles[] = $row;
    }
    
    return $articles;
}

function getFeaturedProblems($limit=10) {
    $featured = ORM::for_table('issue', 'help')->where(Array('featured'=>1,'published'=>1))->orderByDesc(id)->findMany($limit);
    
    $articles = Array();
    
    foreach($featured as $row) {
        $articles[] = $row;
    }
    
    return $articles;
}

function saveRating($article, $ip, $feedback, $comment) {
    global $helpDB;
    
    $rating = ORM::for_table('rating', 'help')->create();
    $rating->article = $article;
    $rating->ip = $ip;
    $rating->feedback = $feedback;
    $rating->comment = $comment;
    $rating->date = prettifyDate(time(), 'ymd');
    $rating->save();
}

function faeWhenceICame() {
	header("Location: " . $_SERVER['HTTP_REFERER']);
}

function getUserDetailsByUsername($name) {
    $details = ORM::for_table('mdl_user', 'moodle')->where(Array('username'=>$name,'deleted'=>0))->findOne();

	if (isset($details->firstname)) {
		$details->fullname = $details->firstname . ' ' . $details->lastname;
		return $details;
	}
	
    return false;
}

function getCoursesForUser($user) {
    $courses = ORM::for_table('mdl_context', 'moodle')->rawQuery('select userid user, instanceid course, roleid role from mdl_context inner join mdl_role_assignments on mdl_role_assignments.contextid = mdl_context.id and contextlevel=50  where userid='.$user.' group by mdl_context.instanceid, mdl_role_assignments.roleid')->findMany();

	foreach($courses as $row) {
		$courses[] = $row;
	}
	return $courses;
}

function incrementViews($article) {
    $article = ORM::for_table('issue', 'help')->where(Array('id'=>$article))->findOne();
    $article->views = $article->views + 1;
    $article->save();
}

function saveSearchTerm($text, $ip) {
    $term = ORM::for_table('searchterms', 'help')->create();
    $term->searchtext = $text;
    $term->ip = $ip;
    $term->searchtime = date('Y-m-d H:i:s', time());
    $term->save();
}

function prettifyDate($date, $format="sdt") {
    switch ($format) {
	    case "sdt":
	    	return date("D j M Y, H:i", $date);
	    	break;
        case "sd":
	    	return date("l jS F Y", $date);
	    	break;
	    case "ssd":
	    	return date("j F Y", $date);
	    	break;
	    case "sst":
	    	return date("H:i", $date);
	    	break;
        case "sdt":
	    	return date("l jS F Y H:i", $date);
	    case 'ymd':
	        return date("Y-m-d", $date);
    }
}