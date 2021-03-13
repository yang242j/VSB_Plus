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
        <a href="https://www.uregina.ca"><img src="img/logo.png" class="logo" alt="UofR"></a>
        <h1>Visual Schedule Builder Plus</h1>
    </header>

    <nav>
        <div class="nav-right">
            <a id="usertext" onclick="toogleDisplay('addon-menu')"><?php echo htmlspecialchars(
                $_SESSION["name"]
            ); ?></a>
            <div class="hidden" id="addon-menu">
                <a><?php echo htmlspecialchars($_SESSION["sid"]); ?></a>
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
                <button class="dropbtn" onclick="toogleDisplay('dropdown-content')">Academic Schedule Builder</button>
                <div id="dropdown-content" class="dropdown-content hidden">
                    <a class="academicList" href="academicBuilder_Main.php">General Student Status</a>
                    <a class="academicList" href="academicBuilder_Default.php">Default Schedule</a>
                    <a class="academicList" href="academicBuilder_Builder.php">Customized Schedule</a>
                </div>
            </div>
            <a class="session-required" href="semesterBuilder.php">Semester Schedule Builder</a>
            <a class="" href="courseDB.php">Course List Database</a>
        </nav>
    </nav>
    
	<div class="container">
		<section id = "block" class = "terms">
			<h2>Default Schedule</h2>
			<div id = "autoscroll">
				<div class = "termGrid" id = "term1">
					<div class = "tittle" style="grid-area: title;"><h2>Term1:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards">
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
					<div class = "tittle" style="grid-area: title;"><h2>Term2:</h2></div>
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
					<div class = "tittle" style="grid-area: title;"><h2>Term3:</h2></div>
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
					<div class = "tittle" style="grid-area: title;"><h2>Term4:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term5">
					<div class = "tittle" style="grid-area: title;"><h2>Term5:</h2></div>
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
					<div class = "tittle" style="grid-area: title;"><h2>Term6:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term7">
					<div class = "tittle" style="grid-area: title;"><h2>Term7:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term8">
					<div class = "tittle" style="grid-area: title;"><h2>Term8:</h2></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
					<div class = "course_cards"></div>
				</div>
				<div class = "termGrid" id ="term9">
					<div class = "tittle" style="grid-area: title;"><h2>Term9:</h2></div>
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
			<div class = "electives_course ense_course">
				<h3>ENSE:</h3>

				<div class = "course_tag_electives ense_course_tag" id = "approvedCourse">
					<p id = "ense0">ENSE 271</p>
					<p id = "ense1">ENSE 271</p>
					<p id = "ense2">ENSE 271</p>
					<p id = "ense3">ENSE 271</p>

					<p id = "ense4">ENSE 271</p>
					<p id = "ense5">ENSE 271</p>
					<p id = "ense6">ENSE 271</p>
					<p id = "ense7">ENSE 271</p>
					
					<p id = "ense8">ENSE 271</p>
					<p id = "ense9">ENSE 271</p>
					<p id = "ense10">ENSE 271</p>
					<p id = "ense11">ENSE 271</p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="approvedLeft"  onclick = "aLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="approvedRight" onclick = "aRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>

			<div class = "electives_course cs_course">
				<h3>CS:</h3>
				<div class = "course_tag_electives cs_course_tag" id = "not_completed_tag">
					<!-- <p id = "nct0" onclick="alert(courseInfo())">ENSE 271</p>-->
					<p id = "cs0">ENSE 271</p>
					<p id = "cs1">ENSE 271</p>
					<p id = "cs2">ENSE 271</p>
					<p id = "cs3">ENSE 271</p>

					<p id = "cs4">ENSE 271</p>
					<p id = "cs5">ENSE 271</p>
					<p id = "cs6">ENSE 271</p>
					<p id = "cs7">ENSE 271</p>
					
					<p id = "cs8">ENSE 271</p>
					<p id = "cs9">ENSE 271</p>
					<p id = "cs10">ENSE 271</p>
					<p id = "cs11">ENSE 271</p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="notCompletedLeft" onclick = "nctLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="notCompletedRight" onclick = "nctRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>
			
			<div class = "electives_course enel_course">
				<h3>ENEL:</h3>
				<div class = "course_tag_electives enel_course_tag" id = "electives_tag">
					<p id = "enel0">ENSE 271</p>
					<p id = "enel1">ENSE 271</p>
					<p id = "enel2">ENSE 271</p>
					<p id = "enel3">ENSE 271</p>

					<p id = "enel4">ENSE 271</p>
					<p id = "enel5">ENSE 271</p>
					<p id = "enel6">ENSE 271</p>
					<p id = "enel7">ENSE 271</p>
					
					<p id = "enel8">ENSE 271</p>
					<p id = "enel9">ENSE 271</p>
					<p id = "enel10">ENSE 271</p>
					<p id = "enel11">ENSE 271</p>
				</div>
				<!--<div>
					<button class="left_arrow" id ="notCompletedLeft" onclick = "enctLeft()"><i class='fas fa-angle-left'></i></button>
					<button class="right_arrow" id ="notCompletedRight" onclick = "enctRight()"><i class='fas fa-angle-right'></i></button>
				</div>-->
			</div>
		</section>
	</div>
</body>
<footer>
    <script src="js/main.js"></script>
    <p class="copyright">Copyright &copy; Sep. 2020 to
        <script>document.write(new Date().getFullYear())</script> UofR VSB_Plus Capstone Group All Rights Reserved<br>
        <cite>
            Credit: 
        </cite>
    </p>
    <p class="info-link"><a href="homePage.php">About Us</a></p>
</footer>

