<?php
/**
 * The academic default builder page displayes the school provided default academic schedule as well as the program approved elective course list.
 *
 * Requirments:
 *  1) For the most part of the screen, an animated academic calendar schedule should be displayed.
 *  2) The academic schedule should clearly tells user which semester or term is presenting.
 *  3) For the rest part of the screen, the program approved elective course list should be displayed.
 *
 * php Steps:
 *  1) Start session.
 *  2) If not logged in, redirect to login page.
 *
 * @version     1.0
 * @link        http://15.223.123.122/vsbp/Code/academicBuilder_Default.php
 * @author      Priscilla Chua (sid: 200363504) <****@uregina.ca>
 * @param       {boolean}       $_SESSION["loggedin"]       Status of logged-in or not: true/false
 * @param       {integer}       $_SESSION["sid"]            Student id
 * @param       {string}        $_SESSION["name"]           Student name
 * @param       {string}        $_SESSION["major"]          Student major
 * @param       {string}        $_SESSION["password"]       Student password
 */

session_start(); // Initialize the session

// Check if user is inactive for a time period
if (isset($_SESSION["lastActTime"])) {
    $inactive = 600; // 1 min in seconds
    $session_life = time() - $_SESSION["lastActTime"];
    if($session_life > $inactive) {
        header("location: Model/logout.php");
        exit();
    }
    $_SESSION["lastActTime"] = time();
    // echo $_SESSION["lastActTime"];
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}
?>



<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- icon library -->
    <script src='https://kit.fontawesome.com/b95f8ace21.js' crossorigin='anonymous'></script>
    <!-- icon library -->

    <title>VSB_Plus : Academic</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="team_vsbp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/academicBuilder_Default.css">

    <script type="text/javascript" src="js/academicDefault.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		var sid = "<?php echo $_SESSION["sid"]; ?>";
        	var pas = "<?php echo $_SESSION["password"]; ?>";
        	var major = "<?php echo $_SESSION["major"]; ?>";
		
		var isMobile = window.matchMedia('(max-width: 1080px)').matches;
        $(document).ready(function() {
            if (isMobile) $(".menu-icon").click();
        });
	</script>
</head>
<style>

</style>

