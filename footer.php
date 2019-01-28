<div class="col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
    <div class="sidebar">
        <div class="user-panel">
            <?php if(isset($_SESSION['username'])) {
                echo '<img class="user-profile" src="img/avatar-blank.jpg" alt="" data-no-retina="true" />
                <p class="user-name">Alex Walker</p>
                <p class="user-action"><a href="logout.php"><i class="fa fa-lock"></i> Log out</a>';
            } else {
                echo '<img class="user-profile" src="img/avatar-blank.jpg" alt="" data-no-retina="true" />
                <p class="user-name">Guest User</p>
                <p class="user-action"><a href="login.php"><i class="fa fa-lock"></i> Log in</a>';
            } ?>
        </div>
        <h4>Featured</h4>
        <ul>
        <?php
        
            $popular = getFeaturedProblems();
            
            foreach($popular as $article) {
                outputArticleLi($article);
            }
            
        ?>
        </ul>
        <h4>Most Viewed</h4>
        <ul>
        <?php
        
            $popular = getCommonProblems();
            
            foreach($popular as $article) {
                outputArticleLi($article);
            }
            
        ?>
        </ul>
    </div>
</div>
</div></div></div>
			<footer>
	        <div class="container">
                <div class="row">
                    <div class="col-sm-6">
            			<h3 class="glasgow">University <em>of</em> Glasgow</h3>
            			<p class="address">Glasgow, G12 8QQ, Scotland</p>
            			<p class="phone">Tel +44 (0) 141 330 2000</p>
            			<p class="charity">The University of Glasgow is a registered Scottish charity: Registration Number SC004401</p>
		            </div>
                    <div class="col-sm-3 footer-links">
                        <h4>Information Services</h4>
                        <ul>
            				<li><a href="https://moodle2.gla.ac.uk">University of Glasgow Moodle</a></li>
            				<li><a href="https://classresponse.gla.ac.uk">Class Response</a></li>
            				<li><a href="https://hornbill.cent.gla.ac.uk/sw/selfservice/">IT Services Helpdesk</a></li>
            				<li><a href="https://www.gla.ac.uk/myglasgow/library/">Library</a></li>
			            </ul>
		            </div>
            		<div class="col-sm-3 footer-links">
            			<h4>Current Students</h4>
            			<ul>
            				<li><a href="http://www.gla.ac.uk/students/myglasgow/">MyGlasgow students</a></li>
            			</ul>
            			
            			<h4>Staff</h4>
            			<ul>
            				<li><a href="http://www.gla.ac.uk/myglasgow/staff/">MyGlasgow staff</a></li>
            			</ul>
            		</div>
	            </div>
            </div>
	    </footer>
	    <script type="text/javascript" src="js/retina.js"></script>
	</body>
</html>