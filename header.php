<!doctype html>
<html>
	<head>
    	
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	
		<title>Moodle Help Centre - <?php echo $pageTitle; ?></title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/font-awesome.css" />
		<link rel="stylesheet" href="css/base.css" />
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>

	</head>
	<body>
		<div class="page-header">
    		<div class="container">
        		<div class="row">
                    <div class="hidden-xs col-sm-4 col-md-3">
                        <h1 class="logo">Moodle Help Centre</h1>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <form action="search.php" method="get" class="form-horizontal help-search-form">
                			<div class="input-group">
                				<input type="text" name="q" id="q" value="<?php if(isset($_GET['q'])) { echo $_GET['q']; } ?>"class="form-control courses-autocomplete" />
                				<span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-search"></i><span class="hidden-xs-fdown"> Search</span></button></span>
                			</div>
                		</form>
                    </div>
        		</div>
    		</div>
		</div>
		<div class="container">
			
			<div id="panel">
				<div class="row">