<body>
    <header>
        <a href="http://15.223.123.122/vsbp/Code/academicBuilder_Main.php"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="nav-right">
            <a class="nav-active" id="usertext" onclick="toogleDisplay('addon-menu')"><?php echo htmlspecialchars(
                $_SESSION["name"]
            ); ?></a>
            <div class="hidden" id="addon-menu">
                <a href="http://15.223.123.122/tp/public/index.php/login"><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
                <a href="Model/logout.php">Logout</a>
            </div>
        </div>
        <div class="menu-icon" onclick="menuFunc1(this); menuFunc2('menu-list');">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <div class="menu-list">
            <div class="session-required nav-active dropdown">
                <button class="dropbtn" onclick="toogleDisplay('dropdown-content')">Academic Schedule Builder &#9661;</button>
                <div id="dropdown-content" class="dropdown-content hidden">
                    <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                    <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                    <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
                </div>
            </div>
            <a class="session-required" href="semesterBuilder_v2.php">Semester Schedule Builder</a>
            <a class="" href="courseDB.php">Course List Database</a>
        </nav>
    </nav>
    
	<div class="container">
		<section id = "block" class = "terms">
			<div id="title">
				
				<h2>Default Schedule (<abbr id="major" title=""></abbr>)</h2>
			</div>
			<div id = "autoscroll">
				<div class = "termGrid" id = "term1">
					<div class = "tittle" style = "grid-area: title;"><h2>Term1:</h2></div>
					<div class = "course_cards" onclick="courseSelect(event)"></div>
					<div class = "course_cards" onclick="courseSelect(event)"></div>
					<div class = "course_cards" onclick="courseSelect(event)"></div>
					<div class = "course_cards" onclick="courseSelect(event)"></div>
					<div class = "course_cards" onclick="courseSelect(event)">
						<!--<h3>?php echo $_POST["course_ID"]; ?></h3>-->
						
					   <!-- <i class='fas fa-circle' style='font-size:24px;color:red'></i>  
						<i class='fas fa-circle' style='font-size:24px;color:red'></i>
						<i class='fas fa-circle' style='font-size:24px;color:red'></i>
						<i class='fas fa-circle' style='font-size:24px;color:red'></i> -->
					</div>
					
					<!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
						&nbsp;
						<button class="right_arrow"><i class='fas fa-angle-right'></i></button>
					</div>-->   
				</div>
				<div class = "termGrid" id ="term2">
					<div class = "tittle" style = "grid-area: title;"><h2>Term2:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>

					<!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
						&nbsp;
						<button class="right_arrow"><i class='fas fa-angle-right'></i></button>  
					</div>-->
				</div>
				<div class = "termGrid" id ="term3">
					<div class = "tittle" style = "grid-area: title;"><h2>Term3:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>

					<!--<div class = "arrows"><button class="right_arrow"><i class='fas fa-angle-left'></i></button>
						&nbsp;
						<button class="right_arrow"><i class='fas fa-angle-right'></i></button>
					</div>-->
				</div>
				<div class = "termGrid" id ="term4">
					<div class = "tittle" style = "grid-area: title;"><h2>Term4:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term5">
					<div class = "tittle" style = "grid-area: title;"><h2>Term5:</h2></div>
					<div class = "course_cards">
					<!--<h3>CS215</h3>
						<p>Title:</p>-->
					</div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term6">
					<div class = "tittle" style = "grid-area: title;"><h2>Term6:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term7">
					<div class = "tittle" style = "grid-area: title;"><h2>Term7:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term8">
					<div class = "tittle" style = "grid-area: title;"><h2>Term8:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term9">
					<div class = "tittle" style = "grid-area: title;"><h2>Term9:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
			</div>
		</section>

		<section id ="block" class = "tags_courses">  
			<h2>Approved Electives</h2>
			
			<div class = "electives_course">
				<div id = "electives1">
					<h3></h3></div>

				<div class = "course_tag_electives ense_course_tag" id = "approvedCourse">
					<p id = "a0" onclick="courseSelect(event)"></p>
					<p id = "a1" onclick="courseSelect(event)"></p>
					<p id = "a2" onclick="courseSelect(event)"></p>
					<p id = "a3" onclick="courseSelect(event)"></p>

					<p id = "a4" onclick="courseSelect(event)"></p>
					<p id = "a5" onclick="courseSelect(event)"></p>
					<p id = "a6" onclick="courseSelect(event)"></p>
					<p id = "a7" onclick="courseSelect(event)"></p>
					
					<p id = "a8" onclick="courseSelect(event)"></p>
					<p id = "a9" onclick="courseSelect(event)"></p>
					<p id = "a10" onclick="courseSelect(event)"></p>
					<p id = "a11" onclick="courseSelect(event)"></p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="approvedLeft"  onclick = "aLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="approvedRight" onclick = "aRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>
			
			<div class = "electives_course">
				<div id = "electives2">
					<h3></h3></div>

				<div class = "course_tag_electives ense_course_tag" id = "approvedCourse">
					<p id = "b0" onclick="courseSelect(event)"></p>
					<p id = "b1" onclick="courseSelect(event)"></p>
					<p id = "b2" onclick="courseSelect(event)"></p>
					<p id = "b3" onclick="courseSelect(event)"></p>

					<p id = "b4" onclick="courseSelect(event)"></p>
					<p id = "b5" onclick="courseSelect(event)"></p>
					<p id = "b6" onclick="courseSelect(event)"></p>
					<p id = "b7" onclick="courseSelect(event)"></p>
					
					<p id = "b8" onclick="courseSelect(event)"></p>
					<p id = "b9" onclick="courseSelect(event)"></p>
					<p id = "b10" onclick="courseSelect(event)"></p>
					<p id = "b11" onclick="courseSelect(event)"></p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="approvedLeft"  onclick = "aLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="approvedRight" onclick = "aRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>
			
			<div class = "electives_course">
				<div id = "electives3">
					<h3></h3></div>

				<div class = "course_tag_electives ense_course_tag" id = "approvedCourse">
					<p id = "c0" onclick="courseSelect(event)"></p>
					<p id = "c1" onclick="courseSelect(event)"></p>
					<p id = "c2" onclick="courseSelect(event)"></p>
					<p id = "c3" onclick="courseSelect(event)"></p>

					<p id = "c4" onclick="courseSelect(event)"></p>
					<p id = "c5" onclick="courseSelect(event)"></p>
					<p id = "c6" onclick="courseSelect(event)"></p>
					<p id = "c7" onclick="courseSelect(event)"></p>
					
					<p id = "c8" onclick="courseSelect(event)"></p>
					<p id = "c9" onclick="courseSelect(event)"></p>
					<p id = "c10" onclick="courseSelect(event)"></p>
					<p id = "c11" onclick="courseSelect(event)"></p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="approvedLeft"  onclick = "aLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="approvedRight" onclick = "aRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>
			
			<script>
				// showElectives();
			</script>
			
			
			<div class = "electives_course enel_course">
				<h3>All Other Course Electives:</h3>
				<div class = "course_tag_electives enel_course_tag" id = "all_course_tag">
					<p id = "all0" onclick="courseSelect(event)"></p>
					<p id = "all1" onclick="courseSelect(event)"></p>
					<p id = "all2" onclick="courseSelect(event)"></p>
					<p id = "all3" onclick="courseSelect(event)"></p>

					<p id = "all4" onclick="courseSelect(event)"></p>
					<p id = "all5" onclick="courseSelect(event)"></p>
					<p id = "all6" onclick="courseSelect(event)"></p>
					<p id = "all7" onclick="courseSelect(event)"></p>
					
					<p id = "all8" onclick="courseSelect(event)"></p>
					<p id = "all9" onclick="courseSelect(event)"></p>
					<p id = "all10" onclick="courseSelect(event)"></p>
					<p id = "all11" onclick="courseSelect(event)"></p>
				</div>
				<div>
					<button class="left_arrow" id ="allCourseLeft" onclick = "allLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="allCourseRight" onclick = "allRight()"><i class='fas fa-angle-right'></i></button>
				</div>
			</div>
			
			
		</section>
	</div>
</body>
<footer>
    <script src="js/main.js"></script>
	<script type="text/javascript" src="js/academicDefault.js"></script>
    <p class="copyright">Copyright &copy; Sep. 2020 to
        <script>document.write(new Date().getFullYear())</script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
        <cite>
            Credit: 
        </cite>
    </p>
    <p class="info-link"><a href="homePage.php">About Us</a></p>
</footer>

